<?php

namespace common\modules\settings\modules\admin\controllers;


use common\modules\pages\models\Pages;
use common\modules\settings\models\Settings;
use common\modules\post\models\Post as Posts;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `settings` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        Settings::saveLisiner();
        return $this->render('index');
    }
}
