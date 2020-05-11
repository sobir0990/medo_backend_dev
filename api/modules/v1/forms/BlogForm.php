<?php

namespace api\modules\v1\forms;

use common\filemanager\models\Files;
use common\models\Post;
use common\models\PostCategories;
use common\models\User;
use yii\base\Model;
use yii\web\UnauthorizedHttpException;
use yii\web\UploadedFile;

class BlogForm extends Model
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
    public $company_id;
    public $category_id;

    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['image', 'lang', 'title', 'files', 'text', 'description'], 'string'],
            [['lang', 'publish_time', 'category_id','company_id', 'type'], 'integer']
        ];
    }

    public function create()
    {
//        if (!$this->validate()) {
//            return false;
//        }

        $user_id = User::authorize();
        if ($this->slug) {
            $blog = Post::findOne(['slug' => $this->slug]);
            if ($blog->status === Post::STATUS_ACTIVE)
                throw new UnauthorizedHttpException('Blog post already published');
        } else $blog = new Post();


        if ($blog->isNewRecord) {
            $blog->type = $this->type;
            $blog->lang = $this->lang;
            $blog->files = $this->files;
            $blog->publish_time = $this->publish_time;
            $blog->profile_id = \Yii::$app->user->identity->profile->id;
            $blog->company_id = $this->company_id;
        }

        $blog->title = $this->title;
        $blog->description = $this->description;
        $blog->text = $this->text;
        $blog->files = $this->files;
        $blog->publish_time = $this->publish_time;
        $blog->status = Post::STATUS_WAITING;
        $blog->profile_id = $user_id->profile->id;
        $blog->save();
        $this->createCategory($blog);
        return $blog;
    }

    public function createCategory($blog){
        $category = new PostCategories();
        $category->setAttributes($this->attributes,'');
        $category->category_id = $this->category_id;
        $category->post_id = $blog->id;
        $category->save();
    }

}
