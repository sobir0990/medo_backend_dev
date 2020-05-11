<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TestQuestion */

$this->title = Yii::t('backend', 'Добавить вопрос');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Test Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-question-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
