<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TestQuestion */
/* @var $answers common\models\TestAnswer[] */

$this->title = Yii::t('backend', 'Изменить вопрос № {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Test Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="test-question-update">

    <?= $this->render('_form', [
        'model' => $model,
        'answers' => $answers,
    ]) ?>

</div>
