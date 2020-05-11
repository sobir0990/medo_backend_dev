<?php

use common\models\Profile;
use common\models\User;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Profile */
/* @var $form yii\widgets\ActiveForm */
$user_id = ArrayHelper::map(\common\models\User::find()->orderBy(['id' => SORT_DESC])->all(), 'id', 'username');
$city = ArrayHelper::map(\common\models\City::find()->orderBy(['id' => SORT_DESC])->all(), 'id', 'name_ru');
$region = ArrayHelper::map(\common\models\Region::find()->orderBy(['id' => SORT_DESC])->all(), 'id', 'name_ru');
$company_id = ArrayHelper::map(\common\models\Company::find()->orderBy(['id' => SORT_DESC])->all(), 'id', 'name_ru');

?>
        <div class="m-portlet__head">
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--left m-tabs-line--primary" id="contents">

                    <li class="nav-item m-tabs__item <?= (!$_GET['tab']) ? 'active' : '' ?>">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#content_01">
                            Профил
                        </a>
                    </li>
                    <?php if ($_GET['id']): ?>
                        <li class="nav-item m-tabs__item <?= ($_GET['tab'] == '02') ? 'active' : '' ?>">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#content_02">
                                Резюме
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item <?= ($_GET['tab'] == '03') ? 'active' : '' ?>">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#content_03">
                                Вакансия
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane <?= (!$_GET['tab']) ? 'active' : '' ?>" id="content_01">
                <div class="col-lg-6">
                    <div class="profile-form">
                        <?php $form = ActiveForm::begin(); ?>
                        <div class="panel-heading">
                            User Authorization Data
                        </div>

                        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'gender')->dropDownList([
                            0 => 'Танланг',
                            Profile::MALE => 'Эркак',
                            Profile::FAMALE => 'Аёл'
                        ]) ?>

                        <div class="">
                            <?php
                            if ($user->isNewRecord):
                                echo $form->field($user, 'password_hash')
                                    ->textInput(['maxlength' => true, 'class' => 'title-generate form-control', 'placeholder' => 'Пароль'])->label('Пароль');
                            else:
                                echo $form->field($user, 'new_password')
                                    ->textInput(['maxlength' => true, 'class' => 'title-generate form-control', 'placeholder' => 'Новый пароль'])->label('Новый пароль');
                            endif;
                            ?>

                            <?= $form->field($user, 'email')
                                ->textInput(['maxlength' => true, 'class' => 'title-generate form-control', 'placeholder' => 'E-mail'])->label('E-mail') ?>

                            <?= $form->field($user, 'phone')
                                ->textInput(['maxlength' => true, 'class' => 'title-generate form-control', 'placeholder' => 'Телеофон'])->label('Телеофон') ?>


                            <?= $form->field($user, 'role')->dropDownList(
                                [
                                    User::ROLE_USER => 'User',
                                    User::ROLE_DOCTOR => 'Doctor',
                                    User::ROLE_REDACTOR => 'Redactor',
                                    User::ROLE_MODER => 'Moder',
                                    User::ROLE_ADMIN => 'Admin',
                                ]
                            )->label('Role') ?>

                            <?= $form->field($user, 'status')->dropDownList(
                                [
                                    User::STATUS_ACTIVE => Yii::t('backend', 'ACTIVE'),
                                    User::STATUS_UNCONFIRMED => Yii::t('backend', 'UNCONFIRMED'),
                                    User::STATUS_DELETED => Yii::t('backend', 'DELETED')
                                ]
                            )->label('Status') ?>
                        </div>

                        <?= $form->field($model, 'type')->dropDownList([
                            Profile::TYPE_USER => 'USER',
                            Profile::TYPE_DOCTOR => 'DOCTOR'
                        ]) ?>

                        <?= $form->field($model, 'balance')->textInput() ?>

                        <div class="form-group">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                        </div>

                    </div>
                </div>
                <div class="col-lg-5">

                    <?= $form->field($model, 'region_id')->dropDownList($region); ?>

                    <?= $form->field($model, 'city_id')->dropDownList($city) ?>

                    <?php
                    $category = $model->getCategoryNew();
                    $data = ArrayHelper::map(\common\modules\category\models\Category::find()
                        ->andWhere(['status' => \common\modules\category\models\Category::STATUS_ACTIVE, 'type' => 'Profile'])
                        ->all(), 'id', 'name')
                    ?>
                    <?= $form->field($model, 'category_id')->widget(\kartik\select2\Select2::classname(), [
                        'data' => $data,
                        'language' => 'en',
                        'options' => [
                            'placeholder' => 'Выберите категория',
                            'value' => $category->category_id
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
//                    'minimumInputLength' => 2
                        ],
                    ])->label('Category');
                    ?>

                    <?= $form->field($model, 'instagram')->textInput() ?>

                    <?= $form->field($model, 'twitter')->textInput() ?>

                    <?= $form->field($model, 'facebook')->textInput() ?>

                    <?= $form->field($model, 'telegram')->textInput() ?>

                    <?= $form->field($model, 'google_plus')->textInput() ?>

                    <?= $form->field($model, 'status')->dropDownList([
                        Profile::STATUS_DEACTIVE => Yii::t('backend', 'DEACTIVE'),
                        Profile::STATUS_WAITING => Yii::t('backend', 'WAITING'),
                        Profile::STATUS_ACTIVE => Yii::t('backend', 'ACTIVE'),
                    ]); ?>

                    <?php use \jakharbek\filemanager\widgets\FileInput; ?>
                    <div class="panel-body">
                        <h6><?= __('Image') ?></h6>
                        <h6><?= __('Прикрепите фото к записи') ?></h6>
                        <p><?= __('Фотография для красоты вашего труда нажмите на кнопку и выберите фото') ?></p>
                        <?= $form->field($model, 'image')->widget(FileInput::class, [
                            'id' => 'file_image_id'
                        ])->label(false) ?>
                    </div>


                    <?php ActiveForm::end(); ?>
                </div>

            </div>


            <?php if ($_GET['id']): ?>
                <div class="tab-pane <?= ($_GET['tab'] == '02') ? 'active' : '' ?>" id="content_02">
                    <div class="col-md-12">
                        <br/>
                        <p>
                            <?= Html::a("Create Resume {$model->first_name}", ["/resume/create?profile_id={$model->id}"], ["class" => "btn btn-success"]) ?>
                        </p>

                        <?= GridView::widget([
                            'dataProvider' => $resume,
                            'filterModel' => $reSearch,
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
                                    'value' => function ($model) {
                                        return HTML::a($model->title, "/resume/update/{$model->id}");
                                    },
                                    'format' => 'raw'
                                ],
                                [
                                    'label' => 'Профиль',
                                    'attribute' => 'profile_id',
                                    'value' => function ($model) {
                                        return Html::a("{$model->profile->first_name}", "/profile/update/{$model->profile->id}");
                                    },
                                    'format' => 'raw'
                                ],
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
                </div>

                <div class="tab-pane <?= ($_GET['tab'] == '03') ? 'active' : '' ?>" id="content_03">
                    <div class="col-md-12">
                        <br/>
                        <p>
                            <?= Html::a("Create Vacation {$model->first_name}", ["/vacation/create?profile_id={$model->id}"], ["class" => "btn btn-success"]) ?>
                        </p>

                        <?= GridView::widget([
                            'dataProvider' => $vacation,
                            'filterModel' => $vaSearch,
                            'tableOptions' => [
                                'class' => 'table table-hover dataTable no-footer',
                                'id' => 'basicTable'
                            ],
                            'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'value' => 'id',
                                    'label' => '№',
                                    'attribute' => 'id',
                                    'headerOptions' => ['style' => 'width:5%']
                                ],
                                [
                                    'label' => 'Названия',
                                    'attribute' => 'title',
                                    'value' => function ($model) {
                                        return HTML::a($model->title, "/vacation/update/{$model->id}");
                                    },
                                    'format' => 'raw'
                                ],
                                [
                                    'label' => 'Профиль',
                                    'attribute' => 'profile_id',
                                    'value' => function ($model) {
                                        return Html::a("{$model->profile->first_name}", "/profile/update/{$model->profile->id}");
                                    },
                                    'format' => 'raw'
                                ],
                                [
                                    'label' => 'Компания',
                                    'attribute' => 'company_id',
                                    'value' => function ($model) {
                                        return Html::a("{$model->company->name_ru}", "/company/update/{$model->company->id}");
                                    },
                                    'format' => 'raw'
                                ],
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
                </div>
            <?php endif; ?>

        </div>
