<?php

namespace common\modules\category\modules\admin;
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
    public $controllerNamespace = 'common\modules\category\modules\admin\controllers';
    public $defaultRoute = "category";

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
