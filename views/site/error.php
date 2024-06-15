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
        The above error occurred while the Web server was processing your request.
        Please contact us if you think this is a server error. Thank you.
    </p>
</div>