<?php

use common\models\Company;
use dosamigos\ckeditor\CKEditor;
use jakharbek\filemanager\widgets\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this  yii\web\View
 * @var $model common\models\Company
 * @var $form  yii\widgets\ActiveForm
 */
$profile_id = ArrayHelper::map(\common\models\Profile::find()->orderBy(['id' => SORT_DESC])->all(), 'id', 'first_name');
$cities = ArrayHelper::map(\common\models\City::find()->all(), 'id', 'name_ru');
$city = ArrayHelper::map(\common\models\City::find()->orderBy(['id' => SORT_DESC])->all(), 'id', 'name_ru');
$region = ArrayHelper::map(\common\models\Region::find()->orderBy(['id' => SORT_DESC])->all(), 'id', 'name_ru');
if (!$model->isNewRecord) $social_links = \common\models\Social::findAll(['company_id' => $model->id]);
?>
<?php $form = ActiveForm::begin(); ?>
<div class="col-lg-7">

    <?= $form->field($model, 'name_uz')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Узбекча Номи')) ?>

    <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true])->label(Yii::t('backend', 'Имя на русском')) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= $form->field($model, 'description_uz')->widget(CKEditor::className(), [
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
        ])->label(Yii::t('backend', 'ўзбекча тавсивни киритинг')) ?>

        <?= $form->field($model, 'description_ru')->widget(CKEditor::className(), [
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
        ])->label(Yii::t('backend',
            'Описание на русском')) ?>

        <?= $form->field($model, 'page_ru')->widget(CKEditor::className(), [
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
        ])->label(Yii::t('backend',
            'Полное описание на русском')) ?>


        <?= $form->field($model, 'page_uz')->widget(CKEditor::className(), [
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
        ])->label(Yii::t('backend',
            'To\'liq matn uz')) ?>


        <?= $form->field($model, 'region_id')->dropDownList($region); ?>

        <?= $form->field($model, 'city_id')->dropDownList($city) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>


</div>
<div class="col-lg-5">
    <?= $form->field($model, 'profile_id')->dropDownList($profile_id) ?>

    <?= $form->field($model, 'type')->dropDownList([
        Company::TYPE_MAINTAINER => 'Прозводитель',
        Company::TYPE_PROVIDER => 'Поставщик',
        Company::TYPE_MED_INSTITUTE => 'Мед учреждение',
        Company::TYPE_MED_SCHOOL => 'Мед училище'
    ]) ?>

    <?php
    $category = $model->getCategoryNew();
    $data = ArrayHelper::map(\common\modules\category\models\Category::find()
        ->andWhere(['status' => \common\modules\category\models\Category::STATUS_ACTIVE, 'type' => 'Company'])
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
    <?php
    if (is_null($model->status)) {
        $model->status = Company::STATUS_ACTIVE;
    }
    ?>
    <?= $form->field($model, 'status')->dropDownList([
        Company::STATUS_ACTIVE => 'Active',
        Company::STATUS_DEACTIVE => 'Deactive',
        Company::STATUS_WAITING => 'Waiting'

    ])
    ?>
    <div class="panel-body">
        <h6><?= __('Files') ?></h6>
        <h6><?= __('Прикрепите фото к записи') ?></h6>
        <p><?= __('Фотография для красоты вашего труда нажмите на кнопку и выберите фото') ?></p>
        <?= $form->field($model, 'image')->widget(FileInput::class, [
            'id' => 'file_image_id'
        ])->label(false) ?>
    </div>


</div>

<?php ActiveForm::end(); ?>


