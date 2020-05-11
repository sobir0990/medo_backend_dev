<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\EncyclopediaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Encyclopedias');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="encyclopedia-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('backend', 'Create Encyclopedia'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-hover dataTable no-footer',
            'id' => 'basicTable'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'author_id',
            'title',
            'slug',
            'description',
            //'text:ntext',
            //'lang',
            //'lang_hash',
            //'created_at',
            //'updated_at',
            //'type',
            //'status',
            //'files',
            //'publish_time:datetime',
            //'top',
            //'view',
            //'letter',

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
