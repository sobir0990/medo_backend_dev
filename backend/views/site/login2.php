<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
//$this->params['breadcrumbs'][] = $this->title;
?>
<?/*
<!-- Page background -->
<div id="page-signin-bg">
    <!-- Background overlay -->
    <div class="overlay"></div>
    <!-- Replace this with your bg image -->
    <img src="http://oks.cms.loc/assets/d7b5af35/html/assets/demo/signin-bg-1.jpg" alt="">
</div>
<!-- / Page background -->

<!-- Container -->
<div class="signin-container">


    <div class="signin-form">
*/?>
<body class="theme-default page-signin  windows desktop pace-done"><div class="pace  pace-inactive"><div class="pace-progress" style="transform: translate3d(100%, 0px, 0px);" data-progress-text="100%" data-progress="99">
        <div class="pace-progress-inner"></div>
    </div>
    <div class="pace-activity"></div></div>

<script>var init = [];</script>


<div class="login-wrapper ">
    <!-- START Login Background Pic Wrapper-->
    <div class="bg-pic">
        <img src="/assets/8fe0230f/img/login_bg.jpg" data-src="/assets/8fe0230f/img/login_bg.jpg" alt="" class="lazy">
        <!-- START Background Caption-->
        <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
            <h2 class="semi-bold text-white">
                Pages make it easy to enjoy what matters the most in the life</h2>
            <p class="small">
                All work copyright of respective owner, otherwise © 2018 OKS.
            </p>
        </div>
        <!-- END Background Caption-->
    </div>
    <!-- END Login Background Pic Wrapper-->
    <!-- START Login Right Container-->
    <div class="login-container bg-white">
        <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
            <img src="assets/img/logo.png" alt="logo" data-src="assets/img/logo.png" data-src-retina="assets/img/logo_2x.png" width="78" height="22">
            <p class="p-t-35">Sign into your pages account</p>
            <!-- START Login Form -->
            <form id="form-login" action="/site/login" method="post">
                <input type="hidden" name="_csrf-backend" value="5zXb7Tio5oiUSPZbGEQjTz1A0k53uoC4xmhinhM_0JahBe3VUZ21xKIawWNeaRQ2dDaDfUX30t2RHCX5UFCPrw==">             <!-- START Form Control-->
                <div class="form-group form-group-default">
                    <label>Login</label>
                    <div class="controls">
                        <div class="w-icon form-group field-loginform-username has-success">
                            <input type="text" id="loginform-username" class="form-control" name="LoginForm[username]" value="Xurshid" autofocus="" placeholder="Username" aria-invalid="false"> <p class="help-block help-block-error"></p> <span class="fa fa-user signin-form-icon"></span>
                        </div>                    </div>
                </div>
                <!-- END Form Control-->
                <!-- START Form Control-->
                <div class="form-group form-group-default">
                    <label>Password</label>
                    <div class="controls">
                        <div class="w-icon form-group field-loginform-password required has-error">
                            <input type="password" id="loginform-password" class="form-control" name="LoginForm[password]" value="123456" placeholder="Password" aria-required="true" aria-invalid="true"> <p class="help-block help-block-error">Incorrect username or password.</p> <span class="fa fa-lock signin-form-icon"></span>
                        </div>                    </div>
                </div>
                <!-- START Form Control-->
                <div class="row">
                    <div class="col-md-6 no-padding sm-p-l-10">
                        <div class="checkbox ">
                            <div class="w-icon form-group field-loginform-rememberme">
                                <div class="checkbox">
                                    <label for="loginform-rememberme">
                                        <input type="hidden" name="LoginForm[rememberMe]" value="0"><input type="checkbox" id="loginform-rememberme" name="LoginForm[rememberMe]" value="1" checked="">
                                        Remember Me
                                    </label>
                                    <p class="help-block help-block-error"></p>

                                </div>
                            </div>                        </div>
                    </div>
                </div>
                <!-- END Form Control-->
                <button class="btn btn-primary btn-cons m-t-10" type="submit">Sign in</button>
            </form>            <!--END Login Form-->
            <div class="pull-bottom sm-pull-bottom">
                <div class="m-b-30 p-r-80 sm-m-t-20 sm-p-r-15 sm-p-b-20 clearfix">
                    <div class="col-sm-3 col-md-2 no-padding">
                        <img alt="" class="m-t-5" data-src="assets/img/demo/pages_icon.png" data-src-retina="assets/img/demo/pages_icon_2x.png" src="assets/img/demo/pages_icon.png" width="60" height="60">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Login Right Container-->
</div>

<script type="text/javascript">
    {
        $('#form-login').validate()
    })
</script>

<script src="/assets/5c88e0fd/jquery.js?v=1490036520"></script>
<script src="/assets/21b8a3b2/yii.js?v=1540973623"></script>
<script src="/assets/21b8a3b2/yii.validation.js?v=1540973623"></script>
<script src="/assets/21b8a3b2/yii.activeForm.js?v=1540973623"></script>
<script src="/assets/8fe0230f/assets/plugins/pace/pace.min.js?v=1540972671"></script>
<script src="/assets/8fe0230f/assets/plugins/modernizr.custom.js?v=1540972671"></script>
<script src="/assets/8fe0230f/assets/plugins/jquery-ui/jquery-ui.min.js?v=1540972670"></script>
<script src="/assets/8fe0230f/assets/plugins/tether/js/tether.min.js?v=1540972671"></script>
<script src="/assets/8fe0230f/assets/plugins/bootstrap/js/bootstrap.min.js?v=1540972670"></script>
<script src="/assets/8fe0230f/assets/plugins/jquery/jquery-easy.js?v=1540972671"></script>
<script src="/assets/8fe0230f/assets/plugins/jquery-unveil/jquery.unveil.min.js?v=1540972670"></script>
<script src="/assets/8fe0230f/assets/plugins/jquery-bez/jquery.bez.min.js?v=1540972670"></script>
<script src="/assets/8fe0230f/assets/plugins/jquery-ios-list/jquery.ioslist.min.js?v=1540972670"></script>
<script src="/assets/8fe0230f/assets/plugins/imagesloaded/imagesloaded.pkgd.min.js?v=1540972670"></script>
<script src="/assets/8fe0230f/assets/plugins/jquery-actual/jquery.actual.min.js?v=1540972670"></script>
<script src="/assets/8fe0230f/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js?v=1540972670"></script>
<script src="/assets/8fe0230f/pages/js/pages.min.js?v=1540972671"></script>
<script src="/assets/8fe0230f/assets/js/scripts.js?v=1541226356"></script>
<script>jQuery(function ($) {
        jQuery('#form-login').yiiActiveForm([{"id":"loginform-username","name":"username","container":".field-loginform-username","input":"#loginform-username","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.string(value, messages, {"message":"Значение «Username» должно быть строкой.","skipOnEmpty":1});}},{"id":"loginform-password","name":"password","container":".field-loginform-password","input":"#loginform-password","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, {"message":"Необходимо заполнить «Password»."});}},{"id":"loginform-rememberme","name":"rememberMe","container":".field-loginform-rememberme","input":"#loginform-rememberme","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.boolean(value, messages, {"trueValue":"1","falseValue":"0","message":"Значение «Remember Me» должно быть равно «1» или «0».","skipOnEmpty":1});}}], []);
    });</script>

</body>

        <?php $form = ActiveForm::begin([
            'id' => 'signin-form_id',
            'fieldConfig' => [
                'options' => [
                    'class' => 'w-icon form-group'
                ],

            ],
        ]); ?>
        <div class="signin-text">
            <span>Sign In to your account</span>
        </div> <!-- / .signin-text -->

        <?= $form->field($model, 'username', ['template' => '{input} {error} {hint}<span class="fa fa-user signin-form-icon"></span>'])
            ->textInput([
                'autofocus' => true,
                'class' => 'input-lg form-control',
                'placeholder' => 'Username or email'
            ])->label(false) ?>

        <?= $form->field($model, 'password', ['template' => '{input} {error} {hint}<span class="fa fa-lock signin-form-icon"></span>'])
            ->passwordInput([
                'class' => 'input-lg form-control',
                'placeholder' => 'Password'
            ])->label(false) ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <div class="form-actions">
            <?= Html::submitButton('SIGN IN', ['class' => 'signin-btn btn-primary', 'name' => 'login-button']) ?>

        </div> <!-- / .form-actions -->

        <?php ActiveForm::end(); ?>



        <!-- / Form -->

        <!-- / Password reset form -->
    </div>
    <!-- Right side -->
</div>
<!-- / Container -->

<script type="text/javascript">
    // Resize BG
    init.push(function () {
        var $ph  = $('#page-signin-bg'),
            $img = $ph.find('> img');

        $(window).on('resize', function () {
            $img.attr('style', '');
            if ($img.height() < $ph.height()) {
                $img.css({
                    height: '100%',
                    width: 'auto'
                });
            }
        });
    });

    // Show/Hide password reset form on click
    init.push(function () {
        $('#forgot-password-link').click(function () {
            $('#password-reset-form').fadeIn(400);
            return false;
        });
        $('#password-reset-form .close').click(function () {
            $('#password-reset-form').fadeOut(400);
            return false;
        });
    });

    // Setup Sign In form validation
    init.push(function () {
        $("#signin-form_id").validate({ focusInvalid: true, errorPlacement: function () {} });

        // Validate username
        $("#username_id").rules("add", {
            required: true,
            minlength: 3
        });

        // Validate password
        $("#password_id").rules("add", {
            required: true,
            minlength: 6
        });
    });

    // Setup Password Reset form validation
    init.push(function () {
        $("#password-reset-form_id").validate({ focusInvalid: true, errorPlacement: function () {} });

        // Validate email
        $("#p_email_id").rules("add", {
            required: true,
            email: true
        });
    });

    window.PixelAdmin.start(init);
</script>
