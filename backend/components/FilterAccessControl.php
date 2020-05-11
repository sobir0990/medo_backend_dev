<?php

namespace backend\components;

use Yii;
use common\models\User;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class FilterAccessControl extends ActionFilter
{
    public $user   = 'user';

    public $except = [
    	'site/index',
		'site/profile',
		'login',
		'error',
		'logout',
		'reset'
	];

	public function beforeAction($action)
    {
        if ($user = Yii::$app->controller->_user())
        {
            if ($user->canAccessToResource($this->getFullActionName(), $this->except))
            {
                return parent::beforeAction($action);
            }
        }

        return $this->denyAccess();
    }

    protected function denyAccess()
    {
        if (Yii::$app->user->getIsGuest())
        {
            Yii::$app->user->loginRequired();

        } else {

			//throw new NotFoundHttpException(__('The requested post does not exist.'));
			//Yii::$app->controller->redirect('/');

            throw new ForbiddenHttpException('You are not allowed to perform this action.');

        }

        return false;
    }

    private function getFullActionName()
    {
        return Yii::$app->controller->route;
    }
}