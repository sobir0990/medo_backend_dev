<?php


namespace api\modules\v1\forms;


use common\filemanager\models\Files;
use common\models\Profile;
use common\models\Resume;
use common\models\ResumeCategories;
use common\models\User;
use common\models\VacationCategories;
use common\modules\categories\models\Categories;
use common\modules\category\models\Category;
use Yii;
use yii\base\Model;
use common\modules\langs\components\Lang;
use yii\helpers\ArrayHelper;
use yii\web\UnauthorizedHttpException;
use yii\web\UploadedFile;

class CreateResumeForms extends Model
{

    public $title;
    public $files;
    public $salary;
    public $name;
    public $text;
    public $phone;
    public $category_id;

    public $profile_id;
    public $salary_to;
    public $status;
    public $created_at;
    public $updated_at;

    public function rules()
    {
        return [
            [['profile_id', 'salary', 'salary_to', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['profile_id', 'salary', 'status', 'created_at', 'updated_at', 'category_id'], 'integer'],
            [['title', 'files', 'text', 'name'], 'string'],
            [['phone'], 'string', 'max' => 18],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['profile_id' => 'id']],];
    }

    public function create()
    {

        $user = User::authorize();
        $resume = new Resume();
        $resume->setAttributes($this->attributes);
        $resume->status = Resume::STATUS_WAITING;
        $resume->profile_id = $user->profile->id;
        $resume->title = $this->title;
        $resume->files = $this->files;
        $resume->salary = $this->salary;
        if (!$resume->save()){
            Yii::$app->response->setStatusCode(422);
        }

        if (is_array($this->category_id)) {
            $resume->unlinkAll('categories', true);
            foreach ($this->category_id as $item) {
                $cat = Category::findOne($item);
                $resume->link('categories', $cat);
            }
        } else {
            $resume->unlinkAll('categories', true);
            $cat = Category::findOne($this->category_id);
            $resume->link('categories', $cat);
        }
        return $resume;
    }


}
