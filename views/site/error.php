<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $exception \yii\web\HttpException */

$this->title = 'Error';
?>
<div class="site-error">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($exception->getMessage())) ?>
    </div>
    <p>
        Wah, kayaknya ada gangguan masalah pada Web Server nih...
        Mohon tunggu sebentar ya. Terima kasih :::.
    </p>
</div>