<?php

use common\components\Categories;
use common\filemanager\widgets\InputModalWidget;
use common\filemanager\widgets\ModalWidget;
use common\models\Profile;
use common\models\Resume;
use common\modules\categories\widgets\CategoriesWidget;
use common\modules\category\models\Category;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Resume */
/* @var $form yii\widgets\ActiveForm */
$profile_id = ArrayHelper::map(Profile::find()->orderBy(['id' => SORT_DESC])->all(), 'id', 'first_name');
//$cities = ArrayHelper::map(\common\models\City::find()->all(), 'id', 'name');
$profiles = Profile::find()->all();
//$places = ArrayHelper::map(Categories::findAll(['type' => Categories::TYPE_COMPANY, 'lang' => 3]), 'id', 'name')
?>

            <div class="col-lg-7">
                <?php $form = ActiveForm::begin(); ?>
                <?php if ($_GET['profile_id']): ?>
                    <?= $form->field($model, 'profile_id')->dropDownList(ArrayHelper::map($profiles, 'id', function ($profile) {
                        return $profile->first_name;
                    }), ['options' => [$_GET['profile_id'] => ['Selected' => true]], 'disabled' => 'disabled']) ?>
                    <?= $form->field($model, 'profile_id')->hiddenInput(['value' => $_GET['id']])->label(false) ?>
                <?php else: ?>
                    <?= $form->field($model, 'profile_id')->dropDownList(ArrayHelper::map($profiles, 'id', function ($profile) {
                        return $profile->first_name;
                    })) ?>
                <?php endif; ?>

                <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Title')) ?>

                <?= $form->field($model, 'experience')->textInput(['maxlength' => true]) ?>

                <div class="form-group">
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
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                  <?php   $category = $model->getCategoryNew();
                  $category_id = Category::find()->andWhere(['slug' => 'Vacation'])->one();
                  $data = ArrayHelper::map(Category::find()
                      ->andWhere(['status' => Category::STATUS_ACTIVE])
                      ->andWhere(['parent_id' => $category_id->id])
                      ->all(), 'id', 'name') ?>

                <?= $form->field($model, 'category_id')->widget(\kartik\select2\Select2::classname(), [
                    'data' => $data,
                    'language' => 'en',
                    'options' => [
                        'placeholder' => 'Выберите категория',
                        'value' => $category->category_id
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
//                                    'minimumInputLength' => 2
                    ],
                ])->label('Category');
                ?>

                <?= $form->field($model, 'salary')->textInput() ?>

                <?php
                if (is_null($model->status)) {
                    $model->status = Resume::STATUS_ACTIVE;
                }
                ?>
                <?= $form->field($model, 'status')->dropDownList([
                    Resume::STATUS_DEACTIVE => Yii::t('backend', 'DEACTIVE'),
                    Resume::STATUS_WAITING => Yii::t('backend', 'WAITING'),
                    Resume::STATUS_ACTIVE => Yii::t('backend', 'ACTIVE'),
                ]); ?>

                <?php
                $category = $model->getCategoryNew();
                $data = ArrayHelper::map(\common\modules\category\models\Category::find()
                    ->andWhere(['status' => Category::STATUS_ACTIVE])
                    ->andWhere(['type' => 'Profile'])
                    ->all(), 'id', 'name')
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

