<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.03.2018
 * Time: 17:05
 */

namespace common\modules\menu\components;


use Yii;
use yii\base\Action;
use yii\base\Module;

class MenuAdminBackend extends MenuRender
{

    public $checkAccess = true;

    public function beforeRenderMenu()
    {
        echo '<ul class="menu-items">';
    }

    public function afterRenderMenu()
    {
        echo '</ul>';
    }

    public function beginRenderItem()
    {
        echo ' <li class="has-children"><a href="' . $this->item->url . '"><span class="title">' . $this->item->title . "</span>";
        if ($this->has_child):
            echo '<span class=" arrow"></span>';
        endif;
        echo ' </a>';
        echo '<span class="icon-thumbnail icon-thumbnail">' . $this->item->icon . '</i></span>';
    }

    public function endRenderItem()
    {
        echo "</li>";
    }

    public function beginRenderItemChild()
    {
        if ($this->is_active()):
            echo '<li class="current">';
        else:
            echo '<li>';
        endif;

        echo '<a href="' . $this->item->url . '" class="detailed"> <span class="title">' . $this->item->title . '</span></a>';
        echo '<span class="success icon-thumbnail">' . $this->item->icon . '</span>';
        echo '</li>';

    }

    public function endRenderItemChild()
    {
        echo '</li>';
    }

    public function beforeRenderItemChilds()
    {
        echo ' <ul class="sub-menu">';
    }

    public function afterRenderItemChilds()
    {
        echo '</ul>';
    }

}