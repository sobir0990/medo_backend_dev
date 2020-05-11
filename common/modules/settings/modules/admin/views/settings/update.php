<?php

use common\modules\langs\widgets\LangsWidgets;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\settings\models\Settings */

$this->title = 'Update Settings: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->setting_id]];
$this->params['breadcrumbs'][] = 'Update';

echo LangsWidgets::widget(['model_db' => $model,'create_url' => '/settings/settings/create/']);
?>
<div class="settings-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
