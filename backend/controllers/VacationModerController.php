<?php

namespace backend\controllers;

use backend\models\VacationListFrom;
use common\models\VacationModer;
use Yii;
use common\models\ModerReason;
use common\models\Vacation;
use common\models\VacationSearch;
use yii\base\ErrorException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanyModerController implements the CRUD actions for CompanyModer model.
 */
class VacationModerController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        Yii::$app->session->set('tab', 0);
        $searchModel = new VacationSearch();

        $dataProviderWaiting = $searchModel->search(Yii::$app->request->queryParams);
        $dataProviderWaiting->query->where(['vacation.status' => Vacation::STATUS_WAITING])->orderBy('updated_at DESC');

        $dataProviderActive = $searchModel->search(Yii::$app->request->queryParams);
        $dataProviderActive->query->where(['vacation.status' => Vacation::STATUS_ACTIVE])->orderBy('updated_at DESC');

        $dataProviderDeleted = $searchModel->search(Yii::$app->request->queryParams);
        $dataProviderDeleted->query->where(['vacation.status' => Vacation::STATUS_DEACTIVE])->orderBy('updated_at DESC');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProviderWaiting' => $dataProviderWaiting,
            'dataProviderActive' => $dataProviderActive,
            'dataProviderDeleted' => $dataProviderDeleted

        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws ErrorException
     */
    public function actionActive($id)
    {
        $model = Vacation::findOne($id);
        if (!($model instanceof Vacation)) {
            Yii::$app->session->setFlash('deactiveMessage', true);
            return $this->redirect(['/vacation-moder']);
        }
        $categories = $model->getCategories()->all();
        $cats = null;
        if (count($categories) > 0) {
            foreach ($categories as $category) {
                $cats .= $category->id . ',';
            }
        }
        if ($model->updateAttributes(['status' => Vacation::STATUS_ACTIVE, 'category_id' => $cats])) {
            VacationModer::deleteAll(['vacation_id' => $model->id]);
            Yii::$app->session->setFlash('successMessage', true);
            return $this->redirect(['/resume-moder']);
        }
        throw new ErrorException('Not save Active');
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws ErrorException
     * @throws NotFoundHttpException
     */
    public function actionDeactive($id)
    {

        $product = $this->findModel($id);

        if (!$product) return $this->redirect('/vacation-moder');

        $model = new VacationListFrom();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->message || $model->title) {

                $moder_reason = new ModerReason();
                $moder_reason->title = $model->title;
                $moder_reason->message = $model->message;
                $moder_reason->created = time();
                if ($moder_reason->save()) {

                    $model->reason_id = $moder_reason->id;
                }
            }
            $product->status = Vacation::STATUS_DEACTIVE;

            if (!$product->save(false)) {
                throw new ErrorException('No De active product');
            }

            $Pmoder = new VacationModer();

            $Pmoder->reason_id = $model->reason_id;
            $Pmoder->vacation_id = $model->vacation_id;
            $Pmoder->created = time();
            $Pmoder->status = VacationListFrom::STATUS_READ;

            if ($Pmoder->validate()) {
                if ($Pmoder->save()) {

                    Yii::$app->session->setFlash('deactiveMessage', true);

                    return $this->redirect('/vacation-moder');

                }

            } else {
                throw new ErrorException('No');
            }

        }

        return $this->render('deactive', [
            'model' => $model,
            'product' => $product

        ]);
    }

    /**
     * Finds the Question model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Vacation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vacation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('backend', 'The requested page does not exist.'));
    }


}
