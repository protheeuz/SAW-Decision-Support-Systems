<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot/assets';
    public $baseUrl = '@web/assets';
    public $css = [
        'css/bootstrap.css',
        'vendors/iconly/bold.css',
        'vendors/perfect-scrollbar/perfect-scrollbar.css',
        'vendors/bootstrap-icons/bootstrap-icons.css',
        'css/app.css',
    ];
    public $js = [
        'vendors/perfect-scrollbar/perfect-scrollbar.min.js',
        'js/bootstrap.bundle.min.js',
        'vendors/apexcharts/apexcharts.js',
        'js/pages/dashboard.js',
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}