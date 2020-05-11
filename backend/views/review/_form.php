<?php

use common\models\Review;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Review */
/* @var $form yii\widgets\ActiveForm */
$profile_id = \yii\helpers\ArrayHelper::map(\common\models\Profile::find()->all(), 'id', 'first_name');
$product_id = \yii\helpers\ArrayHelper::map(\common\models\Product::find()->all(), 'id', 'title_' . Yii::$app->language);

?>

<?php $form = ActiveForm::begin(); ?>

    <div class="col-lg-7">
        <?= $form->field($model, 'profile_id')->widget(\kartik\select2\Select2::classname(), [
            'data' => $profile_id,
            'language' => 'en',
            'options' => [
                'placeholder' => 'Выберите продукт',
                'value' => $model->profile_id
            ],
            'pluginOptions' => [
                'allowClear' => true,
//                                    'minimumInputLength' => 2
            ],
        ])->label('Profile');
        ?>

        <?= $form->field($model, 'product_id')->widget(\kartik\select2\Select2::classname(), [
            'data' => $product_id,
            'language' => 'en',
            'options' => [
                'placeholder' => 'Выберите продукт',
                'value' => $model->product_id
            ],
            'pluginOptions' => [
                'allowClear' => true,
//                                    'minimumInputLength' => 2
            ],
        ])->label('Product');
        ?>

        <?php
        $data = ArrayHelper::map(\common\models\Company::find()->all(), 'id', 'name_ru')
        ?>
        <?= $form->field($model, 'company_id')->widget(\kartik\select2\Select2::classname(), [
            'data' => $data,
            'language' => 'en',
            'options' => [
                'placeholder' => 'Выберите компания',
                'value' => $model->company_id
            ],
            'pluginOptions' => [
                'allowClear' => true,
//                                    'minimumInputLength' => 2
            ],
        ])->label('Company');
        ?>

        <div class="form-group">
            <?php echo common\filemanager\widgets\ModalWidget::widget(); ?>
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
        <?= $form->field($model, 'rating')->textInput() ?>

        <?php
        if (is_null($model->status)) {
            $model->status = Review::STATUS_ACTIVE;
        }
        ?>
        <?= $form->field($model, 'status')->dropDownList([
            Review::STATUS_ACTIVE => 'Active',
            Review::STATUS_DEACTIVE => 'Deactive',
            Review::STATUS_WAITING => 'Waiting'

        ])
        ?>
        <?php ActiveForm::end(); ?>

    </div>
