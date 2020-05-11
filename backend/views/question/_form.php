<?php

use common\modules\categories\widgets\CategoriesWidget;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\TestQuestion */
/* @var $answers common\models\TestAnswer[] */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-lg-7">

        <?= $form->field($model, 'question')->textarea(['rows' => 5])->label(Yii::t('backend', 'Введите вопрос')) ?>

        <?php if ($model->isNewRecord === false) : ?>
            <div class="form-group">
                <a href="/question/answer" class="btn btn-info">Новый ответ</a>
            </div>
            <?php Pjax::begin() ?>
            <h4>Ответы</h4>
            <table border="1" width="100%">
                <tr>
                    <th width="500" style="text-align:center;">Content</th>
                    <th style="text-align:center;">Correct</th>
                </tr>
                <?php foreach ($answers as $answer) : ?>
                    <tr>

                        <td><?= $answer->answer ?></td>
                        <td>
                            <?php if ($answer->correct) echo '✅' ?>
                            <a href="/question/delete-answer?id=<?= $answer->id ?>">delete</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
            <!--        --><?php //for ($i = 0; $i < 4; $i++) :?>
            <!--        <div class="input-group col-sm-12">-->
            <!--            <input type="hidden" name="Answers[--><? //= $i ?><!--][id]">-->
            <!--            <input type="hidden" name="Answers[--><? //= $i ?><!--][question_id]">-->
            <!--            <input type="text" class="form-control" name="Answers[--><? //= $i ?><!--][answer]" placeholer="Answer text">-->
            <!--            <span class="input-group-addon">-->
            <!--                <input type="radio" name="correct" value="--><? //= $i ?><!--">-->
            <!--            </span>-->
            <!--        </div>-->
            <!--        --><?php //endfor ?>
            <!--        <div class="form-group">-->
            <!--            <a href="#" class="btn btn-info">Новый ответ</a>-->
            <!--        </div>-->
            <?php Pjax::end() ?>
        <?php endif ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

    </div>
    <div class="col-lg-5">

        <?php
        $category = $model->getCategoryNew();
        $data = \common\modules\category\models\Category::getList()
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
    </div>
    <?php ActiveForm::end(); ?>
