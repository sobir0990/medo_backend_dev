<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('main', 'Moder Reason');
$this->params['breadcrumbs'][] = $this->title;

$this->params['create-btn'] = Html::a( Yii::t('main', 'Create Reason'), ['create'], ['class' => 'm-portlet__nav-link btn btn-success m-btn m-btn--pill m-btn--air']);

?>


<div class="row">

    <div class="col-md-12">

        <div class="m-portlet m-portlet--mobile">

            <div class="m-portlet__body m-portlet__body--no-padding">

                <div class="table-responsive">
                    <?= Html::a(Yii::t('backend', 'Create Award'), ['create'], ['class' => 'btn btn-success']) ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'layout' => '{items}',
                        'tableOptions' => [
                            'class' => 'table m-table m-table--head-bg-brand table-hover table-striped m--marginless'
                        ],
                        'columns' => [
                            //['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'id',
                                'contentOptions' => ['style' => 'vertical-align:middle;middle; width: 5%'],
                            ],
                            'title',
                            //'message',
                            // 'descriptiont:ntext',
                            // 'website:ntext',
                            // 'logo:ntext',

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => Yii::t('main', 'Actions'),
                                'headerOptions' => ['style' => 'text-align:center'],
                                'template' => '{buttons}',
                                'contentOptions' => ['style' => 'min-width:150px;max-width:150px;width:150px;text-align:center;', 'class' => 'v-align-middle'],
                                'buttons' => [
                                    'buttons' => function ($url, $model)
                                    {
                                        $controller = Yii::$app->controller->id;
                                        $code = <<<BUTTONS
                                        <div class="btn-group m-btn-group m-btn-group--pill">
                                            <a href="/{$controller}/update/{$model->id}" class="m-btn btn btn-brand"><i class="fa fa-pencil"></i></a>
                                            <a href="/{$controller}/delete/{$model->id}" class="m-btn btn btn-danger"><i class="fa fa-trash"></i></a>
                                        </div>
BUTTONS;
                                        return $code;
                                    }

                                ],
                            ],
                        ],
                    ]); ?>

                </div>

            </div>

        </div>

    </div>

</div>