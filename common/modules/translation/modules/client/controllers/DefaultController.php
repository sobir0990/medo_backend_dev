<?php

namespace common\modules\translations\modules\client\controllers;

use yii\web\Controller;

/**
 * Default controller for the `translations` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
