<?php

use common\modules\langs\widgets\LangsWidgets;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\settings\models\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Settings';
$this->params['breadcrumbs'][] = $this->title;

echo LangsWidgets::widget();

?>
<div class="settings-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Settings', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
            'attribute' => 'title'
            ],

            //'setting_id',
            //'title',
            //'description:ntext',
            //'slug',
            //'type',
            //'input',
            //'default',
            //'sort',
            //'lang_hash',
            //'lang',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
