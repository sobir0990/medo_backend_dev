<?php

use oks\langs\widgets\LangsWidgets;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\category\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php echo LangsWidgets::widget(); ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-hover dataTable no-footer',
            'id' => 'basicTable'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'id',
                'label'=>'ID',
                'contentOptions' => ['style' => 'width:14px; white-space: normal;'],
            ],
            [
                'attribute'=>'parent_id',
                'label'=>'Категория',
                'filter' => \yii\helpers\ArrayHelper::map(\common\modules\category\models\Category::find()->andWhere(['parent_id' => null])->all(), 'id', 'name'),
                'format'=>'text', // Возможные варианты: raw, html
                'contentOptions' => ['style' => 'width:240px; white-space: normal;'],
                'content'=>function($data){
                    return !$data->parent_id ? '<span class="text-success">Самостоятельная категория</span>' :$data->getParentName();
                },
            ],
            [
                'attribute'=>'name',
                'label'=>'Name',
                'contentOptions' => ['style' => 'width:340px; white-space: normal;'],
            ],
            [
                'attribute' => 'status',
                'filter' => \common\modules\category\models\Category::statusList(),
                'value' => function (\common\modules\category\models\Category $model) {
                    return \common\modules\category\models\Category::statusLabel($model->status);
                },
                'format' => 'raw',
            ],
//            'sort',
            //'lang',
            //'lang_hash',

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
