<?php

use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TestQuestion */
/* @var $questions array */

$this->title = Yii::t('backend', 'Добавить ответ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Test Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-question-create">

    <div class="row">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-7">

            <?= $form->field($model, 'question_id')->dropDownList($questions) ?>
            <?= $form->field($model, 'answer')->textarea(['rows' => 5])->label(Yii::t('backend', 'Введите ответ')) ?>
            <?= $form->field($model, 'correct')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
