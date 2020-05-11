<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ModerReason */

$this->title = 'Update Moder Reason: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Moder Reasons', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="moder-reason-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
