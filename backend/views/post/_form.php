<?php

use common\models\Post;
use yii\widgets\Pjax;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
$profile_id = ArrayHelper::map(\common\models\Profile::find()->orderBy(['id' => SORT_DESC])->all(), 'id', 'first_name');
$category = ArrayHelper::map(\common\modules\category\models\Category::find()->orderBy(['id' => SORT_DESC])->all(), 'id', 'name');
$company_id = ArrayHelper::map(\common\models\Company::find()->orderBy(['id' => SORT_DESC])->all(), 'id', 'name_' . Yii::$app->language);
?>
<style>
    .langs-panel > li {
        display: block !important;
    }
</style>

<?php $form = ActiveForm::begin(); ?>
<div class="col-lg-7">
    <div class="form-group">

        <?= $form->field($model, 'title')->textInput([
            'maxlength' => true,
            'placeholder' => Yii::t('backend', 'Мақоланинг мавзусини киритинг'),
            'class' => 'form-control title-generate',
            'autocomplete' => 'off'
        ])->label(false) ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'slug')->textInput([
            'class' => 'form-control slug-generate',
            'placeholder' => Yii::t('backend', 'Url'),//'style' => 'display:none;'
        ])->label(false) ?>

    </div>

    <?= $form->field($model, 'publish_time')->textInput(['class' => 'form-control', 'id' => 'datapicker-post', 'placeholder' => 'Publish time', 'autocomplete' => 'off'])->label(false) ?>

    <div class="form-group">
        <?= $form->field($model, 'description')->textarea([
            'autocomplete' => 'off',
            'placeholder' => Yii::t('backend', 'Мақоланинг анонсини киритинг'),
        ])->label(false) ?>
    </div>

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
        ])->label(false) ?>

        <?= $form->field($model, 'type')->dropDownList([
            Post::TYPE_NEWS => Yii::t('backend', 'NEWS'),
            Post::TYPE_ARTICLE => Yii::t('backend', 'ARTICLE'),
        ])->label('Тип') ?>


        <?php
        if (is_null($model->status)) {
            $model->status = Post::STATUS_ACTIVE;
        }
        ?>

        <?= $form->field($model, 'status')->dropDownList([
            Post::STATUS_ACTIVE => 'Active',
            Post::STATUS_DEACTIVE => 'Deactive',
            Post::STATUS_WAITING => 'Waiting'

        ])
        ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

    </div>

</div>

<div class="col-lg-5">
    <div class="panel-body">

<!--        --><?php
//        $category = $model->getCategoryNew();
//        $data = ArrayHelper::map(\common\modules\category\models\Category::find()->all(), 'id', 'name')
//        ?>
<!--        --><?//= $form->field($model, 'category_id')->widget(\kartik\select2\Select2::classname(), [
//            'data' => $data,
//            'language' => 'en',
//            'options' => [
//                'placeholder' => 'Выберите категория',
//                'value' => $category->category_id
//            ],
//            'pluginOptions' => [
//                'allowClear' => true,
//                //                                    'minimumInputLength' => 2
//            ],
//        ])->label('Category');
//        ?>

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
</div>

<?php ActiveForm::end(); ?>
<?php $this->registerJs(<<< JS
	$('#datapicker-post').datepicker({
		format: 'dd.mm.yyyy',
	});
 
JS
);
?>
