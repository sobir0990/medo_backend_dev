<?php
namespace common\modules\menu\components;

use common\modules\menu\assets\MenuAdminAsset;
use Yii;
use common\modules\menu\components\MenuRender;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\modules\menu\models\Menu;
use common\modules\menu\models\MenuItems;
use yii\widgets\Pjax;
use common\modules\menu\models\MenuItemsPosts;

class MenuAdmin extends MenuRender{

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        MenuAdminAsset::register( Yii::$app->view);
    }

    public function beforeRenderMenu()
    {
        echo '<ol class="menu-admin">';
    }

    public function afterRenderMenu()
    {
        echo '</ol>';
    }

    public function beginRenderItem()
    {
        if($this->has_child):
            echo '<li menuitem-id="'.$this->item->menu_item_id.'">';
            echo "<div class='menu-item'>";
            echo '<div  class="menu-item-title"> ';
            echo $this->item->title;
            echo "</div>";
            echo '<div  class="menu-item-right-block"> ';
            echo '<span class="glyphicon glyphicon-collapse-down menu-item-get-settings"></span>';
            echo "</div>";
            echo '</div>';
            $this->menuItemSetting();

        else:
            echo '<li menuitem-id="'.$this->item->menu_item_id.'">';
            echo "<div class='menu-item'>";
            echo '<div  class="menu-item-title"> ';
            echo $this->item->title;
            echo "</div>";
            echo '<div  class="menu-item-right-block"> ';
            echo '<span class="glyphicon glyphicon-collapse-down menu-item-get-settings"></span>';
            echo "</div>";
            echo '</div>';
            $this->menuItemSetting();
            echo "<ol>";
        endif;

    }
    private function menuItemSetting(){
        $model = MenuItems::findOne($this->item->menu_item_id);

        echo '<div  class="menu-item-settings" menuitem-id="'.$this->item->menu_item_id.'"> ';
        $form = ActiveForm::begin(['id' => 'menu-item-form','options' => ['data-pjax' => true,['enctype' => 'multipart/form-data']]]);
        echo $form->field($model,'title');
        echo $form->field($model,'url');
        echo $form->field($model,'icon');
//        echo \jakharbek\filemanager\widgets\ModalWidget::widget();
//        echo \jakharbek\filemanager\widgets\InputModalWidget::widget(['form' => $form,
//            'attribute' => 'MenuItems[icon]',
//            'id' => 'menu_icon'.$this->item->menu_item_id,
//            'values' => $model->icon,
//            'value_encode' => true
//        ]);
        //echo $form->field($model,'imageFile')->fileInput();
        echo $form->field($model,'menu_item_id')->hiddenInput()->label(false);
        echo Html::submitButton(Yii::t('jakhar-posts','Menu Update'),['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('jakhar-posts','Menu Remove'),'#menuitem',['class' => 'btn btn-danger pull-right',
            'title'        => 'delete',
            'data-query' => 'delete',
            'data-query-delete-selector' => 'li[menuitem-id='.$this->item->menu_item_id.']',
            'data-query-method' => 'POST',
            'data-query-url' => yii\helpers\Url::to(["/menu/menu/delete-item"]),
            'data-query-confirm' => Yii::t('jakhar-menu','Are you sure?'),
            'data-query-params' => 'id='.$this->item->menu_item_id.'&menuItemDelete=delete']);
        ActiveForm::end();
        echo "</div>";
    }

    public function endRenderItem()
    {
        if($this->has_child):
            echo '</li>';
        else:
            echo '</ol></li>';
        endif;
    }

    public function beginRenderItemChild()
    {
        echo '<li menuitem-id="'.$this->item->menu_item_id.'">';
        echo "<div class='menu-item'>";
        echo '<div  class="menu-item-title"> ';
        echo $this->item->title;
        echo "</div>";
        echo '<div  class="menu-item-right-block"> ';
        echo '<span class="glyphicon glyphicon-collapse-down menu-item-get-settings"></span>';
        echo "</div>";
        echo '</div>';
        $this->menuItemSetting();
        if(!$this->has_child):
            echo '<ol></ol>';
        endif;
    }

    public function endRenderItemChild()
    {
        echo "</li>";
    }

    public function beforeRenderItemChilds()
    {
        echo "<ol>";
    }

    public function afterRenderItemChilds()
    {

    }
}