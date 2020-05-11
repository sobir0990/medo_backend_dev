<?php

namespace backend\controllers;

use backend\models\ResumeListFrom;
use backend\models\ReviewListFrom;
use backend\models\VacationListFrom;
use common\models\Resume;
use common\models\ResumeModer;
use common\models\ResumeSearch;
use common\models\Review;
use common\models\ReviewModer;
use common\models\ReviewSearch;
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
class ReviewModerController extends Controller
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

        $searchModel = new ReviewSearch();


        $dataProviderWaiting = $searchModel->search(Yii::$app->request->queryParams);
        $dataProviderWaiting->query->where(['review.status' => Review::STATUS_WAITING])->orderBy('updated_at DESC');

        $dataProviderActive = $searchModel->search(Yii::$app->request->queryParams);
        $dataProviderActive->query->where(['review.status' => Review::STATUS_ACTIVE])->orderBy('updated_at DESC');

        $dataProviderDeleted = $searchModel->search(Yii::$app->request->queryParams);
        $dataProviderDeleted->query->where(['review.status' => Review::STATUS_DEACTIVE])->orderBy('updated_at DESC');


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProviderWaiting' => $dataProviderWaiting,
            'dataProviderActive' => $dataProviderActive,
            'dataProviderDeleted' => $dataProviderDeleted

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
        if (($model = Review::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('backend', 'The requested page does not exist.'));
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws ErrorException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionActive($id)
    {

        if (!$model = Review::findOne($id)) return $this->redirect(['/review-moder']);
        $question_moder = ReviewModer::find()->where(['review_id' => $model->id])->one();
        $model->status = Review::STATUS_ACTIVE;
        if ($model->save(false)) {
            if ($question_moder) {
                $question_moder->delete();
            }
            Yii::$app->session->setFlash('successMessage', true);
            return $this->redirect(['/review-moder']);
        } else {
            throw new ErrorException('Not save Active');
        }

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

        if (!$product) return $this->redirect('/review-moder');

        $model = new ReviewListFrom();

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
            $product->status = Review::STATUS_DEACTIVE;

            if (!$product->save(false)) {
                throw new ErrorException('No De active product');
            }

            $Pmoder = new ReviewModer();
            $Pmoder->reason_id = $model->reason_id;
            $Pmoder->review_id = $model->review_id;
            $Pmoder->created = time();
            $Pmoder->status = VacationListFrom::STATUS_READ;
            if ($Pmoder->validate()) {
                if ($Pmoder->save()) {
                    Yii::$app->session->setFlash('deactiveMessage', true);
                    return $this->redirect('/review-moder');
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


}
