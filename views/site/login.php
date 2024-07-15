<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Log in';
$this->params['breadcrumbs'][] = $this->title;

// Path to your logo image in web/assets folder
$logoPath = Yii::getAlias('@web/images/jakpro.png');
$backgroundImagePath = Yii::getAlias('@web/images/lrt.png'); 

// CSS classes for consistent font
$authTitleClass = 'auth-title';
$authTextClass = 'text-dark';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($this->title) ?> - SAW</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <?= Html::cssFile('@web/assets/css/bootstrap.css') ?>
    <?= Html::cssFile('@web/assets/vendors/bootstrap-icons/bootstrap-icons.css') ?>
    <?= Html::cssFile('@web/assets/css/app.css') ?>
    <?= Html::cssFile('@web/assets/css/pages/auth.css') ?>
    <link rel="shortcut icon" href="<?= Yii::getAlias('@web/images/jakpro.png') ?>" type="image/x-icon">

    <style>
        body, h1, .auth-title, .text-white {
            font-family: 'Nunito', sans-serif !important;
        }
        body {
            background-image: url('<?= $backgroundImagePath ?>');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .auth-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px; /* Adjust the gap between the cards */
            height: 100%;
            width: 100%;
        }
        .card {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            margin-bottom: 20px;
        }
        #auth-left {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
            width: 100%;
            height: 100%;
        }
        #auth-left .form-group {
            width: 100%;
        }
        .input-group {
            font-size: 1.2rem; /* Adjust the font size */
        }
        .input-group-text {
            padding: 15px 20px; /* Adjust padding */
        }
        .form-control {
            padding: 15px 20px; /* Adjust padding */
            height: auto; /* Ensure the height is auto */
            font-size: 1.2rem; /* Adjust the font size */
        }
        .btn-lg {
            padding: 20px 30px; /* Adjust padding */
            font-size: 1.4rem; /* Adjust the font size */
        }
        .text-bold {
            font-weight: bold; /* Add this class to make text bold */
            font-size: 1.5rem; /* Adjust the font size */
        }
    </style>
</head>

<body>
    <div id="auth">
        <div class="row h-100 w-100">
            <div class="auth-wrapper">
                <div class="col-lg-5 col-12">
                    <div id="auth-left" class="card">
                        <div class="card-header">
                            <h1 class="<?= $authTitleClass ?>"><?= Html::encode($this->title) ?></h1>
                        </div>
                        <?php $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'layout' => 'horizontal',
                            'fieldConfig' => [
                                'template' => "{label}\n<div class=\"col-lg-12\">{input}{error}</div>",
                                'labelOptions' => ['class' => 'col-lg-3 control-label'],
                            ],
                        ]); ?>

                        <?= $form->field($model, 'username', [
                            'inputTemplate' => '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="bi bi-person"></i></span></div>{input}</div>',
                        ])->textInput(['autofocus' => true, 'placeholder' => 'Username', 'class' => 'form-control'])->label(false) ?>

                        <?= $form->field($model, 'password', [
                            'inputTemplate' => '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="bi bi-shield-lock"></i></span></div>{input}</div>',
                        ])->passwordInput(['placeholder' => 'Password', 'class' => 'form-control'])->label(false) ?>

                        <?= $form->field($model, 'rememberMe')->checkbox([
                            'template' => "<div class=\"col-lg-12\">{input} Simpan info login {label}</div>\n<div class=\"col-lg-12\">{error}</div>",
                        ])->label(false) ?>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block btn-lg shadow-lg mt-5', 'name' => 'login-button']) ?>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>

                        <?php if ($error !== null) : ?>
                            <div class="alert alert-danger">
                                Username atau password salah.
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <div id="auth-right" class="text-center py-5 card">
                        <div class="card-header">
                            <?= Html::img($logoPath, ['class' => 'img-fluid mb-4', 'style' => 'max-width: 250px;', 'alt' => 'Logo']) ?>
                        </div>
                        <div class="card-body">
                            <p class="<?= $authTextClass ?> text-bold">Halo, Selamat datang di sistem penilaian karyawan menggunakan<br>metode Simple Additive Weighting (SAW) studi kasus PT. Jakarta Propertindo.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= Html::jsFile('@web/assets/js/bootstrap.bundle.min.js') ?>
</body>

</html>