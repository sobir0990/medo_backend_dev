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
/* @var $form yii\widgets\ActiveForm */


$addon = <<< HTML
<span class="input-group-addon">
    <i class="glyphicon glyphicon-calendar"></i>
</span>
HTML;

?>

<div class="values-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'value')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('yoshlar-values','Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
