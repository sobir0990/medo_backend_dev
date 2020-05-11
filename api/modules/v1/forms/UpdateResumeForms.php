<?php


namespace api\modules\v1\forms;


use common\models\Profile;
use common\models\Resume;
use common\models\ResumeCategories;
use common\models\User;
use Yii;
use yii\base\Model;

class UpdateResumeForms extends Model
{

    public $id;
    public $files;
    public $profile_id;
    public $title;
    public $description;
    public $salary;
    public $salary_to;
    public $name;
    public $place_id;
    public $text;
    public $phone;
    public $experience;
    public $category_id;
    public $status;
    public $created_at;
    public $updated_at;


    public function init()
    {
        $model = Resume::findOne($this->id);
        if (!$model instanceof Resume) {
            $model = new Resume();
        }
        $this->setAttributes($model->attributes);

        $category = ResumeCategories::findOne(['resume_id' => $model->id]);
        if (!$category instanceof ResumeCategories) {
            $category = new ResumeCategories();
        }
        $category->setAttributes($category->attributes);
        parent::init();
    }

    public function rules()
    {
        return [
            [['profile_id', 'salary', 'salary_to', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['profile_id', 'salary', 'status', 'place_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'files', 'text', 'experience', 'description', 'name'], 'string'],
            [['phone'], 'string', 'max' => 18],
//            [['files'], 'file', 'extensions' => 'doc, docx, jpeg, jpg, png, pdf'],
            [['category_id'], 'safe'],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['profile_id' => 'id']],];
    }


    public function update()
    {
        $model = Resume::findOne($this->id);
        $user_id = User::authorize();
        if ($user_id->profile->id != $model->profile_id) {
            Yii::$app->response->setStatusCode(401);
            return ['status' => 'error', 'message' => 'You don\'t have permission to change this Resume'];
        }
        $model->setAttributes($this->attributes,'');
        $model->status = Resume::STATUS_WAITING;
        $model->profile_id = $user_id->profile->id;
        $model->files = $this->files;
        $model->save();
        return $model;
    }


}
