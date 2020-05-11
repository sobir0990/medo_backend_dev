<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\ModerReason */

/*$this->title = 'Update Moder Reason: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Moder Reasons', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';*/
?>

<!--
 public $title;
    public $message;
    public $product_id;
    public $reason_id;

-->

<div class="moder-reason-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="moder-reason-form">

        <?php $form = ActiveForm::begin(); ?>


        <?= $form->field($model, 'reason_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\ModerReason::find()->all(),'id','title'), ['prompt' => '--Select--']) ?>

        <?= $form->field($model, 'title')->input(['rows' => 6/*'value'=>$product->description, 'disabled' => 'disabled'*/]) ?>
        <?= $form->field($model, 'message')->textarea(['rows' => 6/*'value'=>$product->description, 'disabled' => 'disabled'*/]) ?>

        <?= $form->field($model, 'post_id')->hiddenInput(['value'=>$product->id])->label(false)?>


        <div class="form-group">
            <?= Html::submitButton('Send',['class' =>'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>

