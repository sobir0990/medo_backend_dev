<?php


namespace api\modules\v1\forms;


use common\models\Company;
use common\models\Profile;
use common\models\User;
use common\modules\category\models\Category;
use yii\base\Model;

class UpdateCompanyForms extends Model
{

    public $profile_id;
    public $id;
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
    public $categories;

    public function rules()
    {
        return [
            [['profile_id', 'type', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['profile_id', 'type', 'status', 'city_id', 'region_id', 'created_at', 'updated_at'], 'integer'],
            [['category_id'], 'safe'],
            [['page_uz', 'page_ru'], 'string'],
            [['name_uz', 'name_ru', 'image', 'description_uz', 'description_ru', 'address', 'category'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    public function init()
    {
        $model = Company::findOne($this->id);
        if (!$model instanceof Company) {
            $model = new Company();
        }
        $this->setAttributes($model->attributes);
        parent::init();
    }


    public function update()
    {
        $user_id = User::authorize();
        $model = Company::findOne($this->id);
        $model->setAttributes($this->attributes, '');
        $model->image = $this->image;
        if (empty($model->profile_id)) {
            $model->profile_id = $user_id->profile->id;
        }
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
