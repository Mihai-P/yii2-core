<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'core' => [
            'class' => 'core\Module',
            'attemptsBeforeCaptcha' => 3, // Optional
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'core\components\User',
            'enableAutoLogin' => true,
        ],
        'authManager' => [
            'class' => 'core\components\DbManager'
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@core/views/layouts' => '@core/views/layouts',
                    '@core/views' => ['@app/views', '@core/views'],                    
                ],
                'baseUrl' => '@web/',
            ],
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'controllerMap' => [
        'site' => [
            'class' => 'core\controllers\SiteController',
        ],
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@'],
            'disabledCommands' => ['netmount'],
            'roots' => [
                [
                    'class' => 'core\components\StoragePath',
                    'path' => '../../storage',
                    'url' => '/storage',
                    'name'  => 'Public'
                ],
            ]
        ]        
    ],
    'params' => $params,
];
