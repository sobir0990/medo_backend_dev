<?php

use jakharbek\filemanager\widgets\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this  yii\web\View
 * @var $model common\models\Company
 * @var $form  yii\widgets\ActiveForm
 */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-7">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Title')) ?>

            <?= $form->field($model, 'slug')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Slug')) ?>


            <?= $form->field($model, 'link')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Link')) ?>

            <?= $form->field($model, 'type')->dropDownList([
                \common\models\Banner::TYPE_HORIZONTAL => 'HORIZONTAL',
                \common\models\Banner::TYPE_VERTICAL => 'VERTICAL',
            ]) ?>

            <?php
            if (is_null($model->status)) {
                $model->status = \common\models\Banner::STATUS_ACTIVE;
            }
            ?>
            <?= $form->field($model, 'status')->dropDownList([
                \common\models\Banner::STATUS_ACTIVE => 'Active',
                \common\models\Banner::STATUS_NO_ACTIVE => 'Deactive',

            ])
            ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

        </div>
        <div class="col-lg-5">
                <h6><?= __('Files') ?></h6>
                <h6><?= __('Прикрепите фото к записи') ?></h6>
                <p><?= __('Фотография для красоты вашего труда нажмите на кнопку и выберите фото') ?></p>
                <?= $form->field($model, 'image')->widget(FileInput::class, [
                    'id' => 'file_image_id'
                ])->label(false) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
