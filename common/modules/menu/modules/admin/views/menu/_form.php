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
use kartik\widgets\Select2;
use kartik\editable\Editable;
use kartik\daterange\DateRangePicker;
use kartik\switchinput\SwitchInput;
use yii\widgets\Pjax;
use common\modules\menu\models\Menu;
use common\modules\menu\models\MenuItems;
use yii\jui\Sortable;

/* @var $this yii\web\View */
/* @var $model common\modules\menu\models\Menu */
/* @var $form yii\widgets\ActiveForm */
$addon = <<< HTML
<span class="input-group-addon">
    <i class="glyphicon glyphicon-calendar"></i>
</span>
HTML;
?>
<div class="col-md-4">

    <?php if(!$model->isNewRecord):?>
        <div class="panel panel-default">
            <div class="panel-heading"><?=Yii::t('main','Item')?></div>
            <div class="panel-body">
                <div class="menu-items-form">

                    <?php $form = ActiveForm::begin(['id' => 'menu-form-item','options' => ['data-pjax' => true]]); ?>

                    <?= $form->field($menuItem, 'title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($menuItem, 'url')->textInput(['maxlength' => true]) ?>

                    <?php  echo $form->field($menuItem, 'icon')->textInput(['maxlength' => true]); ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('main','Save'), ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>

            </div>

        </div>
    <?php endif;?>
    <div class="panel panel-default">
        <div class="panel-heading"><?=Yii::t('main','Menu')?></div>
        <div class="panel-body">
            <div class="menu-form">
                <?php $form = ActiveForm::begin(['id' => 'menu-form','options' => ['data-pjax' => true]]); ?>
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'type')->dropDownList($model::find()->types()) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('main','Save'), ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<div class="col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading"><?=Yii::t('main','All items')?></div>
        <div class="panel-body">
            <?php
            if(!$model->isNewRecord):
                $menu = new \common\modules\menu\components\MenuAdmin(['alias' => $model->alias]);
            endif;
            ?>
        </div>
    </div>
</div>
