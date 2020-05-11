<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = 'E\'lon qo\'shish';
$this->params['breadcrumbs'][] = ['label' => 'E\'lonlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo common\modules\langs\widgets\LangsWidgets::widget(); ?><br/>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
