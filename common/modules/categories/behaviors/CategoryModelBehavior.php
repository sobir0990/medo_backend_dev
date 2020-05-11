<?php
namespace common\modules\categories\behaviors;

/**
 *
 * @author Jakhar <javhar_work@mail.ru>
 *
 */

use common\modules\categories\models\Categories;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class CategoryModelBehavior
 * @package jakharbek\categories\behaviors
 * Поведение который добавлаются к behaviors к модели Active Record (Model)
 *
 * @example
 *
 * ```php
        use jakharbek\categories\behaviors\CategoryModelBehavior;

        class Posts extends ActiveRecord
        {
            private $_categoriesform;

            public function behaviors()
            {
                 ...
                        'category_model'=> [
                        'class' => CategoryModelBehavior::className(),
                        'attribute' => 'categoriesform',
                        'separator' => ',',
                        ],
                 ...
            }

            ...

            public function getCategoriesform(){
                return $this->_categoriesform;
            }
            public function setCategoriesform($value){
                return $this->_categoriesform = $value;
            }
        }
 *
 *
 * ```
 */
class CategoryModelBehavior extends Behavior
{
    /**
     * @var string
     * данные который используется в форме (Active Form)
     */
    public $attribute = "categoriesform";
    /**
     * @var string
     * тип данных или сепаратор который разделает данные
     * типы array
     * сепаратор который разделает данные
     */
    public $separator = "array";

    //version 2
    //FOR PUBLIC
    //example /posts/default/category
    /**
     * @var array
     */
    public $public_url = '';
    /**
     * @var string
     */
    public $public_field = 'slug';

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_UPDATE  => 'beforeInsertData',
            ActiveRecord::EVENT_AFTER_INSERT  => 'afterInsertData',
        ];
    }

    /**
     * @param $categories
     * @return array|bool
     */
    private function getData($categories){
        $data = [];
        if($this->separator == "array")
        {
            if(is_array($categories))
            {
                return $categories;
            }
        }
        if($this->separator !== "array")
        {
            if(!is_array($categories))
            {
                $selecteds = explode($this->separator,$categories);
                if(strlen(implode('',$selecteds)) == 0){return false;}

                foreach ($selecteds as $selected)
                {
                    $data[] = Categories::findOne($selected);
                }
                return $data;
            }
        }
        return $categories;
    }

    /**
     * @return bool
     */
    private function unlinkData(){
        $categories = $this->owner->categories;
        if(count($categories) == 0){return false;}
        foreach ($categories as $category):
            $this->owner->unlink('categories',$category,true);
        endforeach;
    }

    /**
     * @return bool
     */
    public function beforeInsertData(){
        $model = $this->owner;

        //$model::getDb()->transaction(function($db) use ($model) {
        $this->unlinkData();
        $categories = $this->getData($this->owner->{$this->attribute});
        if(!$categories){return true;}
        foreach ($categories as $category):
            $this->owner->link('categories', $category);
        endforeach;
        //}
    }

    /**
     * @return bool
     */
    public function afterInsertData(){
        $model = $this->owner;
        //$model::getDb()->transaction(function($db) use ($model) {
        $categories = $this->getData($this->owner->{$this->attribute});
        if(!$categories){return true;}
        foreach ($categories as $category):
            $this->owner->link('categories', $category);
        endforeach;

        //}
    }

    /**
     * @return array
     */
    public function categoriesSelected(){
        $categories = $this->owner->categories;
        $data = [];
        if(count($categories) == 0){return [];}
        foreach ($categories as $category):
            $data[$category->id] = $category;
        endforeach;
        return $data;
    }


    //FOR PUBLIC


    /**
     * @param $field
     * @return null|string
     */
    public function categoryLink($field){
        if($field == null){return null;}
        $url = \yii\helpers\Url::to([$this->public_url,$this->public_field => $field]);
        return $url;
    }

    /**
     * @param string $delimitr
     * @return string
     */
    public function getCategoriesPrint($delimitr = ",",$limit = null){
        $categories = $this->owner->categories;
        $data = [];
        $i = 0;
        if(count($categories) == 0){return "";}
        foreach ($categories as $category):
            $i++;
            $data[$category->id] = $category->name;
            if($i == $limit){break;}
        endforeach;
        return implode($delimitr,$data);
    }

    /**
     * @param string $delimitr
     * @return string
     */
    public function getCategoryPrint(){
        return $this->getCategoriesPrint(",",1);
    }

    /**
     * @param string $tag
     * @return string
     */
    public function getCategoriesPrintTag($tag = "a",$limit = null){
        $data = "";
        if(count($categories = $this->getCategoriesInfo())){
            $i = 0;
            foreach ($categories as $category){
                if(strlen($category['name']) == 0){continue;}
                $i++;
                $data .= '<'.$tag.' href="'.$category['link'].'">';
                $data .= $category['name'];
                $data .= "</".$tag.">";
                if($limit == $i){break;}
            }
        }
        return $data;
    }

    /**
     * @param string $tag
     */
    public function getCategoryPrintTag($tag = "a"){
        return $this->getCategoriesPrintTag($tag,1);
    }

    /**
     * @return array
     */
    public function getCategoriesInfo(){
        $categories = $this->owner->categories;
        if(!count($categories)){return [];}
        $array = [];
        foreach ($categories as $category):
            $array[$category->id] = ArrayHelper::toArray($category);
            $array[$category->id]['link'] = self::categoryLink($category->{$this->public_field});
        endforeach;
        return $array;
    }

    public function getCategoryInfo(){
        $cats = $this->getCategoriesInfo();
        if(!count($cats)){return [];}
        return $cats[0];
    }
}