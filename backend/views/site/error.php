<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<body class="page-<?=substr($code, 0, 1) == 4 ? '404' : '500' . getenv('YII_ENV')?>">

<script>var init = [];</script>

<!--<div class="header">-->
<!--    <a href="index.html" class="logo">-->
<!--    -->
<!--        <strong>--><?//=__('NO Found')?><!--</strong>-->
<!--    </a> <!-- / .logo -->
<!--</div> <!-- / .header -->

<div class="not-found-page">
   <div class="box">
       <div class="error-code"><?=$code?></div>
       <span class="title">OOPS! <?= Html::encode($this->title) ?></span>
       <span class="subtitle"> <?= nl2br(Html::encode($message)) ?></span>
   </div>
</div>

<!-- Get jQuery from Google CDN -->
<!--[if !IE]> -->
<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js">'+"<"+"/script>"); </script>
<!-- <![endif]-->
<!--[if lte IE 9]>
<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>
<![endif]-->



</body>
