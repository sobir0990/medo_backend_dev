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
/* @var $model common\modules\settings\models\Values */

$this->title = 'Update Values: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->value_id, 'url' => ['view', 'id' => $model->value_id]];
$this->params['breadcrumbs'][] = 'Update';

echo LangsWidgets::widget(['model_db' => $model,'create_url' => '/settings/settings/create/']);
?>
<div class="values-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
