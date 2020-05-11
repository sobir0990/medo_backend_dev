<?php


namespace api\modules\v1\forms;


use common\components\Categories;
use common\filemanager\models\Files;
use common\models\Company;
use common\models\User;
use common\models\Vacation;
use common\models\VacationCategories;
use common\modules\category\models\Category;
use yii\base\Model;
use yii\web\UnauthorizedHttpException;
use yii\web\UploadedFile;

class CreateVacationForm extends Model
{

    public $category_id;
    public $profile_id;
    public $company_id;
    public $place_id;
    public $type;
    public $salary;
    public $salary_to;
    public $title;
    public $text;
    public $files;

    public function rules()
    {
        return [
            [['company_id', 'place_id', 'type', 'profile_id', 'salary', 'salary_to'], 'integer'],
            [['title', 'text'], 'string', 'max' => 254],
            [['category_id', 'files'], 'safe']
        ];
    }

    public function create()
    {
        $user = User::authorize();
        $model = new Vacation();
        if (!$user) {
            throw new UnauthorizedHttpException('нет право');
        }
        $model->company_id = $this->company_id;
        $model->profile_id = $user->profile->id;
        $model->place_id = $this->place_id;
        $model->salary = $this->salary;
        $model->files = $this->files;
        $model->salary_to = $this->salary_to;
        $model->title = $this->title;
        $model->text = $this->text;
        $model->category_id = $this->category_id;
        $model->type = $this->type;
        $model->save();
        $this->createCategory($model);
        return $model;

    }

    public function createCategory($model)
    {
        $category = new VacationCategories();
        $category->setAttributes($this->attributes, '');
        $category->category_id = $this->category_id;
        $category->vacation_id = $model->id;
        $category->save();
    }


}
