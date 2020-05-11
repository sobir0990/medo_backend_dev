<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use jakharbek\categories\models\Categories;
use jakharbek\langs\widgets\LangsWidgets;
use dosamigos\ckeditor\CKEditor;
use dosamigos\selectize\SelectizeDropDownList;
use dosamigos\selectize\SelectizeTextInput;
use common\modules\settings\models\Settings;

/* @var $this yii\web\View */
/* @var $model common\modules\settings\models\Settings */
/* @var $form yii\widgets\ActiveForm */


$addon = <<< HTML
<span class="input-group-addon">
    <i class="glyphicon glyphicon-calendar"></i>
</span>
HTML;

$jsdata = <<< JS
    $('#settings-input').change(function(){
        console.log($(this));
        console.log($(this).val());
        if($(this).val() > 1 && $(this).val() < 4){
            $('.field-settings-data').show();
        }else{
            $('.field-settings-data').hide();
        }
    });
    $('#settings-input').change();
JS;

$this->registerJs($jsdata);


?>

<div class="settings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(Settings::find()->types()) ?>

    <?= $form->field($model, 'input')->dropDownList(Settings::find()->inputs()) ?>

    <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'default')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('yoshlar-settings','Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
