<?php


namespace backend\controllers;

use common\models\TestAnswer;
use common\models\TestAnswerSearch;
use common\modules\langs\components\Lang;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class AnswerController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new TestAnswerSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['lang' => Lang::getLangId()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCorrect($id)
    {
        $answer = TestAnswer::findOne($id);
        if ($answer->correct == 0) {
            $answer->updateAttributes(['correct' => 1]);
        } elseif ($answer->correct == 1) {
            $answer->updateAttributes(['correct' => 0]);

        }

        return $this->redirect(['answer/index']);
    }

    public function actionCreate()
    {
        $model = new TestAnswer();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return TestAnswer|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = TestAnswer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
