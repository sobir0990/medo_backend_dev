<?php

namespace common\modules\settings\modules\admin;
use common\modules\settings\models\Settings;
use yii\filters\AccessControl;

/**
 * settings module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'common\modules\settings\modules\admin\controllers';

    /**
     * @return array
     */
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Settings::PERMESSION_ACCESS],
                    ],
                ],
            ],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
