<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
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
        'https://cdn.jsdelivr.net/npm/chart.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}