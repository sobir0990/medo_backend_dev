<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = 'Update Product: ' . $model->title_ru;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title_ru, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-update">

    <h1><?= Html::encode($this->title) ?></h1>
<?php  echo common\modules\langs\widgets\LangsWidgets::widget(['model_db' => $model,'create_url' => '/product/create']); ?><br/>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
