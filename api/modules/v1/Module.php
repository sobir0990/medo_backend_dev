<?php

namespace api\modules\v1;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\rest\UrlRule;

/**
 * v1 module definition class
 */
class Module extends \yii\base\Module
{
    public static $urlRules = [
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/menu',
            'extraPatterns' => [
                'OPTIONS <action>' => 'options',
            ],
        ],
        [
            'class' => '\yii\rest\UrlRule',
            'controller' => 'v1/user',
            'extraPatterns' => [
                'OPTIONS <action>' => 'options',
                'GET,HEAD top' => 'top',
                'POST confirm' => 'confirm',

                'GET,HEAD get-me' => 'get-me',
                'OPTIONS get-me' => 'options',

                'POST signup' => 'signup',
                'POST,HEAD logout' => 'logout',

                'POST sign-in-profile' => 'sign-in-profile',
                'OPTIONS sign-in-profile' => 'logout',

                'GET,HEAD,POST <service:(google|facebook)>/signin' => 'signin',
                'OPTIONS <service:(google|facebook)>/signin' => 'options',

                'POST add-favorite' => 'add-favorite',
                'OPTIONS delete-favorite/<entity:\w+>/<id:\d+>' => 'options',
                'DELETE delete-favorite/<entity:\w+>/<id:\d+>' => 'delete-favorite',

                'POST,HEAD confirm' => 'confirm',
                'OPTIONS confirm' => 'options',
                'POST,HEAD restore-password' => 'restore-password',
                'OPTIONS restore-password' => 'options',

                'POST,HEAD resend-sms' => 'resend-sms',

                'POST,HEAD change-phone' => 'change-phone',
                'OPTIONS change-phone' => 'options',
                'POST,HEAD change-password' => 'change-password',
                'OPTIONS change-password' => 'options',
            ],
            'pluralize' => false,
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/post',
            'extraPatterns' => [
                'OPTIONS <action>' => 'options',
                'POST' => 'add',
                'GET,HEAD all-categories' => 'all-categories',

                'GET,HEAD category/<slug:\S+>' => 'category',
                'OPTIONS category/<slug:\S+>' => 'options',
                'GET,HEAD <slug:[a-z0-9_-]+>' => 'view',

                'PUT <slug:[a-z0-9_-]+>' => 'update',
                'OPTIONS <slug:[a-z0-9_-]+>' => 'options',

                'DELETE delete/<id:>' => 'delete-slug',
                'OPTIONS delete/<id:>' => 'options',

                'GET,HEAD related/<slug:[a-z0-9_-]+>' => 'related',
                'OPTIONS related/<slug:[a-z0-9_-]+>' => 'options',

                'GET,HEAD relation/<tags:[a-z0-9_-]+>' => 'relation',
                'OPTIONS relation/<tags:[a-z0-9_-]+>' => 'options',

            ],
            'pluralize' => false,
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/profile',
            'extraPatterns' => [
                'OPTIONS <action>' => 'options',

                'GET,HEAD all-categories' => 'all-categories',
                'PUT,HEAD' => 'update',
                'POST,HEAD change-photo' => 'change-photo',
                'POST,HEAD add-category' => 'add-category',

                'GET,HEAD chats' => 'chats',
                'GET,HEAD chats/<id:\d+>' => 'company-chats',
                'OPTIONS chats/<id:\d+>' => 'options',
                'GET,HEAD messages/<chatId:\d+>' => 'messages',
                'OPTIONS messages/<chatId:\d+>' => 'options',

                'DELETE,HEAD delete-category/<id:[0-9]+>' => 'delete-category',
                'OPTIONS delete-category/<id:[0-9]+>' => 'options',

                'POST,HEAD send-msg/<reciever:[0-9]+>' => 'send-msg',
                'OPTIONS send-msg/<reciever:[0-9]+>' => 'options',
                'POST reply/<chatid:\d+>' => 'reply',
                'OPTIONS  reply/<chatid:\d+>' => 'options',

                'PUT <id:\d+>/user' => 'update-user',
                'OPTIONS <id:\d+>/user' => 'options',
            ],
            'pluralize' => false,
        ],
        [
            'class' => UrlRule::class,
            'controller' => 'v1/company',
            'pluralize' => false,
            'extraPatterns' => [
                'OPTIONS <action>' => 'options',
                'GET,HEAD all-categories' => 'all-categories',
                'POST,HEAD add-company' => 'add-company',

                'POST,HEAD <id:\d+>/message' => 'create-message',
                'GET,HEAD category-list' => 'category-list',

                'OPTIONS update/<id:[0-9]+>' => 'options',
                'POST update/<id:[0-9]+>' => 'update',

                'OPTIONS <id:\d+>/review' => 'options',
                'POST <id:\d+>/review' => 'review',
                'GET <id:\d+>/review' => 'get-reviews',

                'OPTIONS <id:\d+>/page' => 'options',
                'GET,POST <id:\d+>/page' => 'page',
            ],
        ],
        [
            'class' => UrlRule::class,
            'controller' => 'v1/review',
            'pluralize' => false,
            'extraPatterns' => [
                'OPTIONS <action>' => 'options',
                'DELETE,HEAD delete/<id:[0-9]+>' => 'delete',
                'OPTIONS delete/<id:[0-9]+>' => 'options',
                'PUT,HEAD update/<id:[0-9]+>' => 'update',
                'OPTIONS update/<id:[0-9]+>' => 'options',
            ],
        ],
        [
            'class' => UrlRule::class,
            'controller' => 'v1/subscribes',
            'pluralize' => false,
            'extraPatterns' => [
            ],
        ],
        [
            'class' => UrlRule::class,
            'controller' => 'v1/resume',
            'pluralize' => false,
            'extraPatterns' => [
                'OPTIONS <action>' => 'options',
                'PUT update/<id:[0-9]+>' => 'update',

                'DELETE,HEAD delete/<id:[0-9]+>' => 'delete',
                'OPTIONS update/<id:[0-9]+>' => 'options',

                'POST,HEAD create' => 'create',
                'OPTIONS delete/<id:[0-9]+>' => 'options',

                'POST,HEAD file' => 'add-file',
                'OPTIONS create' => 'options',

                'DELETE file/<id:\d+>' => 'del-file',
                'OPTIONS file/<id:\d+>' => 'options',

                'GET,HEAD <id:[0-9]+>/phone' => 'phone',
                'OPTIONS <id:[0-9]+>/phone' => 'options',

                'POST <id:\d+>/send-msg' => 'send-msg',
                'OPTIONS <id:\d+>/send-msg' => 'options',
            ],
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/filemanager',
            'pluralize' => false,
            'extraPatterns' => [
                'POST uploads' => 'uploads',
                'OPTIONS uploads' => 'options',

                'POST file-upload' => 'file-upload',
                'OPTIONS file-upload' => 'options'
            ]
        ],
        [
            'class' => UrlRule::class,
            'controller' => 'v1/vacation',
            'pluralize' => false,
            'extraPatterns' => [
                'OPTIONS <action>' => 'options',
                'POST,HEAD create' => 'create',

                'GET,HEAD profile-list' => 'profile-list',

                'PUT update/<id:>' => 'update',
//                'POST update/<id:[0-9]+>' => 'update',
                'OPTIONS update/<id:>' => 'options',

                'DELETE,HEAD delete/<id:[0-9]+>' => 'delete',
                'OPTIONS delete/<id:[0-9]+>' => 'options',

                'GET,HEAD <id:[0-9]+>/phone' => 'phone',
                'OPTIONS <id:[0-9]+>/phone' => 'options',

                'POST <id:\d+>/send-msg' => 'send-msg',
                'OPTIONS <id:\d+>/send-msg' => 'options',
            ],
        ],

        [
            'class' => UrlRule::class,
            'controller' => 'v1/categories',
            'pluralize' => false,
            'extraPatterns' => [

            ],
        ],
        [
            'class' => UrlRule::class,
            'controller' => 'v1/product',
            'pluralize' => false,
            'extraPatterns' => [
                'OPTIONS <action>' => 'options',
                'PUT update/<id:[0-9]+>' => 'update',
                'OPTIONS update/<id:[0-9]+>' => 'options',

                'DELETE,HEAD delete/<id:[0-9]+>' => 'delete',
                'OPTIONS delete/<id:[0-9]+>' => 'options',
                'POST,HEAD create' => 'create',
                'POST,HEAD file' => 'add-file',
                'DELETE file/<id:\d+>' => 'del-file',
                'OPTIONS file/<id:\d+>' => 'options',
                'GET,HEAD <id:[0-9]+>/phone' => 'phone',
                'OPTIONS <id:[0-9]+>/phone' => 'options',
                'OPTIONS category/<slug:\d+>' => 'options',
                'GET,HEAD category/<slug:\d+>' => 'category',
                'POST <id:\d+>/send-msg' => 'send-msg',
                'OPTIONS <id:\d+>/send-msg' => 'options',
            ],
        ],
        [
            'class' => UrlRule::class,
            'controller' => 'v1/favorite',
            'pluralize' => false,
            'extraPatterns' => [
                'OPTIONS <action>' => 'options',
                'POST,HEAD add-product/<id:[0-9]+>' => 'add-product',
                'OPTIONS add-product/<id:[0-9]+>' => 'options',
                'POST,HEAD add-vacation/<id:[0-9]+>' => 'add-vacation',
                'OPTIONS add-vacation/<id:[0-9]+>' => 'options',
                'OPTIONS delete/<entity:\w+>/<id:\d+>' => 'options',
                'DELETE delete/<entity:\w+>/<id:\d+>' => 'delete',
            ],
        ],

        [
            'class' => UrlRule::class,
            'controller' => 'v1/favorite-question',
            'pluralize' => false,
            'extraPatterns' => [
                'POST,HEAD create' => 'create',
                'OPTIONS create' => 'options',

                'GET,HEAD category/<id:\d+>' => 'category',
                'OPTIONS category/<id:\d+>' => 'options',
            ],
        ],

        [
            'class' => UrlRule::class,
            'controller' => 'v1/banner',
            'pluralize' => false,
            'extraPatterns' => [
                'GET,HEAD <slug:\S+>' => 'by-slug',
                'OPTIONS <slug:\S+>' => 'options',
            ],
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/settings',
            'pluralize' => false,
            'extraPatterns' => array(
                'GET contact' => 'contact',
                'OPTIONS contact' => 'options',

                'GET value' => 'get-value',
                'OPTIONS value' => 'options',
            )
        ],
        [
            'class' => UrlRule::class,
            'controller' => 'v1/encyclopedia',
            'pluralize' => false,
            'extraPatterns' => [
                'OPTIONS <action>' => 'options',
                'GET,HEAD' => 'index',
                'POST' => 'add',
                'GET,HEAD categories' => 'categories',
                'GET,HEAD category/<id:\d+>' => 'category',
                'GET,HEAD category-list' => 'category-list',
                'GET,HEAD <letter:\w>' => 'letter',
                'OPTIONS <letter:\w>' => 'options',
                'GET,HEAD test/<slug:\S+>' => 'test',
                'GET <letter:\w>/<slug:\S+>' => 'view',
                'OPTIONS <letter:\w>/<slug:\S+>' => 'options',
            ],
        ],
        [
            'class' => '\yii\rest\UrlRule',
            'controller' => 'v1/default',
            'extraPatterns' => [
                'GET index' => 'index',

                'OPTIONS <action>' => 'options',
                'GET,HEAD search' => 'search',
                'GET,HEAD regions' => 'regions',
                'GET,HEAD cities' => 'cities',

                'GET,HEAD translations/<lang:\w+>/<category:\w+>' => 'translations',
                'POST translations/<lang:\w+>/<category:\w+>' => 'add-translation',
                'OPTIONS translations/<lang:\w+>/<category:\w+>' => 'options',
            ],
        ],
        array(
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/main',
            'pluralize' => false,
            'extraPatterns' => array(
                'GET index' => 'index',

                'GET,HEAD translations/<lang:\w+>/<category:\w+>' => 'translations',
                'POST translations/<lang:\w+>/<category:\w+>' => 'add-translation',
                'OPTIONS translations/<lang:\w+>/<category:\w+>' => 'options',

                'POST files' => 'file-upload',
                'OPTIONS files' => 'options',

                'GET,HEAD list/<category:\w+>' => 'get-translations',
                'POST list/<category:\w+>' => 'message-translate',
                'OPTIONS list/<category:\w+>' => 'options',
            ),
        ),
        [
            'class' => '\yii\rest\UrlRule',
            'controller' => 'v1/search',
            'pluralize' => false,
            'extraPatterns' => [
                'OPTIONS <action>' => 'options',
                'GET,HEAD' => 'index',
                'GET,HEAD resume' => 'resume',
                'GET,HEAD vacation' => 'vacation',
                'GET,HEAD company' => 'company',
                'GET,HEAD product' => 'product',
            ],
        ],
    ];
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'api\modules\v1\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        error_reporting(2215);
        parent::init();

        // custom initialization code goes here
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => static::allowedDomains(),
                    'Access-Control-Request-Method' => ['*'],
                    'Access-Control-Max-Age' => 3600,
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Expose-Headers' => ['*']
                ],
            ],
            'authenticator' => [
                'class' => CompositeAuth::class,
                'except' => [
                    'search/*',
                    'product/index',
                    'post/*',
                    'settings/*',
                    'banner/index',
                    'banner/*',
                    'categories/*',
                    'resume/index*',
                    'company/index',
                    'product/index',
                    'encyclopedia/index',
                    'vacation/index',
                    'review/index',
                    'user/index',
                    'user/view',
                    'resume/view*',
                    'product/view',
                    'vacation/view',
                    'vacation/place-list',
                    'vacation/category-list',
                    'vacation/profile-list',
                    'resume/category-list',
                    'encyclopedia/category-list',
                    'product/category-list',
                    'company/category-list',
                    'company/*',
                    'menu/*',
                    'product/categories',
                    'default/translations',
                    'defaults/translations/<lang:\w+>/<category:\w+>',
                    'default/regions',
                    'default/cities',
                    'product/phone',
                    'defaults/add-translation',
                    'comment/get-comments',
                    '*/options',
                    'menu/second',
                    'menu/menu-footer',
                    'user/signin',
                    'user/sign-in-profile',
                    'user/signup',
                    'user/restore-password',
                    'user/blogs',
                    'user/questions',
                    'user/reviews',
                    'user/answers',
                    'user/top',
                    'user/confirm',
                    'user/logout',
                    'main/*',
                    'user/resend-sms',
                    'favorite-question/*'
                ],
                'authMethods' => [
                    HttpBearerAuth::class,
                ],
            ],
        ]);
    }

    public static function allowedDomains()
    {
        return [
            '*',
        ];
    }
}
