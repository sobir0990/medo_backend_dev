<?php

use yii\helpers\Html;
use yii\grid\GridView;

?>

<div class="row">

    <div class="col-md-12">

        <div class="m-portlet m-portlet--mobile">

            <div class="m-portlet__body m-portlet__body--no-padding">

                <div class="table-responsive">

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'layout' => '{items}',
                        'tableOptions' => [
                            'class' => 'table m-table m-table--head-bg-brand table-striped m--marginless'
                        ],
                        'columns' => [

                            //['class' => 'yii\grid\SerialColumn'],

                            [
                                'attribute' => 'id',
                                'contentOptions' => ['style' => 'vertical-align:middle;middle; width: 5%'],
                            ],
                            [
                                'attribute' => 'BLOG',
                                'contentOptions' => ['style' => 'vertical-align:middle'],
                                'value'=> function($model){
                                    return Html::a($model->title_ru, "/product/update/$model->id");
                                },
                                'format' => 'html'
                            ],
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
                                            <a href="/{$controller}/active/{$model->id}" class="m-btn btn btn-brand"><i class="fa fa-check"></i></a>
                                        </div>
BUTTONS;
                                        return $code;
                                    }

                                ],
                            ],
                        ],
                    ]); ?>

                </div>

                <div class="row index-footer">

                    <div class="col-md-6">

                    </div>

                    <div class="col-md-6">

                        <?php echo \yii\widgets\LinkPager::widget(['pagination' => $dataProvider->pagination])?>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>