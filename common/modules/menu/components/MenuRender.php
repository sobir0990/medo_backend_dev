<?php
namespace common\modules\menu\components;

use common\modules\langs\components\Lang;
use common\modules\pages\models\Pagesimages;
use Yii;
use yii\base\Component;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\IdentityInterface;
use common\modules\menu\models\MenuItems;
use common\modules\menu\models\Menu;

/**
 * Class MenuRender
 * @package common\modules\menu\components
 */
abstract class MenuRender extends Component{

    /**
     * @var $alias
     */
    public $alias;
    /**
     * @var $menu
     */
    public $menu;
    /**
     * @var $parents
     */
    public $parents;
    /**
     * @var $parent
     */
    public $parent;
    /**
     * @var $items
     */
    public $items;
    /**
     * @var $item
     */
    public $item;
    /**
     * @var $has_child
     */
    public $has_child;
    /**
     * @var $count_child
     */
    public $count_child;
    /**
     * @var $level
     */
    public $level;
    /**
     * @var $is_active
     */
    public $is_active;
    /**
     * @var bool $without_cache
     */
    public $without_cache = false;

    /**
     * @var bool $without_cache
     */
    public $checkAccess = false;

    /**
     * @return void
     */
    public function init(){
        $this->run();
    }

    /**
     * @return void
     */
    public function run(){
        if($this->without_cache){
            $this->render();
        }else{
            if(Yii::$app->view->beginCache($this->alias,[
                'variations' => [Yii::$app->language,Yii::$app->layout],
                'dependency' => [
                    'class' => \yii\caching\TagDependency::className(),
                    'tags' => ['menu',$this->alias],
                ],
            ]))
            {
                $this->render();
                Yii::$app->view->endCache();
            }
        }

    }

    /**
     * @return void
     */
    private function render(){
        /**
         * @var menu Menu;
         * @var alias String;
         * @var parents MenuItems
         */
        $this->menu = Menu::find()->alias($this->alias)->lang()->one();
        $this->parents = $parents = $this->menu->menuItemsParents ? $this->menu->menuItemsParents : [] ;

        /**
         * Events: beforeRenderMenu
         */
        $this->beforeRenderMenu();

        foreach ($parents as $parent){
            if (!$this->hasAccessToRoute($parent->url) && $this->checkAccess) continue;
//            if (!$this->hasAccessToRoute($parent->url) && $this->checkAccess || !$this->showParent()) continue;

            $this->item = $parent;
            $this->parent = $parent;
            $this->items = $items = $parent->menuItems;
            $this->has_child = $has_child = boolval(count($this->items));
            $this->count_child = count($this->items);
            $this->level = 1;
            $is_active = $this->is_active();

            /**
             * Events: handler, beginRenderItem
             */

            $this->handler();
            $this->beginRenderItem();

            /**
             * Childs
             */
            $this->childs();

            $this->is_active = $is_active;

            /**
             *  Events: handler, endRenderItem
             */

            $this->handler();
            $this->endRenderItem();
        }

        /**
         * Events: afterRenderMenu
         */
        $this->afterRenderMenu();

    }

    /**
     * return void
     */
    public function childs(){


        if($this->has_child == false){return;}
        /**
         * Запись данных
         */
        $items = $childs = $this->items;
        $item = $this->item;
        $has_child = $this->has_child;
        $count_child = $this->count_child;
        $level = $this->level;
        $parent = $this->parent;
        $is_active = $this->is_active();

        $level = $this->level = ($this->level + 1);
        /**
         * Events beforeRenderItemChilds
         */
            $this->beforeRenderItemChilds();


        /**
         * Перебор данных
         */
        foreach ($childs as $child):

            if ((!$this->hasAccessToRoute($child->url) && $this->checkAccess)) continue;

            $this->items = $child->menuItems;
            $this->has_child = $has_child = boolval(count($this->items));
            $this->count_child = count($this->items);
            $this->item = $child;
            $is_active = $this->is_active();

            /**
             * Events: handler, beginRenderItemChild
             */
            $this->handler();
            $this->beginRenderItemChild();

            $this->childs();
            /**
             * Возврашение данных
             */
            $this->items = $childs;
            $this->item = $child;
            $this->has_child = $has_child;
            $this->count_child = $count_child;
            $this->parent = $parent;
            $this->level = $level;
            $this->is_active = $is_active;

            /**
             * Events: handler, endRenderItemChild
             */

            $this->handler();
            $this->endRenderItemChild();

        endforeach;
        /**
         * Возврашение данных
         */
        $this->items = $items;
        $this->item = $item;
        $this->has_child = $has_child;
        $this->count_child = $count_child;
        $this->level = $level;
        $this->parent = $parent;
        $this->is_active = $is_active;
        /**
         * Events: handler, afterRenderItemChilds
         */
        $this->handler();
        $this->afterRenderItemChilds();


    }

    //abstracts methods;
    /*
     * @method метод выполнаеться перед началом вывода меню
     */
    public abstract function beforeRenderMenu();
    /*
     * @method метод выполнаеться в после вывода меню
     */
    public abstract function afterRenderMenu();
    /*
     * @method метод выполнаеться в начале вывода элемента
     */
    public abstract function beginRenderItem();
    /*
     * @method метод выполнаеться в конце вывода элемента
     */
    public abstract function endRenderItem();
    /*
    * @method метод выполнаеться перед началов вывода под элементов
    */
    public abstract function beforeRenderItemChilds();
    /*
     * @method метод выполнаеться после вывода под элементов
     */
    public abstract function afterRenderItemChilds();
    /*
     * @method метод выполнаеться в начале вывода под элемента
     */
    public abstract function beginRenderItemChild();
    /*
     * @method метод выполнаеться в конце вывода под элемента
     */
    public abstract function endRenderItemChild();

    public function is_active(){
        $pathInfo = Yii::$app->request->getPathInfo();
        $urlarr = $this->getUrlFormat($this->item->url);
        $patharr = $this->getUrlFormat($pathInfo);
        $this->is_active = ($urlarr == $patharr);
        return $this->is_active;
    }
    public function handler(){

    }
    public function getUrlFormat($url = null){
        if($url == null){return false;}
        if(array_key_exists("path", parse_url($url)))
            $url = parse_url($url)['path'];
        else $url = "";
        $url = rawurldecode($url);
        $url = mb_strtolower($url);
        $pattern = '~([a-zA-Z0-9_а-яА-Я-\.\,\s]+)~u';
        preg_match_all($pattern,$url,$urls);
        $url = $urls[1];
        return $url;
    }

    protected function hasAccessToRoute($route)
    {

        if ($route == '#') return true;

        do {
            if (\Yii::$app->user->can($route) || \Yii::$app->user->can($route . "*")) return true;
            $route = substr($route, 0,
                -(strpos(strrev($route), '/', 1)));
        } while (!empty($route));


        return false;
    }

    protected function showParent() {
        if($this->has_child == false){return false;}

        $childs = $this->items;

        /**
         * Перебор данных
         */
        foreach ($childs as $child):

            if (!$this->hasAccessToRoute($child->url) && $this->checkAccess) continue;

            return true;

        endforeach;
    }

}