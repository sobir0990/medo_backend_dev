<?php
$this->title = Yii::t('yoshlar-settings', 'Settings');
$types = \common\modules\settings\models\Settings::find()->types();

use common\modules\langs\widgets\LangsWidgets; ?>
<div class="settings-default-index">

    <?php echo LangsWidgets::widget(); ?>

    <br>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <?php $t = 0;
        foreach ($types as $key_type => $type): $t++; ?>
            <?php
            if ($t == 1) {
                $class = "active";
            } else {
                $class = "";
            }
            ?>
            <li class="<?= $class ?>"><a href="#setting-data-<?= $key_type ?>" data-toggle="tab"><?= $type ?></a></li>
        <?php endforeach; ?>
    </ul>

    <!-- Tab panes -->
    <?php $form = yii\widgets\ActiveForm::begin(); ?>
    <div class="tab-content">
        <?php $t = 0;
        foreach ($types as $key_type => $type): $t++; ?>
            <?php
            if ($t == 1) {
                $class = "active";
            } else {
                $class = "";
            }
            ?>
            <div class="tab-pane <?= $class ?>" id="setting-data-<?= $key_type ?>">
                <?php $settings = \common\modules\settings\models\Settings::find()->type($key_type)->all(); ?>
                <?php foreach ($settings as $setting): ?>
                    <?php echo $setting->generateForm($form); ?>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="row" style="margin-top:10px;">
        <div class="form-group">
            <?= \yii\helpers\Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php yii\widgets\ActiveForm::end(); ?>
</div>