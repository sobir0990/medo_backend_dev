<?php

/* @var $this yii\web\View */

use common\models\User;

$this->title = 'Boshqaruv paneli';
$this->params['breadcrumbs'][] = $this->title;
$counter = 1;
$status = ['O\'chirilgan', 'Faol'];
$qstat = [0 => 'Deactive', '2' => 'Pending', '5' => 'Active', '6' => 'Top'];
//$users = User::find()->orderBy('created_at DESC')->limit(8)->all();
$ucountjur = User::find()->count();
$ucountadv = User::find()->count();

?>
<div class="site-index">

    <div class="row">

    </div>
    <hr class="no-grid-gutter-h grid-gutter-margin-b no-margin-t">

    <div class="row">

        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <span class="panel-title">
                    <div class="panel-heading-controls">
                        <a href="/user/create"
                           class="btn btn-success"><?= Yii::t("backend", "Foyadalnuvchi qo'shish") ?></a>
                    </div> <!-- / .panel-heading-controls -->
                </div> <!-- / .panel-heading -->
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?= Yii::t("backend", "Name") ?></th>
                        <th><?= Yii::t("backend", "Phone") ?></th>
                    </tr>
                    </thead>
                    <tbody class="valign-middle">
                    <?php foreach ($user as $item) : ?>
                        <tr>
                            <td><?= $counter++ ?></td>
                            <td><?= $item->username ?></td>
                            <td><?= $item->phone ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
             <div align="center">
                 <?= \yii\widgets\LinkPager::widget([
                     'pagination' => $pages,
                     'activePageCssClass'=>'pagination',
                 ]); ?>
             </div>

            </div> <!-- / .panel -->
        </div>
    </div>
</div>