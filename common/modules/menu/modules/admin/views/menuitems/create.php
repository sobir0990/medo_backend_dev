<?php

use common\modules\langs\widgets\LangsWidgets;


/* @var $this yii\web\View */
/* @var $model common\modules\menu\models\MenuItems */

$this->title = 'Create Menu Items';
$this->params['breadcrumbs'][] = ['label' => 'Menu Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo LangsWidgets::widget();
?>
<div class="menu-items-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
