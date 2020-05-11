<?php

namespace common\modules\menu\modules\admin;
use common\modules\menu\models\Menu;
use yii\filters\AccessControl;

/**
 * menu module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'common\modules\menu\modules\admin\controllers';
    public $defaultRoute = "menu";

    /**
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Menu::PERMESSION_ACCESS],
                    ],
                ],
            ],
        ];
    }
    **/

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
