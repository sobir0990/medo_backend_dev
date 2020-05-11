<?php

use common\filemanager\widgets\InputModalWidget;
use common\models\Product;
use common\modules\categories\widgets\CategoriesWidget;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
$profile_id = ArrayHelper::map(\common\models\Profile::find()->orderBy(['id' => SORT_DESC])->all(), 'id', 'first_name');
$company_id = ArrayHelper::map(\common\models\Company::find()->orderBy(['id' => SORT_DESC])->all(), 'id', 'name_' . Yii::$app->language);
//$cities = ArrayHelper::map(\common\models\City::find()->all(), 'id', 'name_'.Yii::$app->language);

?>
<?php $form = ActiveForm::begin(); ?>
    <div class="col-lg-7">
        <?= $form->field($model, 'title_uz')->textInput([
            'maxlength' => true,
            'placeholder' => Yii::t("backend", "Эълонинг мавзусини киритинг"),
            'class' => 'form-control title-generate',
            'autocomplete' => 'off'
        ])->label('Title uz') ?>

        <?= $form->field($model, 'title_ru')->textInput([
            'maxlength' => true,
            'placeholder' => Yii::t("backend", "Название объявления"),
            'class' => 'form-control title-generate',
            'autocomplete' => 'off'
        ])->label('Title ru') ?>

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
            ])->label('Content uz') ?>

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
    //                          skin' => 'moono-lisa'
                ],
                'preset' => 'custom',
            ])->label('Content ru') ?>

            <?php if ($_GET['company_id']): ?>
                <?= $form->field($model, 'company_id')->dropDownList($company_id, [
                    'prompt' => Yii::t('backend', '--Выберите--'),
                    'options' => [$_GET['company_id'] => ['Selected' => true]], 'disabled' => 'disabled',
                ]) ?>

                <?= $form->field($model, 'company_id')->hiddenInput(['value' => $_GET['company_id']])->label(false) ?>
            <?php else: ?>
                <?= $form->field($model, 'company_id')->dropDownList($company_id, ['prompt' => Yii::t('backend', '--Выберите Компания--')])->label(false); ?>
            <?php endif; ?>

            <?= $form->field($model, 'status')->dropDownList([
                Product::STATUS_ACTIVE => 'Active',
                Product::STATUS_DEACTIVE => 'Deactive',
                Product::STATUS_WAITING => 'Waiting'

            ])
            ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <?= $form->field($model, 'price')->textInput(['placeholder' => 'price'])->label(false) ?>

        <?= $form->field($model, 'profile_id')->dropDownList($profile_id, ['prompt' => Yii::t('backend', '--Выберите Профил--')])->label(false) ?>

        <?php
        $category = $model->getCategoryNew();
        $data = ArrayHelper::map(\common\modules\category\models\Category::find()
            ->andWhere(['status' => \common\modules\category\models\Category::STATUS_ACTIVE, 'type' => 'Products'])
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



        <br>

        <?php if ($model->type): ?>
            <?= $form->field($model, 'type')
                ->dropDownList([Product::TYPE_PRODUCT => 'Products'], ['disabled' => true]) ?>
        <?php endif; ?>


        <?php
        if (is_null($model->status)) {
            $model->status = Product::STATUS_ACTIVE;
        }
        ?>
        <div class="form-group form-group-default">
        <?= $form->field($model, 'delivery')->checkbox([
            'data-init-plugin' => 'switchery',
            'label' => false,
            'data-size' => 'small'])->label('Delivery')
        ?>

        <?= $form->field($model, 'top')->checkbox([
            'data-init-plugin' => 'switchery',
            'label' => false,
            'data-size' => 'small'])->label('Top')
        ?>
        </div>

        <?php use \jakharbek\filemanager\widgets\FileInput; ?>
        <div class="panel-body">
            <h6><?= __('Files') ?></h6>
            <h6><?= __('Прикрепите фото к записи') ?></h6>
            <p><?= __('Фотография для красоты вашего труда нажмите на кнопку и выберите фото') ?></p>
            <?= $form->field($model, 'files')->widget(FileInput::class, [
                'id' => 'file_image_id'
            ])->label(false) ?>
        </div>
        <br>

        <div class="panel-body">
            <h6><?= __('Images') ?></h6>
            <h6><?= __('Прикрепите фото к записи') ?></h6>
            <p><?= __('Фотография для красоты вашего труда нажмите на кнопку и выберите фото') ?></p>
            <?= $form->field($model, 'images')->widget(FileInput::class, [
                'id' => 'images'
            ])->label(false) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
