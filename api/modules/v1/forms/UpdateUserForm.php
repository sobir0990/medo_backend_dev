<?php


namespace api\modules\v1\forms;


use common\models\Profile;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\web\UnprocessableEntityHttpException;

class UpdateUserForm extends Model
{
    public $id;
    public $first_name;
    public $last_name;
    public $image;
    public $middle_name;
    public $email;
    public $old_password;
    public $password;
    public $gender;
    public $birth;
    public $region_id;
    public $city_id;
    public $category_id;

    public function rules()
    {
        return [
            [['first_name', 'middle_name', 'last_name', 'email', 'old_password', 'password', 'image'], 'string'],
            [['city_id', 'gender', 'region_id', 'birth'], 'integer'],
            ['category_id', 'safe'],
            ['email', 'email'],
        ];
    }

    public function init()
    {
        $user = User::findOne($this->id);
        $this->setAttributes($user->attributes);

        $profile = Profile::findOne(['user_id' => $user->id]);
        if (!$profile instanceof Profile) {
            $profile = new Profile();
        }
        $this->setAttributes($profile->attributes);
    }

    /**
     * @return array|bool
     * @throws \yii\base\Exception
     */
    public function update()
    {
        $user = User::findOne(Yii::$app->user->identity->id);
        if (!$this->validate()) {
            return false;
        }

        if ($this->old_password != null && $this->password != null) {
            if ($user->validatePassword($this->old_password)) {
                $user->setPassword($this->password);
            } else {
                throw new UnprocessableEntityHttpException('Wrong old password', 3);
            }
        }
        if (!$this->_updateProfile($user)){
            throw new \DomainException('No created profile');
        }
        if (!$user->save()) {
            return $user->errors;
        }

    }

    public function _updateProfile($user){
        $model = Profile::findOne(['user_id' => $user->id]);
        $model->setAttributes($this->attributes,'');
        $model->user_id = $user->id;
        $model->image = $this->image;
        return $model->save();

    }

}
