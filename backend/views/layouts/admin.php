<?php


use common\widgets\Alert;
use yii\helpers\Html;

\backend\assets\AppAsset::register(Yii::$app->view);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="<?= $this->getImageUrl('img/sircle.png') ?>" rel="shortcut icon" type="image/x-icon">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="fixed-header dashboard menu-pin">
<?php $this->beginBody() ?>

<?= \backend\widgets\Sidebar::widget() ?>

<div class="page-container">
    <div class="page-content-wrapper">
        <?= \backend\widgets\TopBar::widget() ?>

        <div class="content">
            <div class="container-fluid container-fixed-lg bg-white">
                <div class="card card-transparent">
                    <div class="card-body">
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>

        <?= \backend\widgets\Footer::widget() ?>
    </div>
</div>
<?php

$session = Yii::$app->session;
$successMessage = false;

if ($session->getFlash('successMessage', null, true)) { ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        swal("Актирован", {
            button: false,
            icon: "success",
            timer: 2000
        });
    </script>
<?php
}elseif ($session->getFlash('deactiveMessage')) {?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        swal("Деактирован", {
            button: false,
            icon: "error",
            timer: 2000
        });
    </script>
<?php } ?>
<?= Alert::widget() ?>
<?php
$this->registerJs(
    '$(".pgn-wrapper").animate({opacity: 1.0}, 3000).fadeOut("slow");'
);
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
