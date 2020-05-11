<?php

use common\filemanager\widgets\InputModalWidget;
use common\filemanager\widgets\ModalWidget;
use common\models\Post;

use common\modules\categories\widgets\CategoriesWidget;
use common\modules\langs\widgets\LangsWidgets;
use dosamigos\ckeditor\CKEditor;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .langs-panel > li {
        display: block !important;
    }
</style>

<?php $form = ActiveForm::begin(); ?>
<div class="col-lg-7">
    <?php echo LangsWidgets::widget(['model_db' => $model, 'create_url' => '/answer/create']); ?>

    <div class="form-group">

        <?= $form->field($model, 'answer')->textInput([
            'maxlength' => true,
            'autocomplete' => 'off'
        ]) ?>

        <?php
        $data = ArrayHelper::map(\common\models\TestQuestion::find()->all(), 'id', 'question')
        ?>
        <?= $form->field($model, 'question_id')->widget(\kartik\select2\Select2::classname(), [
            'data' => $data,
            'language' => 'en',
            'options' => [
                'placeholder' => 'Выберите question',
            ],
            'pluginOptions' => [
                'allowClear' => true,
                //                                    'minimumInputLength' => 2
            ],
        ]);
        ?>

        <?= $form->field($model, 'status')->dropDownList([
            Post::STATUS_ACTIVE => 'Active',
            Post::STATUS_DEACTIVE => 'Deactive',
            Post::STATUS_WAITING => 'Waiting'

        ])
        ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

    </div>

</div>

<?php ActiveForm::end(); ?>
