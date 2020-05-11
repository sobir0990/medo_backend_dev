<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\models\TestAnswer;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Test Answer';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .langs-panel > li {
        display: block !important;
    }
</style>
<div class="post-index">
    <h1><?= Html::encode($this->title) ?></h1>
        <?php  echo \common\modules\langs\widgets\LangsWidgets::widget(); ?><br/>

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
            'id',
            'answer',
            [
                'attribute' => 'question_id',
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\TestQuestion::find()->andWhere(['lang' => \common\modules\langs\components\Lang::getLangId()])->all(), 'id', 'question'),
                'filterInputOptions' => ['class' => 'form-control form-control-sm'],
                'value' => function($data){
                    return $data->question->question;
                }
            ],
            [
                'attribute' => 'correct',
                'filter' => TestAnswer::correctList(),
                'value' => function (TestAnswer $model) {
                    return TestAnswer::correctLabel($model->correct);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'status',
                'filter' => TestAnswer::statusList(),
                'value' => function (TestAnswer $model) {
                    return TestAnswer::statusLabel($model->status);
                },
                'format' => 'raw',
            ],


            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{correct} {update} {delete}',
                'buttons' => [
                    'correct' => function ($model, $url) {
                        return '<a href="' . Url::to(['answer/correct', 'id' => $url->id]) . '"> <div class="btn btn-primary">' .
                            '<i class="fa fa-check" style="color: #ffffff;"></i>' .
                            '</div></a>';
                    },
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
