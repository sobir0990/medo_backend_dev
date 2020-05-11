<?php
/**
 * @author: jamwid07
 * Date: 28/05/19
 */

namespace api\modules\v1\controllers;


use api\components\ApiController;
use common\models\Product;
use common\models\Profile;
use common\models\TestAnswer;
use common\models\TestQuestion;
use yii\web\NotFoundHttpException;

class TestController extends ApiController
{
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex($type)
    {
        $models = TestQuestion::find()
            ->joinWith('categories')
            ->where(['categories.id' => $type])
            ->orderBy('random()')
            ->limit(5)->all();
        return $models;
    }

    public function actionAnswer()
    {
        $data = \Yii::$app->request->post();
            if (empty($data['question_id']))
                return false;
            $q = TestQuestion::findOne($data['question_id']);
            if (!$q) {
                throw new NotFoundHttpException('Question not found');
            }
            if (empty($data['answer_id']))
                return false;
            $a = TestAnswer::findOne($data['answer_id']);
            if (!$a) {
                throw new NotFoundHttpException('Answer not found');
            }
            if (!$a->correct) {
                return false;
            }
        return true;
    }
}