<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@jakharbek/filemanager' => '@common/modules/ext/yii2-filemanager/src',
    ],
    'bootstrap' => [
        'log',
        \jakharbek\filemanager\bootstrap\SetUp::class
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'uz',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\DummyCache',
        ],
		'utils' => [
			'class' => 'common\components\Utils'
		],
		'playmobile' => [
			'class' => \common\modules\playmobile\components\Connection::class,
			'username' => getenv('PLAYMOBILE_USERNAME'),
			'password' => getenv('PLAYMOBILE_PASSWORD'),
		],
        'i18n' => [
            'translations' => [
                'main' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'forceTranslation' => true,
                    'enableCaching' => true,
                    'cachingDuration' => 3600,
                    'sourceLanguage' => 'ru-RU',
                    'sourceMessageTable' => '_system_message',
                    'messageTable' => '_system_message_translation',
                    'on missingTranslation' => [
                        'common\components\EventHandlers',
                        'handleMissingTranslation',
                    ],
                ],
                'react' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'forceTranslation' => true,
                    'enableCaching' => true,
                    'cachingDuration' => 3600,
                    'sourceLanguage' => 'ru-RU',
                    'sourceMessageTable' => '_system_message',
                    'messageTable' => '_system_message_translation',
                    'on missingTranslation' => [
                        'common\components\EventHandlers',
                        'handleMissingTranslation',
                    ],
                ],
                'backend' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceMessageTable' => '_system_message',
                    'messageTable' => '_system_message_translation',
                ],
                'oks-categories' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceMessageTable' => '_system_message',
                    'messageTable' => '_system_message_translation',
                ]
            ],
        ],
    ],
];
