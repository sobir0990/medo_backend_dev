<?php


namespace api\modules\v1\forms;


use common\models\User;
use common\models\Vacation;
use common\models\VacationCategories;
use yii\base\Model;
use yii\web\UnauthorizedHttpException;

class UpdateVacation extends Model
{

    public $id;
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
            [['category_id', 'company_id', 'place_id', 'type', 'profile_id', 'salary', 'salary_to'], 'integer'],
            [['title', 'text'], 'string', 'max' => 254],
            [['files'], 'safe'],
            [['profile_id'], 'profileValidate']
        ];
    }

    public function init()
    {
        $model = Vacation::findOne($this->id);
        if (!$model instanceof Vacation) {
            $model = new Vacation();
        }
        $this->setAttributes($model->attributes);
        parent::init();
    }

    public function profileValidate(){
        $user = User::authorize();
        if (!$user) {
            throw new UnauthorizedHttpException('нет право');
        }
        return true;
    }

    public function update()
    {

        if (!$this->validate()) {
            return false;
        }

        $model = Vacation::findOne($this->id);
        $model->setAttributes($this->attributes);
        $model->status = Vacation::STATUS_WAITING;
        $model->files = $this->files;
        $model->save();
        if (empty($this->category_id)) {
            return $model;
        }else{
            $this->updateCategory($model);
        }
        return $model;
    }

    public function updateCategory($model){
        $category = VacationCategories::findOne(['vacation_id' => $model->id]);
        $category->setAttributes($this->attributes,'');
        $category->category_id = $this->category_id;
        $category->vacation_id = $model->id;
        $category->save();
    }
}
