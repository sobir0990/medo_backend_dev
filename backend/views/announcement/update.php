<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = 'E\'lon o\'zgartirish: ' . $model->title_ru;
$this->params['breadcrumbs'][] = ['label' => 'E\'lon', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title_ru, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-update">

    <h1><?= Html::encode($this->title) ?></h1>
<?php  echo common\modules\langs\widgets\LangsWidgets::widget(['model_db' => $model,'create_url' => '/announcement/create']); ?><br/>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
