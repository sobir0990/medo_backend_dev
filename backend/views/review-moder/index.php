<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('main', 'Лента модератора Резюме');

$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/company-moder']];

$this->params['breadcrumbs'][] = $this->title;

$session = Yii::$app->session;

//if( $session->has('tab') ) {
//
//    $tab = $session->get( 'tab' );
//
//} else {
//
//    $tab = 1;
//    $session->set( 'tab', 1 );
//
//}
$tab = 1;
$contents = [];

$contents[] = [
    'id' => 1,
    'label' => Yii::t('main', 'Waiting'),

    'content' => $this->render('_moder-waiting', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProviderWaiting,
    ]),
    'active' => $tab == 1 ? 'active' : '',
];

$contents[] = [
    'id' => 2,
    'label' => Yii::t('main', 'Active'),

    'content' => $this->render('_moder-active', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProviderActive,
    ]),
    'active' => $tab == 2 ? 'active' : '',
];

$contents[] = [
    'id' => 3,
    'label' => Yii::t('main', 'Deactive'),

    'content' => $this->render('_moder-deactive', [

        'searchModel' => $searchModel,
        'dataProvider' => $dataProviderDeleted,
    ]),
    'active' => $tab == 3 ? 'active' : '',
];




?>

    <div class="row">

        <div class="col-md-12">

            <div class="m-portlet m-portlet--mobile">

                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs-line m-tabs-line--left m-tabs-line--primary" id="contents">
                            <?php
                            foreach($contents as $content):

                                ?>

                                <li class="nav-item m-tabs__item <?=($content['label']== Yii::t("main","Waiting"))?'active':''?> ">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#content_<?=$content['id']?>">
                                        <?=$content['label']?>
                                    </a>
                                </li>

                                <?php

                            endforeach;

                            ?>

                        </ul>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="tab-content">

        <?php

        foreach($contents as $content):

            ?>

            <div class="tab-pane <?=$content['active']?>" id="content_<?=$content['id']?>">

                <?=$content['content'];?>

            </div>

            <?php endforeach;        ?>

    </div>
<?php

$js = <<<JS

 //
 //  $(document).ready(function(){
 //  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
 // localStorage.setItem('activeTab', $(e.target).attr('href'));
 // });
 // var activeTab = localStorage.getItem('activeTab');
 // if(activeTab){
 // $('.nav-item a[href="' + activeTab + '"]').tab('show');
 // }
 // });
JS;

$this->registerJs($js);

?>

<?php
$this->registerJs(
    <<< JS
    $('table tbody button').on('click', function() {
  $('#moderlistfrom-review_id').val($(this).data('id'));
  var act =  '/review-moder/deactive/'+ $(this).data('id');
  $('#myModal form').attr('action',act);
});
JS
);
?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Деактироват</h4>
            </div>
            <div class="modal-body">
                <?php
                $model = new \backend\models\ReviewListFrom();
                $form = ActiveForm::begin([
                    'action' => '/review-moder/deactive/'
                ]); ?>

                <div class="m-portlet m-portlet--mobile">

                    <div class="m-portlet__head">
                        <div class="m-portlet__head-tools">
                            <ul class="nav nav-tabs m-tabs-line m-tabs-line--left m-tabs-line--primary" id="contents">

                                    <li class="nav-item m-tabs__item active">
                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#content_01">
                                        Сабаб лист
                                        </a>
                                    </li>
                                <li class="nav-item m-tabs__item ">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#content_02">
                                        Сабаб яратиш
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>


                <div class="tab-content">

                        <div class="tab-pane active" id="content_01">


                            <?= $form->field($model, 'reason_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\ModerReason::find()->all(),'id','title'), ['prompt' => '--Танланг--']) ?>

                        </div>



                        <div class="tab-pane" id="content_02">

                            <?= $form->field($model, 'title')->input(['rows' => 6/*'value'=>$product->description, 'disabled' => 'disabled'*/]) ?>
                            <?= $form->field($model, 'message')->textarea(['rows' => 6/*'value'=>$product->description, 'disabled' => 'disabled'*/]) ?>
                            <input type="hidden" id="moderlistfrom-review_id" class="form-control" name="ReviewListFrom[review_id]">


                        </div>

                </div>




                <div class="form-group">
                    <?= Html::submitButton('Send',['class' =>'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
