<?php

use common\modules\langs\widgets\LangsWidgets;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Эълонлар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php  echo LangsWidgets::widget(); ?><br/>
    <p>
        <?= Html::a( 'E\'lon qo\'shish', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-hover dataTable no-footer',
            'id' => 'basicTable'
        ],
        'layout' => '{items}{summary}{pager}',
        'columns' => [
            [
                'label' => 'id',
                'attribute' => 'id',
                'headerOptions' => ['style' => 'width: 5%']
            ],
            [
                 'label' => 'Названия',
                 'attribute' => 'title_ru',
                 'value' => function($model){
                    return HTML::a($model->title_ru, "/announcement/update/{$model->id}");
                 },
                'format' => 'raw'
            ],
            //'type',
            //'status',
            //'price',
            //'price_type',
            //'phone',
            //'files',
            //'lang',
            //'lang_hash',
            //'delivery',
            //'address',
            //'top',
            //'view',
            //'view_phone',
            //'created_at',
            //'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($model) {
                        return '<a href="' . $model . '"> <div class="btn btn-success">' .
                            '<i class="fa fa-pencil" style="color: #ffffff;"></i>' .
                            '</div></a>';
                    },
                    'delete' => function ($url) {
                        return '<a href="' . $url . '" data-method="post"> <div class="btn btn-success">' .
                            '<i class="fa fa-trash-o" style="color: #ffffff;"></i>' .
                            '</div></a>';
                    },
                ],
            ],
        ],
    ]); ?>
</div>
