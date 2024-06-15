<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
?>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($this->title) ?></title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= Url::to('@web/assets/css/bootstrap.css') ?>">

    <link rel="stylesheet" href="<?= Url::to('@web/assets/vendors/iconly/bold.css') ?>">

    <link rel="stylesheet" href="<?= Url::to('@web/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') ?>">
    <link rel="stylesheet" href="<?= Url::to('@web/assets/vendors/bootstrap-icons/bootstrap-icons.css') ?>">
    <link rel="stylesheet" href="<?= Url::to('@web/assets/css/app.css') ?>">
    <link rel="shortcut icon" href="<?= Url::to('@web/assets/images/favicon.png') ?>" type="image/x-icon">
    <?php $this->head() ?>
</head>