<?php

namespace api\modules\v1\forms;

use common\filemanager\models\Files;
use common\models\Company;
use common\models\CompanyCategories;
use common\models\Post;
use common\models\PostCategories;
use common\models\Profile;
use common\models\User;
use common\modules\category\models\Category;
use yii\base\Model;
use yii\web\UnauthorizedHttpException;
use yii\web\UploadedFile;

class CreateCompanyForms extends Model
{

    public $profile_id;
    public $type;
    public $name_uz;
    public $name_ru;
    public $page_uz;
    public $page_ru;
    public $description_uz;
    public $description_ru;
    public $region_id;
    public $city_id;
    public $phone;
    public $status;
    public $image;
    public $company_id;
    public $category_id;

    public function rules()
    {
        return [
            [['profile_id', 'type', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['profile_id', 'type', 'status', 'city_id', 'region_id', 'created_at', 'updated_at'], 'integer'],
            [['category_id'], 'safe'],
            [['page_uz', 'page_ru'], 'string'],
            [['name_uz', 'name_ru', 'image', 'description_uz', 'description_ru', 'address'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    public function userValidate(){
        $user = User::authorize();

    }


    public function create()
    {
        $user = User::authorize();
        $model = new Company();
        $model->setAttributes($this->attributes, '');
        $model->status = Company::STATUS_WAITING;
        $model->profile_id = $user->profile->id;
        $model->image = $this->image;
        $model->save();
        if (empty($this->category_id)) {
            return $model;
        }
        if (is_array($this->category_id)) {
            $model->unlinkAll('categories', true);
            foreach ($this->category_id as $item) {
                $cat = Category::findOne($item);
                $model->link('categories', $cat);
            }
        } else {
            $model->unlinkAll('categories', true);
            $cat = Category::findOne($this->category_id);
            $model->link('categories', $cat);
        }
        return $model;
    }


}
