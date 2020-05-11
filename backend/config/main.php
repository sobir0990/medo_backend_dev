<?php

use common\modules\langs\components\Lang;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'layout' => 'admin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'controllerMap' => [
        'files' => \jakharbek\filemanager\backend\Module::class,
//		'files' => 'common\filemanager\controllers\FilesController',
        'categories' => 'common\modules\categories\controllers\CategoriesController'
    ],
    'language' => 'uz',
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => \mdm\admin\Module::class,
            'layout' => 'left-menu',
            'mainLayout' => '@backend/views/layouts/admin.php'
        ],
        'translation' => [
            'class' => '\common\modules\translation\modules\admin\Module'
        ],
        'settings' => [
            'class' => '\common\modules\settings\modules\admin\Module',
        ],
        'menu' => [
            'class' => '\common\modules\menu\modules\admin\Module',
        ],
        'category' => [
            'class' => '\common\modules\category\modules\admin\Module',
        ],
        'playmobile' => [
            'class' => 'common\modules\playmobile\Module',
        ],
        'treemanager' => [
            'class' => '\kartik\tree\Module',
            // other module settings, refer detailed documentation
        ]

    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'view' => [
            'class' => 'backend\components\View',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'authManager' => [
            'class' => \yii\rbac\DbManager::class,
            'defaultRoles' => ['admin', 'moder', 'user', 'doctor'],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller>/<action>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<lang\d+>/<id\d+>/<hash\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'as access' => [
            'class' => \mdm\admin\components\AccessControl::class,
            'allowActions' => [
                'site/*',
                'admin/*',
            ]
        ],
        'i18n' => [
            'translations' => [
                'yoshlar-settings' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceMessageTable' => '_system_message',
                    'messageTable' => '_system_message_translation',
                ],
                'jakhar-posts' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceMessageTable' => '_system_message',
                    'messageTable' => '_system_message_translation',
                ],
                'jakhar-menu' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceMessageTable' => '_system_message',
                    'messageTable' => '_system_message_translation',
                ],
            ],
        ],
    ],
    'on beforeAction' => function () {
        Lang::onRequestHandler();
    },
    'as beforeRequest' => [  //if guest user access site so, redirect to login page.
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'controllers' => ['site'],
                'actions' => ['login', 'logout'],
                'roles' => ['?', '@'],
                'allow' => true,
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
    'extensions' => [
        '2amigos/yii2-ckeditor-widget' =>
            array(
                'name' => '2amigos/yii2-ckeditor-widget',
                'version' => '1.0.4.0',
                'alias' =>
                    array(
                        '@dosamigos/ckeditor' => 'common/modules/2amigos/yii2-ckeditor-widget/src',
                    ),
            ),
    ],
    'params' => $params,
];
