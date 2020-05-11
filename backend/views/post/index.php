<?php

use common\modules\langs\widgets\LangsWidgets;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .langs-panel > li {
        display: block!important;
    }
</style>
<div class="post-index">
    <?php  echo LangsWidgets::widget(); ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
        <?php \yii\widgets\Pjax::begin();?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-hover dataTable no-footer',
            'id' => 'basicTable'
        ],
        'layout' => '{items}{summary}{pager}',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
         //   'id',
            [
                    'attribute' => 'title',
                    'label' => 'Названия',
                    'value' => function($model){
                    return Html::a($model->title,"/post/update/$model->id");
                    },
                    'format' => 'raw'
            ],
            [
                'attribute' => 'profile_id',
                'value' => 'profile.first_name'
            ],
            [
                'attribute' => 'status',
                'content'=>function($model){
                    if($model->status == 2){
                        return 'Active';
                    }else{
                        return 'NeActive';
                    }
                },
                'headerOptions' => ['style' => 'width:5%;'],
            ],


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
                        return '<a href="'.$url.'" data-method="post"> <div class="btn btn-success">' .
                            '<i class="fa fa-trash-o" style="color: #ffffff;"></i>' .
                            '</div></a>';
                    },
                ],
            ],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end()?>
</div>
