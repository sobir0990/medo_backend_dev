<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ModerReason */

$this->title = 'Create Moder Reason';
$this->params['breadcrumbs'][] = ['label' => 'Moder Reasons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="moder-reason-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
