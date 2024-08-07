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
$authTextClass = 'text-white';
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
            position: relative;
        }
        .logo {
            position: absolute;
            top: 15px;
            left: 120px;
            height: 120px;
        }
        .auth-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
        }
        .card {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%; /* Ensure the card takes full width */
            max-width: 500px; /* Set a maximum width */
            margin: auto; /* Center the card */
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
        }
        #auth-left .form-group {
            width: 100%;
        }
        .input-group {
            font-size: 1.2rem;
        }
        .input-group-text {
            padding: 15px 20px;
        }
        .form-control {
            padding: 15px 20px;
            height: auto;
            font-size: 1.2rem;
        }
        .btn-lg {
            padding: 20px 30px;
            font-size: 1.4rem;
        }
        .text-bold {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .welcome-text {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }
    </style>
</head>

<body>
    <?= Html::img($logoPath, ['class' => 'logo', 'alt' => 'Logo']) ?> <!-- Logo added here -->
    <div id="auth">
        <div class="auth-wrapper">
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
    </div>
    <div class="welcome-text">
        <p class="<?= $authTextClass ?> text-bold">Halo, Selamat datang di sistem penilaian karyawan menggunakan<br>metode Simple Additive Weighting (SAW) studi kasus PT. Jakarta Propertindo.</p>
    </div>

    <?= Html::jsFile('@web/assets/js/bootstrap.bundle.min.js') ?>
</body>

</html>