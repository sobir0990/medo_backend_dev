<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
if (Yii::$app->language == 'uz') {
    $this->title = $model->title_uz;
}else{
    $this->title = $model->title_ru;
}
$this->params['breadcrumbs'][] = ['label' => 'E\'lonlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'profile_id',
            'company_id',
            'images',
            'title_ru',
            'type',
            'status',
            'price',
            'price_type',
            'phone',
            'files',
            'lang',
            'lang_hash',
            'delivery',
            'address',
            'top',
            'view',
            'view_phone',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
