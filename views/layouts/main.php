<?php

use app\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<?php $this->beginPage() ?>
<?= $this->render('head') ?>
<body>
<?php $this->beginBody() ?>

<div id="app">
    <?= $this->render('sidebar') ?>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <?= $this->blocks['pageHeading'] ?? '' ?>
        </div>
        <div class="page-content">
            <?= $content ?>
        </div>
        <?= $this->render('footer') ?>
    </div>
</div>

<?= $this->render('js') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>