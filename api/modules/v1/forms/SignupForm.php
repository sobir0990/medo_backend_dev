<?php

namespace api\modules\v1\forms;

use common\models\Profile;
use common\models\Tokens;
use common\modules\playmobile\models\PhoneConfirmation;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $type;
    public $username;
    public $name;
    public $middle_name;
    public $last_name;
    public $gender;
    public $email;
    public $password;
    public $password_repeat;
    public $region_id;
    public $city;
    public $phone;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'password'], 'required'],
            [['username', 'email', 'phone', 'name',], 'string'],
            [['email', 'phone'], 'my_required'],
            ['email', 'trim'], ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => __('This email address has already registered.')],
            ['phone', 'unique', 'targetClass' => User::class, 'message' => __('This phone has already registered.')],
        ];
    }

    public function my_required($attribute_name, $params)
    {
        if (empty($this->phone) && empty($this->email)) {
            $this->addError($attribute_name, Yii::t('main', 'At least 1 of the field must be filled up properly'));
            return false;
        }
        return true;
    }

    public function validateNumer($attributeNames)
    {
        return is_numeric($attributeNames);
    }

    public function attributeLabels()
    {
        return [
            'type' => Yii::t('main', 'Тип аккаунта'),
            'username' => Yii::t('main', 'Ф. И. О.'),
            'email' => Yii::t('main', 'Электронная почта'),
            'phone' => Yii::t('main', 'Телефон'),
            'password' => Yii::t('main', 'Пароль'),
//			'password_repeat' => Yii::t('main', 'Повторите пароль'),
            'region' => Yii::t('main', 'Регино или Город'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|array|false the saved model or false if saving fails
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        $phone = $this->phone;

        $phone = preg_replace('/\D+/', '', $phone);
        $this->phone = $phone;

        if (!$this->validate()) {
            Yii::$app->response->setStatusCode(422);
            return $this->getErrors();
        }
        $code = rand(1000, 9999);

        $user = new User();
        $user->username = $phone;
        $user->phone = $phone;
        $user->status = User::STATUS_UNCONFIRMED;

        $user->setPassword($this->password);
        $user->generateAuthKey();

        if ($user->save()) {
            $message = \Yii::t("main", "Confirmation code on medo.uz: {code}", ['code' => $code]);
            $confirmation = new PhoneConfirmation();
            $confirmation->phone = $user->phone;
            $confirmation->status = PhoneConfirmation::STATUS_UNCONFIRMED;
            $confirmation->code = (string)$code;
            $confirmation->save();

            \Yii::$app->playmobile->sendSms($user->phone, $message);

            $token = new Tokens(['scenario' => Tokens::SCENARIO_CREATE]);
            $token->type = User::TOKEN_LOGIN;
            $token->status = User::STATUS_UNCONFIRMED;
            $token->user_id = $user->id;
            $token->save();

            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->first_name = $this->name;
            $profile->save();

            return array_merge(
                $user->toArray(),
                ['token' => $token->token]);
        } else {
            Yii::$app->response->setStatusCode(422);
            return $user->getErrors();
        }
    }
}
