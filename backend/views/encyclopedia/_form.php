<?php

use common\modules\categories\widgets\CategoriesWidget;
use common\filemanager\widgets\InputModalWidget;
use common\models\Encyclopedia;
use common\modules\category\models\Category;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Encyclopedia */
/* @var $form yii\widgets\ActiveForm */
$user = \yii\helpers\ArrayHelper::map(\common\models\Profile::find()->all(), 'id', 'first_name');
?>
<?php $form = ActiveForm::begin(); ?>
<!--<div class="container-fluid">-->
<!--    <div class="row">-->

            <div class="col-lg-7">
                        <?= $form->field($model, 'title')->textInput([
                            'maxlength' => true,
                            'placeholder' => Yii::t("backend", "Title"),
                            'class' => 'form-control title-generate',
                            'autocomplete' => 'off'
                        ]) ?>

                        <?= $form->field($model, 'description')->textarea() ?>

                            <?= $form->field($model, 'text')->widget(CKEditor::className(), [
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

                            <div class="form-group">
                                <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
                            </div>

                </div>

            <div class="col-lg-5">
                <?php
                $category = $model->getCategoryNew();
                $data = ArrayHelper::map(\common\modules\category\models\Category::find()
                    ->andWhere(['status' => \common\modules\category\models\Category::STATUS_ACTIVE, 'type' => 'Encyclopedia'])
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
                ])->label(false);
                ?>

                <?= $form->field($model, 'slug')->textInput([
                    'class' => 'form-control slug-generate',
                    'placeholder' => Yii::t("backend", "Slug"),//'style' => 'display:none;'
                ])->label(false) ?>


                <?= $form->field($model, 'publish_time')
                    ->textInput(['class' => 'form-control', 'id' => 'datapicker-post', 'placeholder' => 'Publish time'])->label(false); ?>

                <?= $form->field($model, 'reference')->textarea(['rows' => 5]) ?>

                <?php
                if (is_null($model->status)) {
                    $model->status = Encyclopedia::STATUS_CREATED;
                }
                ?>

                <?php $status = [
                    Encyclopedia::STATUS_CREATED => 'CREATED',
                    Encyclopedia::STATUS_DECLINED => 'DECLINED',
                    Encyclopedia::STATUS_PENDING => 'PENDING',
                    Encyclopedia::STATUS_PUBLISHED => 'PUBLISHED',
                    Encyclopedia::STATUS_REVIEWED => 'REVIEWED'
                ]?>
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

                <?= $form->field($model, 'top')->checkbox([
                    'data-init-plugin' => 'switchery',
                    'label' => false,
                    'data-size' => 'small'])->label('Top')
                ?>



                <?php use \jakharbek\filemanager\widgets\FileInput; ?>
                <div class="panel-body">
                    <h6><?= __('Files') ?></h6>
                    <h6><?= __('Прикрепите фото к записи') ?></h6>
                    <p><?= __('Фотография для красоты вашего труда нажмите на кнопку и выберите фото') ?></p>
                    <?= $form->field($model, 'files')->widget(FileInput::class, [
                        'id' => 'file_image_id'
                    ])->label(false) ?>
                </div>


            </div>

<?php ActiveForm::end(); ?>

<?php $this->registerJs(<<< JS
	$('#datapicker-post').datetimepicker({
		format: 'dd.mm.yyyy h:i',
	});
 
JS
);
?>
