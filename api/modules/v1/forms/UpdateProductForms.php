<?php


namespace api\modules\v1\forms;


use common\filemanager\models\Files;
use common\models\Product;
use common\models\Profile;
use common\models\User;
use common\modules\category\models\Category;
use yii\base\Model;
use yii\web\UploadedFile;

class UpdateProductForms extends Model
{

    public $id;
    public $title_ru;
    public $title_uz;
    public $content_ru;
    public $content_uz;
    public $price;
    public $status;
    public $files;
    public $created_at;
    public $updated_at;
    public $images;
    public $type;
    public $company_id;
    public $profile_id;
    public $category_id;

    public function rules()
    {
        return [
            [['profile_id', 'price', 'type', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['profile_id', 'type', 'status', 'profile_id', 'created_at', 'updated_at', 'category_id', 'company_id'], 'integer'],
            [['title_ru', 'title_uz', 'content_ru', 'content_uz'], 'string'],
            [['category_id', 'images', 'files'], 'safe'],
            [['id'], 'integer'],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['profile_id' => 'id']],];
    }

    public function init()
    {
        $model = Product::findOne($this->id);
        if (!$model instanceof Product) {
            $model = new Product();
        }
        $this->setAttributes($model->attributes);
        parent::init();
    }


    public function update()
    {
        $user_id = User::authorize();
        $model = Product::findOne($this->id);
        $model->setAttributes($this->attributes, '');
        if ($this->type == Product::TYPE_ANNOUNCE) {
            if ($this->title_ru == null) {
                $model->title_ru = $this->title_uz;
            } elseif ($this->title_uz == null) {
                $model->title_uz = $this->title_ru;
            }

            if ($this->content_ru == null) {
                $model->content_ru = $this->content_uz;
            } elseif ($this->content_uz = null) {
                $model->content_uz = $this->content_ru;
            }
        } elseif ($this->type == Product::TYPE_PRODUCT) {
            $model->title_ru = $this->title_ru;
            $model->title_uz = $this->title_uz;
            $model->content_ru = $this->content_ru;
            $model->content_uz = $this->content_uz;

        }
        $model->files = $this->files;
        $model->category_id = $this->category_id;
        $model->status = Product::STATUS_WAITING;
        if (empty($model->profile_id)) {
            $model->profile_id = $user_id->profile->id;
        }
        $model->save();

        if (empty($this->category_id)) {
            return $model;
        }
        return $model;
    }

}
