<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ResumeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Resumes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resume-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Resume', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-hover dataTable no-footer',
            'id' => 'basicTable'
        ],
        'columns' => [
        //    ['class' => 'yii\grid\SerialColumn'],

            [
                    'label' => '№',
                    'attribute' => 'id',
                    'headerOptions' => ['style' => 'width: 5%']
            ],
            [
                'label' => 'Названия',
                'attribute' => 'title',
                'value' => function($model){
                    return HTML::a($model->title, "/resume/update/{$model->id}");
                },
                'format' => 'raw'
            ],
            [
                'label' => 'Профиль',
                'attribute' => 'profile_id',
                'value' => function($model){
                    return Html::a("{$model->profile->first_name}","/profile/update/{$model->profile->id}" );
                },
                'format' => 'raw'
            ],
         //   'text:ntext',
         //   'files',
            //'salary',
            //'phone',
            //'experience',
            //'salary_type',
            //'type',
            //'status',
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
