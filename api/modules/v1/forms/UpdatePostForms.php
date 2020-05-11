<?php

namespace api\modules\v1\forms;

use common\filemanager\models\Files;
use common\models\Post;
use common\models\PostCategories;
use common\models\User;
use yii\base\Model;
use yii\web\UploadedFile;

class UpdatePostForms extends Model
{

    public $slug;
    public $title;
    public $description;
    public $text;
    public $image;
    public $files;
    public $publish_time;
    public $lang;
    public $type;
    public $category_id;
    public $company_id;


    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['image', 'lang', 'title', 'files', 'text'], 'string'],
            ['category_id', 'safe'],
            [['lang', 'publish_time', 'company_id', 'type'], 'integer']
        ];
    }

    public function update()
    {
        $user_id = User::authorize();
        $blog = Post::findOne(['slug' => $this->slug]);
        if ($blog->isNewRecord) {
            $blog->type = $this->type;
            $blog->lang = $this->lang;
            $blog->publish_time = $this->publish_time;
            $blog->description = $this->description;
            $blog->files = $this->files;
            $blog->profile_id = \Yii::$app->user->identity->profile->id;
            $blog->company_id = $this->company_id;
        }
        if (empty($blog->profile_id)) {
            $blog->profile_id = $user_id->profile->id;
        }
        $blog->title = $this->title;
        $blog->description = $this->description;
        $blog->text = $this->text;
        $blog->files = $this->files;
        $blog->publish_time = $this->publish_time;
        $blog->status = Post::STATUS_WAITING;
        $blog->save();
        if (empty($this->category_id)) {
            return $blog;
        }else{
            $this->updateCategory($blog);
        }
        return $blog;
    }

    public function updateCategory($model){
        $category = PostCategories::findOne(['post_id' => $model->id]);
        $category->setAttributes($this->attributes,'');
        $category->category_id = $this->category_id;
        $category->post_id = $model->id;
        $category->save();
    }


}
