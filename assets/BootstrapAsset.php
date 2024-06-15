<?php

namespace app\assets;

use yii\web\AssetBundle;

class BootstrapAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.css', // Path ke file Bootstrap 5 CSS Anda
    ];
    public $js = [
        // 'js/bootstrap.bundle.min.js', // Uncomment jika Anda juga memiliki file JS Bootstrap 5
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}