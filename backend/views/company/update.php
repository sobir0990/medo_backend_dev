<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Company */

$this->title = 'Update Company: ' . $model->name_ru;
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name_ru, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="company-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

<!--    --><?//= $this->render('_form', [
//        'model' => $model,
//        'productSearch' => $productSearch,
//        'product' => $product,
//        'vacation'=> $vacation,
//        'vacationSearch' => $vacationSearch,
//        'post' => $post,
//        'postSearch' => $postSearch,
//    ]) ?>

</div>

<!--    <div class="m-portlet__head">-->
<!--        <div class="m-portlet__head-tools">-->
<!--            <ul class="nav nav-tabs m-tabs-line m-tabs-line--left m-tabs-line--primary" id="contents">-->
<!--                <li class="nav-item m-tabs__item --><?//= (!$_GET['tab']) ? 'active' : '' ?><!--">-->
<!--                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#content_00">-->
<!--                        --><?//= Yii::t('backend', 'Компания'); ?>
<!--                    </a>-->
<!--                </li>-->
<!--                --><?php //if (!$model->isNewRecord): ?>
<!--                    <li class="nav-item m-tabs__item --><?//= ($_GET['tab'] == '01') ? 'active' : '' ?><!--">-->
<!--                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#content_01">-->
<!--                            --><?//= Yii::t('backend', 'Новосты'); ?>
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="nav-item m-tabs__item --><?//= ($_GET['tab'] == '02') ? 'active' : '' ?><!--">-->
<!--                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#content_02">-->
<!--                            --><?//= Yii::t('backend', 'Объявления'); ?>
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="nav-item m-tabs__item --><?//= ($_GET['tab'] == '03') ? 'active' : '' ?><!--">-->
<!--                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#content_03">-->
<!--                            --><?//= Yii::t('backend', 'Вакансия'); ?>
<!--                        </a>-->
<!--                    </li>-->
<!--                --><?php //endif; ?>
<!--            </ul>-->
<!--        </div>-->
<!--    </div>-->


<?php //if (!$model->isNewRecord): ?>
<!--    <div class="tab-pane --><?//= ($_GET['tab']) ? 'active' : '' ?><!--" id="content_01">-->
<!---->
<!--        <div class="col-md-12">-->
<!--            <br/>-->
<!--            <p>-->
<!--                --><?//= Html::a('Create Post', ['/post/create/?company_id=' . $model->id . ''], ['class' => 'btn btn-success']) ?>
<!--            </p>-->
<!---->
<!--            --><?//= GridView::widget([
//                'dataProvider' => $post,
//                'filterModel' => $postSearch,
//                'layout' => '{items}{summary}{pager}',
//                'columns' => [
//                    ['class' => 'yii\grid\SerialColumn'],
//                    //   'id',
//                    [
//                        'attribute' => 'title',
//                        'label' => 'Названия',
//                        'value' => function ($model) {
//                            return Html::a($model->title, "/post/update/$model->id");
//                        },
//                        'format' => 'raw'
//                    ],
//                    [
//                        'attribute' => 'profile_id',
//                        'value' => 'profile.first_name'
//                    ],
//                    [
//                        'attribute' => 'status',
//                        'content' => function ($model) {
//                            if ($model->status == 2) {
//                                return 'Active';
//                            } else {
//                                return 'NeActive';
//                            }
//                        },
//                        'headerOptions' => ['style' => 'width:5%;'],
//                    ],
//
//
//                    [
//                        'class' => 'yii\grid\ActionColumn',
//                        'template' => '{view} {delete}',
//
//                        'headerOptions' => ['style' => 'width:10%;'],
//                        'contentOptions' => ['style' => 'width:10%;'],
//                    ],
//                ],
//            ]); ?>
<!--        </div>-->
<!---->
<!--    </div>-->
<!--    <div class="tab-pane --><?//= ($_GET['tab']) ? 'active' : '' ?><!--" id="content_02">-->
<!--        <div class="col-md-12">-->
<!--            <br/>-->
<!--            <p>-->
<!--                --><?//= Html::a('Create Product', ['/product/create?company_id=' . $model->id . ''], ['class' => 'btn btn-success']) ?>
<!--            </p>-->
<!---->
<!--            --><?//= GridView::widget([
//                'dataProvider' => $product,
//                'filterModel' => $productSearch,
//                'layout' => '{items}{summary}{pager}',
//                'columns' => [
//                    [
//                        'label' => 'id',
//                        'attribute' => 'id',
//                        'headerOptions' => ['style' => 'width: 5%']
//                    ],
//                    [
//                        'label' => 'Названия',
//                        'attribute' => 'title_ru',
//                        'value' => function ($model) {
//                            return HTML::a($model->title_ru, "/product/update/{$model->id}");
//                        },
//                        'format' => 'raw'
//                    ],
//                    [
//                        'class' => 'yii\grid\ActionColumn',
//                        'header' => 'Actions',
//                        'template' => '{view} {delete}'
//                    ],
//                ],
//            ]); ?>
<!---->
<!--        </div>-->
<!---->
<!--    </div>-->
<!--    <div class="tab-pane --><?//= ($_GET['tab']) ? 'active' : '' ?><!--" id="content_03">-->
<!---->
<!---->
<!--        <div class="col-md-12">-->
<!--            <br/>-->
<!--            <p>-->
<!--                --><?//= Html::a("Create Vacation {$model->name_ru}", ["/vacation/create?company_id={$model->id}"], ["class" => "btn btn-success"]) ?>
<!--            </p>-->
<!---->
<!--            --><?//= GridView::widget([
//                'dataProvider' => $vacation,
//                'filterModel' => $vacationSearch,
//                'columns' => [
////            ['class' => 'yii\grid\SerialColumn'],
//
//                    [
//                        'value' => 'id',
//                        'label' => '№',
//                        'attribute' => 'id',
//                        'headerOptions' => ['style' => 'width:5%']
//                    ],
//                    [
//                        'label' => 'Названия',
//                        'attribute' => 'title',
//                        'value' => function ($model) {
//                            return HTML::a($model->title, "/vacation/update/{$model->id}");
//                        },
//                        'format' => 'raw'
//                    ],
//                    [
//                        'label' => 'Профиль',
//                        'attribute' => 'profile_id',
//                        'value' => function ($model) {
//                            return Html::a("{$model->profile->first_name}", "/profile/update/{$model->profile->id}");
//                        },
//                        'format' => 'raw'
//                    ],
//                    [
//                        'label' => 'Компания',
//                        'attribute' => 'company_id',
//                        'value' => function ($model) {
//                            return Html::a("{$model->company->name_ru}", "/company/update/{$model->company->id}");
//                        },
//                        'format' => 'raw'
//                    ],
//                    [
//                        'class' => 'yii\grid\ActionColumn',
//                        'header' => 'Actions',
//                        'template' => '{view} {delete}'
//                    ],
//                ],
//            ]); ?>
<!---->
<!--        </div>-->
<!---->
<!--    </div>-->
<?php //endif; ?>
<?php //if (!$model->isNewRecord) { ?>
<!--    <div class="row">-->
<!--        <div class="panel-heading">-->
<!--            Social links-->
<!--        </div>-->
<!--        <div class="panel-body">-->
<!--            <div class="row" id="social-list">-->
<!--                <div class='col-sm-12'>-->
<!--                    <table class='table'>-->
<!--                        <thead>-->
<!--                        <tr>-->
<!--                            <th>Social link</th>-->
<!--                            <th>Actions</th>-->
<!--                        </tr>-->
<!--                        </thead>-->
<!--                        <tbody>-->
<!--                        --><?php
//                        foreach ($social_links as $item) {
//                            echo "<tr>" .
//                                "<td><a href='" . $item->link . "'>" . $item->name . "</a></td>" .
//                                "<td><a href='' class='delete-link' id='{$item->id}'>delete</a></td>" .
//                                "</tr>";
//                        } ?>
<!--                        </tbody>-->
<!--                    </table>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="row">-->
<!--                <div class="col-sm-3">-->
<!--                    <select name="Social[name]" id="social-name">-->
<!--                        --><?php //foreach (\common\models\Social::$social as $value) {
//                            echo "<option value='$value'>" . ucfirst($value) . "</option>";
//                        } ?>
<!--                    </select>-->
<!--                </div>-->
<!--                <div class="col-sm-9">-->
<!--                    <div class="input-group">-->
<!--                        <input type="hidden" name="Social[company_id]" id="social-company"-->
<!--                               value="--><?//= $model->id ?><!--">-->
<!--                        <input type="text" class="form-control"-->
<!--                               placeholder="Copy link here..." name="Social[link]"-->
<!--                               id="social-link">-->
<!--                        <div class="help-block" id="link-help"></div>-->
<!--                        <div class="input-group-btn">-->
<!--                            <button class="btn btn-success" name="Social[save]"-->
<!--                                    id="social-save">save-->
<!--                            </button>-->
<!--                        </div>-->
<!--                    </div> /input-group -->
<!--                </div> /.col-lg-6 -->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<?php //} ?>
<?php
//$this->registerJs(<<< JS
//	$(document).ready(function(){
//		$('#social-list tbody').on('click', 'a.delete-link', function(e) {
//			let id = $(this).attr('id');
//			if (confirm('O\'chiryapsizmi?')) {
//				$(this).closest('tr').css('display', 'none');
//				$.ajax({
//				  url: '/company/delete-social?id=' + id,
//				  success: function(data) {
//				  	let raw = JSON.parse(data);
//				  	if (raw.status == 'error') {
//				  		alert("O'chirib bo'lmadi");
//				  	}
//				  	else if (raw.status == 'ok') {
//				  		alert("O'chirildi");
//				  	}
//				  },
//				});
//			}
//			e.preventDefault();
//		});
//
//		$('#social-save').on('click', function(e) {
//		  let data = {
//		  	name: $('#social-name').val(),
//		  	link: $('#social-link').val(),
//		  	company_id: $('#social-company').val()
//		  };
//		  $.ajax({
//		  	url: '/company/social',
//		  	data: data,
//		  	method: 'POST',
//		  	success: function(data) {
//		  	  	let raw = JSON.parse(data);
//		  	  	if (raw.status == 'error') {
//		  	  		if (raw.data.link)
//		  	  			alert(raw.data.link[0]);
//		  	  	}
//		  	  	else if (raw.status == 'ok') {
//		  	  		console.log(raw);
//		  	  		let html = "<tr>" +
//							"<td><a href='" + raw.data.link + "'>" + raw.data.name + "</a></td>" +
//							"<td><a href='javascript:void(0)' class='delete-link' id='" + raw.data.id + "'>delete</a></td>" +
//							"</tr>";
//			  	  		$('#social-list table tbody').append(html);
//		  	  	}
//		  	},
//		  	error: function(data) {
//		  	  console.log(data);
//		  	}
//		  });
//		  e.preventDefault();
//		})
//	})
//JS
//); ?>
