<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="col-lg-7">
                <?php $form = ActiveForm::begin(); ?>

                <div class="form-group form-group-default required ">
                    <label><?= __('Введите номер телефона: ') ?></label>
                <?= $form->field($model, 'phone')->textInput(
                    [
                        'maxlength' => true,
                        'class' => 'title-generate form-control',
                    ]
                )->label(false) ?>
                </div>

                <div class="form-group form-group-default required ">
                    <label><?= __('Введите пароль: ') ?></label>
                <?php
                if ($model->isNewRecord):
                    echo $form->field($model, 'password_hash')->textInput(
                        [
                            'maxlength' => true,
                            'class' => 'title-generate form-control',
                        ]
                    )->label(false);
                else:
                    echo $form->field($model, 'new_password')->textInput(
                        [
                            'maxlength' => true,
                            'class' => 'title-generate form-control',
                        ]
                    )->label(false);
                endif;
                ?>
                </div>

                <div class="form-group form-group-default required ">
                    <label><?= __('Введите E-mail: ') ?></label>
                <?= $form->field($model, 'email')->textInput(
                    [
                        'maxlength' => true,
                        'class' => 'title-generate form-control',
                    ]
                )->label(false) ?>
                </div>



                <div class="form-group form-group-default required ">
                    <label><?= __('Выберите роле: ') ?></label>
                <?= $form->field($model, 'role')->dropDownList(
                    [
                        User::ROLE_USER => 'User',
                        User::ROLE_DOCTOR => 'Doctor',
                        User::ROLE_REDACTOR => 'Redactor',
                        User::ROLE_MODER => 'Moder',
                        User::ROLE_ADMIN => 'Admin',
                    ]
                )->label(false) ?>
                </div>

                <div class="form-group form-group-default required ">
                    <label><?= __('Выберите статус: ') ?></label>
                <?= $form->field($model, 'status')->dropDownList(
                    [
                        User::STATUS_ACTIVE => Yii::t('backend', 'ACTIVE'),
                        User::STATUS_UNCONFIRMED => Yii::t('backend', 'UNCONFIRMED'),
                        User::STATUS_DELETED => Yii::t('backend', 'DELETED')
                    ]
                )->label(false) ?>
                </div>


                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

    <?php ActiveForm::end(); ?>
