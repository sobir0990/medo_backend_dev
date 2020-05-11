<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Encyclopedia */

$this->title = Yii::t('backend', 'Create Encyclopedia');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Encyclopedias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="encyclopedia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
