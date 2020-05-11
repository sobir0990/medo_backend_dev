<?php

use common\modules\langs\widgets\LangsWidgets;
use yii\helpers\Html;
use yii\widgets\Pjax;

use kartik\daterange\DateRangePicker;
use kartik\switchinput\SwitchInput;
use jakharbek\users\models\Users;
use common\modules\posts\models\Posts;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\menu\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend','Menus');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-md-9">
        <?php echo LangsWidgets::widget(); ?>
    </div>
    <div class="col-md-3">
        <?= Html::a(Yii::t('main', 'Create Menu'), ['create'],
            ['class' => 'btn btn-primary pull-right col-md-offset-1']) ?>
    </div>
</div>
<div class="menu-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{items}{summary}{pager}',
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style' => 'width:8%'],
            ],
            [
                'attribute' => 'title',
                'content' => function($data){
                    return "<a href='".\yii\helpers\Url::to(['/menu/menu/update','id' => $data->menu_id])."'>".$data->title."</a>";
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',

                'headerOptions' => ['style' => 'width:15%;'],
                'contentOptions' => ['style' => 'width:15%;'],
            ],
        ],
    ]); ?>
</div>
