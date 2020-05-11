<?php

use common\filemanager\widgets\InputModalWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\category\models\Category */
/* @var $form yii\widgets\ActiveForm */
$category = ArrayHelper::map(\common\modules\category\models\Category::find()->andWhere(['lang' => \common\modules\langs\components\Lang::getLangId()])->orderBy(['id' => SORT_DESC])->all(), 'id', 'name');
?>
<?php echo \oks\langs\widgets\LangsWidgets::widget(['model_db' => $model, 'create_url' => '/category/category/create']); ?>
<?php $form = ActiveForm::begin(); ?>

<br>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-8">


                    <div class="form-group form-group-default required ">
                        <label><?= __('Name: ') ?></label>
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false) ?>
                    </div>

                    <div class="form-group  form-group-default">
                        <label><?= __('Slug: ') ?></label>
                        <?= $form->field($model, 'slug')->textInput([
                            'class' => 'form-control slug-generate',
                        ])->label(false) ?>

                    </div>

                    <?php
                    echo $form->field($model, 'parent_id')->widget(\kartik\select2\Select2::classname(), [
                        'data' => \common\modules\category\models\Category::getList(),
                        'language' => 'en',
                        'theme' => \kartik\select2\Select2::THEME_KRAJEE,
                        'options' => [
                           'placeholder' => 'Выберите категория',
                            $model->parent_id => ['selected' => true]
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>

                    <div class="form-group form-group-default ">
                        <label><?= __('Sort: ') ?></label>
                        <?= $form->field($model, 'sort')->textInput()->label(false) ?>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>


                </div>

                <div class="col-md-4">
                    <?php use \jakharbek\filemanager\widgets\FileInput;?>
                    <?= $form->field($model, 'icon')->widget(FileInput::class,[
                        'id' => 'file_image_id'
                    ])->label(false) ?>

                    <?= $form->field($model, 'status')->dropDownList([
                        \common\modules\category\models\Category::STATUS_ACTIVE => 'Active',
                        \common\modules\category\models\Category::STATUS_NO_ACTIVE => 'No active',

                    ])
                    ?>


                </div>

            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
