<?php

namespace api\modules\v1\forms;

use common\filemanager\models\Files;
use common\models\Profile;
use common\models\User;
use common\modules\categories\behaviors\CategoryModelBehavior;
use common\modules\categories\models\Categories;
use Yii;
use yii\base\Model;
use yii\web\UnprocessableEntityHttpException;
use yii\web\UploadedFile;

class ProfileUpdateForm extends Model
{
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
    public $profession_id;
    public $bio;
    public $city_id;
    public $category_id;

    public function behaviors()
    {
        return [
            'category_model' => [
                'class' => CategoryModelBehavior::class,
                'attribute' => '_category',
                'separator' => ',',
            ],
        ];
    }

    public function rules()
    {
        return [
            [['first_name', 'middle_name', 'last_name', 'bio', 'email', 'old_password', 'password', 'image'], 'string'],
            [['city_id', 'gender', 'region_id', 'profession_id', 'birth'], 'integer'],
            ['category_id', 'safe'],
            ['email', 'email'],
        ];
    }

    public function update()
    {
        $model = User::findOne(Yii::$app->user->identity->id);
        $profile = Profile::findOne(['user_id' => $model->id]);

        if (!$this->validate()) {
            Yii::$app->response->setStatusCode('422');
            return $this->getErrors();
        }

        if ($this->old_password != null && $this->password != null) {
            if ($model->validatePassword($this->old_password)) {
                $model->setPassword($this->password);
            } else {
                throw new UnprocessableEntityHttpException('Wrong old password', 3);
            }
        }
        $profile->first_name = $this->first_name ?: $profile->first_name;
        $profile->last_name = $this->last_name ?: $profile->last_name;
        $profile->middle_name = $this->middle_name ?: $profile->middle_name;
        $profile->gender = $this->gender ?: $profile->gender;
        $model->email = $this->email ?: $model->email;
        $profile->birth = $this->birth ?: $profile->birth;
        $profile->region_id = $this->region_id ?: $profile->region_id;
        $profile->city_id = $this->city_id ?: $profile->city_id;
        $profile->profession_id = $this->profession_id ?: $profile->profession_id;
        $profile->bio = $this->bio ?: $profile->bio;
        $profile->image = $this->image ?: $profile->image;


        if ($model->save() && $profile->save()) {
            if (is_array($this->category_id)) {
                $profile->unlinkAll('categories', true);
                foreach ($this->category_id as $item) {
                    $cat = Categories::findOne($item);
                    $profile->link('categories', $cat);
                }
            }
            return array_merge($model->toArray(), ['profile' => $profile->toArray()]);
        } else {
            Yii::$app->response->setStatusCode(422);
            return $this->getErrors();
        }
    }
}
