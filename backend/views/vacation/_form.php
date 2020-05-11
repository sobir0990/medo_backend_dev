<?php

use common\components\Categories;
use common\models\Profile;
use common\models\Vacation;
use dosamigos\ckeditor\CKEditor;
use jakharbek\filemanager\widgets\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Vacation */
/* @var $form yii\widgets\ActiveForm */
$profile_id = ArrayHelper::map(Profile::find()->orderBy(['id' => SORT_DESC])->all(), 'id', 'first_name');
$company_id = ArrayHelper::map(\common\models\Company::find()->orderBy(['id' => SORT_DESC])->all(), 'id', 'name_uz');
$cities = ArrayHelper::map(\common\models\City::find()->all(), 'id', 'name_' . Yii::$app->language);
$profiles = Profile::find()->all();
$places = ArrayHelper::map(Categories::findAll(['type' => Categories::TYPE_COMPANY, 'lang' => 3]), 'id', 'name')
?>

<?php $form = ActiveForm::begin(); ?>
<div class="col-lg-7">

    <?php if ($_GET['profile_id']): ?>
        <?= $form->field($model, 'profile_id')->dropDownList(ArrayHelper::map($profiles, 'id', function ($profile) {
            return $profile->first_name;
        }), ['prompt' => "Выберите профиль", 'options' => [$_GET['profile_id'] => ['Selected' => true]], 'disabled' => 'disabled']) ?>
        <?= $form->field($model, 'profile_id')->hiddenInput(['value' => $_GET['id']])->label(false) ?>
    <?php else: ?>
        <?= $form->field($model, 'profile_id')->dropDownList(ArrayHelper::map($profiles, 'id', function ($profile) {
            return $profile->first_name;
        })) ?>
    <?php endif; ?>

    <?php if ($_GET['company_id']): ?>
        <?= $form->field($model, 'company_id')->dropDownList($company_id, ['options' => [$_GET['company_id'] => ['Selected' => true]], 'disabled' => 'disabled']) ?>
        <?= $form->field($model, 'company_id')->hiddenInput(['value' => $_GET['company_id']])->label(false) ?>
    <?php else: ?>
        <?= $form->field($model, 'company_id')->dropDownList($company_id); ?>
    <?php endif; ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

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
            ],
            'preset' => 'custom',
        ])->label(Yii::t('backend', 'Описание на русском')) ?>

        <?= $form->field($model, 'salary')->textInput() ?>

        <?= $form->field($model, 'salary_to')->textInput() ?>


        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

</div>

<div class="col-lg-5">
    <?php
    $category = $model->getCategoryNew();
    $data = ArrayHelper::map(\common\modules\category\models\Category::find()
        ->andWhere(['status' => \common\modules\category\models\Category::STATUS_ACTIVE, 'type' => 'Vacation'])
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
//                                    'minimumInputLength' => 2
        ],
    ])->label('Category');
    ?>

    <?= $form->field($model, 'place_id')->widget(\kartik\select2\Select2::classname(), [
        'data' => $places,
        'language' => 'en',
        'options' => [
            'placeholder' => 'Выберите place',
            'value' => $model->place_id
        ],
        'pluginOptions' => [
            'allowClear' => true,
//                      'minimumInputLength' => 2
        ],
    ])->label('Place');
    ?>

    <?= $form->field($model, 'type')->dropDownList([
        Vacation::TYPE_FULL => 'FULL',
        Vacation::TYPE_PART => 'PART',
        Vacation::TYPE_PROJECT => 'PROJECT',
        Vacation::TYPE_SHIFT => 'SHIFT',

    ])
    ?>

    <?php ?>
    <div class="panel-body">
        <h6><?= __('Files') ?></h6>
        <h6><?= __('Прикрепите фото к записи') ?></h6>
        <p><?= __('Фотография для красоты вашего труда нажмите на кнопку и выберите фото') ?></p>
        <?= $form->field($model, 'files')->widget(FileInput::class, [
            'id' => 'file_image_id'
        ])->label(false) ?>
    </div>

    <?php
    if (is_null($model->status)) {
        $model->status = \common\models\Resume::STATUS_ACTIVE;
    }
    ?>
    <?php $status = [
        Vacation::STATUS_ACTIVE => 'Active',
        Vacation::STATUS_DEACTIVE => 'Deactive',
        Vacation::STATUS_WAITING => 'Waiting'
    ] ?>

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
    ])->label(false);
    ?>
</div>
<?php ActiveForm::end(); ?>
