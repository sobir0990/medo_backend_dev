<?php

namespace backend\controllers;

use backend\models\QuestionForms;
use common\models\TestAnswer;
use Yii;
use common\models\TestQuestion;
use common\models\TestQuestionSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QuestionController implements the CRUD actions for TestQuestion model.
 */
class QuestionformController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TestQuestion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestQuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new TestQuestion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TestQuestion();

        if ($requestParams = Yii::$app->request->post()) {
            $model = new QuestionForms();
            $model->load($requestParams['TestQuestion'], '');
            $model->answers = $requestParams['Answers'];
            if (!($question = $model->create())) {
                Yii::$app->response->statusCode = 400;
                $model->errors;
            }
            return $this->redirect(['update', 'id' => $question->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TestQuestion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($requestParams = Yii::$app->request->post()) {
            $model = new QuestionForms();
            $model->load($requestParams['TestQuestion'], '');
            $model->id = $id;
            $model->answers = $requestParams['Answers'];
            if (!($question = $model->update())) {
                Yii::$app->response->statusCode = 400;
                $model->errors;
            }
            return $this->redirect(['update', 'id' => $question->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'answers' => $model->answers
        ]);
    }

    /**
     * @param $id
     * @return TestQuestion
     * @throws NotFoundHttpException
     */
    protected function findModel($id): TestQuestion
    {
        if (($model = TestQuestion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('backend', 'The requested page does not exist.'));
    }
}
