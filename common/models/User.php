<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\web\NotFoundHttpException;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $phone [varchar(18)]
 * @property int $role
 *
 * @property Profile $profile
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $new_password;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_UNCONFIRMED = 2;

    const ROLE_USER = 1;
    const ROLE_DOCTOR = 2;
    const ROLE_REDACTOR = 5;
    const ROLE_MODER = 8;
    const ROLE_ADMIN = 10;

    //Tokens
    const USER_STATUS_DEFAULT = 0;
    const USER_STATUS_BLOCK = -1;
    const TOKEN_EMAIL_CONFIRM = 100;
    const TOKEN_PASSWORD_RESET = 101;
    const TOKEN_LOGIN = 102;
    const USER_LOGOUT = 0;




    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['new_password', 'password_hash', 'password_hash', 'email', 'phone', 'username'], 'string'],
            [['status'], 'integer'],
            ['role', 'default', 'value' => self::ROLE_USER],
            ['status', 'default', 'value' => self::STATUS_UNCONFIRMED],
        ];
    }

    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id',
            'username',
            'phone',
            'status',
            'email',
            'role',
            'profile',
            'token',
            'productCount',
        ];
    }

    /**
     * @return array
     */
    public function extraFields()
    {
        return ArrayHelper::merge(parent::extraFields(), [
            'reviews',
            'posts',
            'profile',
        ]);
    }

    public function getProductCount()
    {
        /** @var Profile $profile */
        $profile = $this->profile;
        $count = $profile->getProducts()->andWhere(['product.status' => Product::STATUS_ACTIVE])->count();
        if (!is_object($count)){
            return null;
        }
        return $count;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        //throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
        $user = User::find()->joinWith('tokens')->where(['token' => $token])->one();
        return $user;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByPhone($phone)
    {
        return static::findOne(['phone' => $phone]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTokens()
    {
        return $this->hasMany(Tokens::class, ['user_id' => 'id']);
    }

    public function getToken()
    {
        return Tokens::find()->joinWith('user')
            ->andWhere(['tokens.status' => Tokens::STATUS_ACTIVE, 'tokens.type' => User::TOKEN_LOGIN, 'user.id' => $this->getId()])
            ->andWhere(['>', 'expire', time()])
            ->one();
    }

    public function logout()
    {
        /**
         * @var Tokens $token
         */
        $token = $this->token;
        $token->setStatus(self::USER_LOGOUT);
        $token->save();
    }

    public static function findByEAuthAccessTokenResponse($response)
    {
        $email = $response["email"];
//		$photo_id = Utils::downloadPhotoFromUrl($response["avatar"]);
        $hasAlready = static::findByEmail($email);

        switch ($response["social"]) {
            case 'facebook':
                $username = "f" . $response["id"];
                break;
            case 'google':
                $username = "g" . $response["id"];
                break;
            default:
                $username = "g" . $response["id"];
                break;
        }

        $hasAlreadyFbId = static::findOne(['full_name' => $username]);

        if (!isset($hasAlready) && !isset($hasAlreadyFbId)) {
            $newUser = new User();

            $newUser->full_name = $username;
            $newUser->setPassword(\Yii::$app->security->generateRandomString());
            $newUser->status = User::STATUS_UNCONFIRMED;
            $newUser->email = $response["email"];
//				$model->setName(Yii::$app->request->post("name"));
//				$model->setPhone(Yii::$app->request->post('register')["phone"]);

            if ($newUser->save()) {
                $newProfile = new Profile();
                $newProfile->user_id = $newUser->id;
//				$newProfile->image = $photo_id;
                $newProfile->save();
                $attributes = static::findByEmail($email);
            }
        } else {
            if (isset($hasAlready)) {
                $attributes = $hasAlready;
            } else {
                $attributes = $hasAlreadyFbId;
            }
        }

//		$attributes->profile->image = $photo_id;
        $attributes->full_name = $response["name"];
        $attributes->last_login = time();
        $attributes->save(true);
        $token = new Tokens(['scenario' => Tokens::SCENARIO_CREATE]);
        $token->type = User::TOKEN_LOGIN;
        $token->user_id = $attributes->id;
        $token->save();

        return new self($attributes);
    }

    /**
     * @return array|bool|User|ActiveRecord|IdentityInterface|null
     * @throws NotFoundHttpException
     */
    public static function authorize()
    {
        if ($auth = Yii::$app->request->headers->get('Authorization')) {
            $token = str_replace('Bearer ', '', $auth);
            if ($user = static::findIdentityByAccessToken($token))
                return $user;
            else throw new NotFoundHttpException('User not found');
        }
        return false;
    }

    public static function findAuthId()
    {
        if ($auth = Yii::$app->request->headers->get('Authorization')) {
            $token = str_replace('Bearer ', '', $auth);
            if ($user = static::findIdentityByAccessToken($token))
                return $user;
        }
        return true;
    }

    /**
     * @param null $user_id
     * @return User|null
     */
    public static function getUserById($user_id = null)
    {
        if ($user_id == null) {
            $user_id = Yii::$app->user->id;
        }

        $user = self::findOne($user_id);
        if ($user instanceof User) {
            return $user;
        }
        throw new \DomainException('User not found', 422);
    }

    public static function phone($phone)
    {
        $phone = str_replace(' ', '', $phone);
        $phone = str_replace('+', '', $phone);
        $phone = str_replace('-', '', $phone);
        return $phone;
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'id']);
    }

    /**
     * Является ли пользователь администратором.
     *
     * @return boolean
     * @deprecated 2.0.0
     *             Используется в устаревшем контроле доступа по ролям.
     */
    public function isAdmin()
    {
        return isset($this->getUserRoles()['admin']);
    }

    /**
     * Является ли пользователь менеджером.
     *
     * @return boolean
     * @deprecated 2.0.0
     *             Используется в устаревшем контроле доступа по ролям.
     */
    public function isManager()
    {
        return isset($this->getUserRoles()['manager']);
    }

    /**
     * Является ли пользователь рядовым пользователем
     *
     * @return boolean
     * @deprecated 2.0.0
     *             Используется в устаревшем контроле доступа по ролям.
     */
    public function isUser()
    {
        return isset($this->getUserRoles()['user']);
    }

    /**
     * Роли назначенные пользователю.
     *
     * @return \yii\rbac\Role[]
     */
    public function getUserRoles()
    {
        return Yii::$app->authManager->getRolesByUser($this->id);
    }


}
