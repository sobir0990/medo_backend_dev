<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use jakharbek\categories\models\Categories;
use jakharbek\tags\widgets\TagsWidget;
use jakharbek\filemanager\models\Files;
use jakharbek\langs\widgets\LangsWidgets;
use dosamigos\ckeditor\CKEditor;
use dosamigos\selectize\SelectizeDropDownList;
use dosamigos\selectize\SelectizeTextInput;
use kartik\widgets\Select2;
use kartik\editable\Editable;
use kartik\daterange\DateRangePicker;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model common\modules\menu\models\Menu */

$this->title = 'Create Menu';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo LangsWidgets::widget();
?>
<div class="menu-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
