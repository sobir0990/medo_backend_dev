<?php


namespace api\modules\v1\forms;


use common\models\Product;
use common\models\Profile;
use common\models\Resume;
use common\models\User;
use common\modules\category\models\Category;
use yii\base\Model;

class CreateProductForms extends Model
{

    public $title_ru;
    public $title_uz;
    public $content_ru;
    public $content_uz;
    public $price;
    public $files;
    public $images;
    public $type;
    public $company_id;
    public $profile_id;
    public $category_id;
    public $categories;

    public function rules()
    {
        return [
            [['profile_id', 'price', 'type', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['profile_id', 'type', 'status', 'profile_id', 'created_at', 'updated_at', 'category_id', 'company_id'], 'integer'],
            [['title_ru', 'title_uz', 'files', 'content_ru', 'content_uz', 'images'], 'string'],
            [['categories', 'category_id'], 'safe'],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['profile_id' => 'id']],];
    }

    public function create()
    {
        $user = User::authorize();
        $product = new Product();
        $product->setAttributes($this->attributes, '');
        $product->status = Resume::STATUS_WAITING;
        $product->profile_id = $user->profile->id;
        $product->company_id = $this->company_id;
        $product->files = $this->files;

        if ($this->type == Product::TYPE_ANNOUNCE) {
            if ($this->title_ru == null) {
                $product->title_ru = $this->title_uz;
            } elseif ($this->title_uz == null) {
                $product->title_uz = $this->title_ru;
            }

            if ($this->content_ru == null) {
                $product->content_ru = $this->content_uz;
            } elseif ($this->content_uz == null) {
                $product->content_uz = $this->content_ru;
            }
        } elseif ($this->type == Product::TYPE_PRODUCT) {
            $product->title_ru = $this->title_ru;
            $product->title_uz = $this->title_uz;
            $product->content_ru = $this->content_ru;
            $product->content_uz = $this->content_uz;

        }
        $product->images = $this->images;
        $product->save();
        if (empty($this->category_id)) {
            return $product;
        }
        if (is_array($this->category_id)) {
            $product->unlinkAll('categories', true);
            foreach ($this->category_id as $item) {
                $cat = Category::findOne($item);
                $product->link('categories', $cat);
            }
        } else {
            $product->unlinkAll('categories', true);
            $cat = Category::findOne($this->category_id);
            $product->link('categories', $cat);
        }
        return $product;
    }


}
