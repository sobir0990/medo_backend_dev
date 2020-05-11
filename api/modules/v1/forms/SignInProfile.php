<?php


namespace api\modules\v1\forms;


use common\models\Tokens;
use common\models\User;
use yii\base\Model;
use Yii;

class SignInProfile extends Model
{

    public $phone;
    public $password;
    public $expire;

    /**
     * @var User
     */
    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // phone and password are both required
            [['phone', 'password'], 'required'],
            // rememberMe must be a boolean value
            [['phone', 'password'], 'string'],
            [['expire'], 'tokenValidate']
        ];
    }

    public function tokenValidate()
    {
        $model = Tokens::find()->andWhere(['>', 'expire', time()])
            ->andWhere(['status' => User::STATUS_ACTIVE])
            ->one();
        if ($model) {
            \Yii::$app->response->setStatusCode(422);
        }
        return true;
    }


    /**
     * @return array|bool|Tokens|\yii\db\ActiveRecord|null
     * @throws \yii\base\Exception
     */
    public function signIn()
    {
        if (!$this->validate()) {
            return $this->getErrors();
        }

        $user = User::find()->andWhere(['phone' => $this->phone])->one();

        if (!is_object($user)) {
            Yii::$app->response->setStatusCode(403);
        }

        $model = Tokens::findOne(['user_id' => $user->id]);

        if (!is_object($model)) {
            $token = new Tokens();
            $token->user_id = $user->id;
            $token->expire = time() + Tokens::EXPIRE_TIME;
            $token->status = Tokens::STATUS_ACTIVE;
            $token->type = User::TOKEN_LOGIN;
            $token->token = \Yii::$app->security->generateRandomString(64);
            $token->save();
            return $user;
        }

        $model->updateAttributes(['status' => Tokens::STATUS_ACTIVE ]);

        return $user;
    }

}
