<?php

namespace api\modules\v1\forms;

use common\models\Tokens;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use yii\web\UnprocessableEntityHttpException;

/**
 * Signin form
 */
class SigninForm extends Model
{
    public $login;
    public $password;
    public $rememberMe = true;

    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @throws UnprocessableEntityHttpException
     * @throws NotFoundHttpException
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     * @throws UnprocessableEntityHttpException
     * @throws NotFoundHttpException
     */
    public function signin()
    {
        if ($this->validate()) {
            $token = new Tokens(['scenario' => Tokens::SCENARIO_CREATE]);
            $token->type = User::TOKEN_LOGIN;
            $token->user_id = $this->_user->id;
            $token->save();

            //   return  $this->getUser()->updateAttributes(['token' => $this->getUser()->generateToken()]);
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

	/**
	 * @param $attributeNames
	 * @return bool
	 */
    public function validateNumer($attributeNames)
    {
        return is_numeric($attributeNames);
    }

    /**
     * Finds user by [[phone]]
     *
     * @return User|false
     * @throws UnprocessableEntityHttpException
     * @throws NotFoundHttpException
     */
    protected function getUser()
    {
        if ($this->_user)
            return $this->_user;
        $phone = $this->login;

		$phone = preg_replace('/\D+/', null, $phone);
        if(!$this->validateNumer($phone)){
			throw new UnprocessableEntityHttpException('Phone must be in number');
        }


        $this->_user = User::find()->where(['phone' => $phone])->orWhere(['username' => $phone])->one();
        if ($this->_user !== null) {
            if ($this->_user->status !== User::STATUS_ACTIVE) {
                $this->addError('login', 'Account unconfirmed');
                Yii::$app->response->setStatusCode(415);
            } else {
                return $this->_user;
            }
        }
        $this->addError('login', 'Пользователь не найден');
        return false;
    }
}
