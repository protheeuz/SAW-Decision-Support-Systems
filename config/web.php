<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'Duotk-8qdyIXWG4o4RLb1QNWu3JIsyC6',
            'csrfParam' => '_csrf-backend',
            'csrfCookie' => [
                'httpOnly' => true,
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => \app\models\User::class,
            'enableAutoLogin' => true,
            'loginUrl' => ['site/login'], // Atur halaman login di sini
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'alternative' => 'alternative/index',
                'alternative/create' => 'alternative/create',
                'alternative/update/<id:\d+>' => 'alternative/update',
                'alternative/delete/<id:\d+>' => 'alternative/delete',
                'criteria' => 'criteria/index',
                'criteria/create' => 'criteria/create',
                'criteria/update/<id:\d+>' => 'criteria/update',
                'criteria/delete/<id:\d+>' => 'criteria/delete',
                'evaluation/delete/<id:\d+>' => 'evaluation/delete',
                'matrix' => 'matrix/index',
                'matrix/save' => 'matrix/save',
                'preference' => 'preference/index',
                'sub-criteria' => 'sub-criteria/index',
                'sub-criteria/create' => 'sub-criteria/create',
                'sub-criteria/update/<id:\d+>' => 'sub-criteria/update',
                'sub-criteria/delete/<id:\d+>' => 'sub-criteria/delete',
            ],
        ],
        'as access' => [
            'class' => 'yii\filters\AccessControl',
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['delete'],
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        return Yii::$app->user->identity->role == 'HR Manager';
                    }
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
