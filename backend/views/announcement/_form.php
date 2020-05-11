<?php

use common\filemanager\widgets\InputModalWidget;
use common\models\Product;
use common\modules\categories\widgets\CategoriesWidget;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
$profile_id = ArrayHelper::map(\common\models\Profile::find()->orderBy(['id' => SORT_DESC])->all(), 'id', 'first_name');
$company_id = ArrayHelper::map(\common\models\Company::find()->orderBy(['id' => SORT_DESC])->all(), 'id', 'name_' . Yii::$app->language);

?>
<?php $form = ActiveForm::begin(); ?>
            <div class="col-lg-7">

                <?= $form->field($model, 'profile_id')->dropDownList($profile_id, ['prompt' => Yii::t('backend', '--Выберите--')]) ?>

                <?= $form->field($model, 'price')->textInput(['placeholder' => Yii::t("backend", "Price")])->label('Price') ?>

                <?= $form->field($model, 'type')->dropDownList([
                    Product::TYPE_ANNOUNCE => 'Elonlar',
                ]) ?>

                <?= $form->field($model, 'title_uz')->textInput([
                    'maxlength' => true,
                    'placeholder' => Yii::t("backend", "Эълонинг мавзусини киритинг"),
                    'class' => 'form-control title-generate',
                    'autocomplete' => 'off'
                ])->label('Эълонинг мавзусини киритинг') ?>

                <?= $form->field($model, 'title_ru')->textInput([
                    'maxlength' => true,
                    'placeholder' => Yii::t("backend", "Название объявления"),
                    'class' => 'form-control title-generate',
                    'autocomplete' => 'off'
                ])->label('Название объявления') ?>

                <div class="form-group">
                    <?= $form->field($model, 'content_uz')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6],
                        'clientOptions' => [
                            'allowedContent' => true,
                            'extraPlugins' => 'filemanager-jakhar, justify,font,print',
                            'height' => 150,
                            'toolbarGroups' => [
                                [
                                    'name' => 'filemanager-jakhar'
                                ],
                                ['name' => 'document', 'groups' => ['mode', 'document', 'doctools']],
                                ['name' => 'clipboard', 'groups' => ['clipboard', 'undo']],
                                ['name' => 'editing', 'groups' => ['find', 'selection', 'spellchecker']],
                                ['name' => 'basicstyles', 'groups' => ['basicstyles', 'colors', 'cleanup']],
                                '/',
                                ['name' => 'paragraph', 'groups' => ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']],
                                ['name' => 'links', 'groups' => ['links']],
                                ['name' => 'insert', 'groups' => ['insert']],
                                '/',
                                ['name' => 'styles', 'groups' => ['styles']],
                                ['name' => 'colors', 'groups' => ['colors']],
                                ['name' => 'tools', 'groups' => ['tools']],
                                ['name' => 'others', 'groups' => ['others']],
                            ],
                            'removeButtons' => '',
//                                    'skin' => 'moono-lisa'
                        ],
                        'preset' => 'custom',
                    ]) ?>
                    <?= $form->field($model, 'content_ru')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6],
                        'clientOptions' => [
                            'allowedContent' => true,
                            'extraPlugins' => 'filemanager-jakhar, justify,font,print',
                            'height' => 150,
                            'toolbarGroups' => [
                                [
                                    'name' => 'filemanager-jakhar'
                                ],
                                ['name' => 'document', 'groups' => ['mode', 'document', 'doctools']],
                                ['name' => 'clipboard', 'groups' => ['clipboard', 'undo']],
                                ['name' => 'editing', 'groups' => ['find', 'selection', 'spellchecker']],
                                ['name' => 'basicstyles', 'groups' => ['basicstyles', 'colors', 'cleanup']],
                                '/',
                                ['name' => 'paragraph', 'groups' => ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']],
                                ['name' => 'links', 'groups' => ['links']],
                                ['name' => 'insert', 'groups' => ['insert']],
                                '/',
                                ['name' => 'styles', 'groups' => ['styles']],
                                ['name' => 'colors', 'groups' => ['colors']],
                                ['name' => 'tools', 'groups' => ['tools']],
                                ['name' => 'others', 'groups' => ['others']],
                            ],
                            'removeButtons' => '',
                        ],
                        'preset' => 'custom',
                    ]) ?>


                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>


            </div>

            <div class="col-lg-5">


                <?= $form->field($model, 'company_id')->widget(\kartik\select2\Select2::classname(), [
                    'data' => $company_id,
                    'language' => 'en',
                    'options' => [
                        'placeholder' => 'Выберите компания',
                        'value' => $model->company_id
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])->label('компания');
                ?>

                <?php
                $category = $model->getCategoryNew();
                $data = ArrayHelper::map(\common\modules\category\models\Category::find()
                    ->andWhere(['status' => \common\modules\category\models\Category::STATUS_ACTIVE, 'parent_id' => 4])
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



                <?php
                if (is_null($model->status)) {
                    $model->status = Product::STATUS_ACTIVE;
                }
                ?>
                <?php $status = [
                    Product::STATUS_ACTIVE => 'Active',
                    Product::STATUS_DEACTIVE => 'Deactive',
                    Product::STATUS_WAITING => 'Waiting'
                ]
                ?>

                <?= $form->field($model, 'status')->widget(\kartik\select2\Select2::classname(), [
                    'data' => $status,
                    'language' => 'en',
                    'options' => [
                        'placeholder' => 'Выберите статус',
                        'value' => $model->status
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
//                                    'minimumInputLength' => 2
                    ],
                ])->label('Status');
                ?>


                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title"><?= __('Files') ?></span>
                        <h6><?= __('Прикрепите фото к записи') ?></h6>
                        <p><?= __('Фотография для красоты вашего труда нажмите на кнопку и выберите фото') ?></p>
                    </div>
                    <div class="panel-body">
                        <?php use \jakharbek\filemanager\widgets\FileInput; ?>
                        <?= $form->field($model, 'files')->widget(FileInput::class, [
                            'id' => 'files'
                        ])->label(false) ?>
                    </div>

                    <div class="panel-heading">
                        <span class="panel-title"><?= __('Images') ?></span>
                        <h6><?= __('Прикрепите фото к записи') ?></h6>
                        <p><?= __('Фотография для красоты вашего труда нажмите на кнопку и выберите фото') ?></p>
                    </div>
                    <div class="panel-body">
                        <?= $form->field($model, 'images')->widget(FileInput::class, [
                            'id' => 'images'
                        ])->label(false) ?>
                    </div>

                    <?= $form->field($model, 'delivery')->checkbox([
                        'data-init-plugin' => 'switchery',
                        'label' => false,
                        'data-size' => 'small'])->label('Доставка')
                    ?>

                    <?= $form->field($model, 'top')->checkbox([
                        'data-init-plugin' => 'switchery',
                        'label' => false,
                        'data-size' => 'small'])->label('Top')
                    ?>
                </div>


                <?php ActiveForm::end(); ?>
            </div>

