<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'language' => 'uz',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        \jakharbek\filemanager\bootstrap\SetUp::class
    ],
    'controllerNamespace' => 'api\controllers',
    'modules' => [
        'treemanager' =>  [
            'class' => '\kartik\tree\Module',
        ],
        'v1' => [
            'class' => 'api\modules\v1\Module',
        ],
		'payment' => [
			'class' => 'rakhmatov\payment\Module'
		]
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => '8wjcm7qBeQBPQCvq_TI_UkWukV4KuZ7U',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
				'multipart/form-data' => 'yii\web\MultipartFormDataParser',
            ]
        ],
        'response' => [
            'formatters' => [
                'json' => [
                    'class' => \yii\web\JsonResponseFormatter::class,
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ]
            ],
            'format' => \yii\web\Response::FORMAT_JSON,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
            'loginUrl' => null,
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
        'urlManager' => [
            'class' => \yii\web\UrlManager::class,
            'showScriptName'	=> false,
            'enablePrettyUrl'	=> true,
            'rules'	=> \api\modules\v1\Module::$urlRules,

        ],
    ],
    'params' => $params,
];
