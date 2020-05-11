<?php

namespace backend\controllers;

use backend\models\ProductListFrom;

use common\models\ModerReason;
use common\models\Product;
use common\models\ProductModer;
use common\models\ProductSearch;
use Yii;
use common\models\CompanyModer;
use yii\base\ErrorException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanyModerController implements the CRUD actions for CompanyModer model.
 */
class ProductModerController extends Controller
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
        $searchModel = new ProductSearch();

        $dataProviderWaiting = $searchModel->search(Yii::$app->request->queryParams);
        $dataProviderWaiting->query->where(['"product".status' => Product::STATUS_WAITING])->orderBy('updated_at DESC');

        $dataProviderActive = $searchModel->search(Yii::$app->request->queryParams);
        $dataProviderActive->query->where(['"product".status' => Product::STATUS_ACTIVE])->orderBy('updated_at DESC');
        $dataProviderActive->query->andWhere(['"product".type' => Product::TYPE_PRODUCT]);

        $dataProviderDeleted = $searchModel->search(Yii::$app->request->queryParams);
        $dataProviderDeleted->query->where(['"product".status' => Product::STATUS_DEACTIVE])->orderBy('updated_at DESC');


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
     * @return Question the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
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

        if (!$model = Product::findOne($id)) return $this->redirect(['/product-moder']);
        $question_moder = ProductModer::find()->where(['product_id' => $model->id])->one();
        $model->status = Product::STATUS_ACTIVE;
        if ($model->save(false)) {
            if ($question_moder) {
                $question_moder->delete();
            }
            Yii::$app->session->setFlash('successMessage', true);
            return $this->redirect(['/product-moder']);
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

        if (!$product) return $this->redirect('/product-moder');

        $model = new ProductListFrom();

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
            $product->status = Product::STATUS_DEACTIVE;

            if (!$product->save(false)) {
                throw new ErrorException('No De active product');
            }

            $Pmoder = new ProductModer();

            $Pmoder->reason_id = $model->reason_id;
            $Pmoder->product_id = $model->product_id;
            $Pmoder->created = time();
            $Pmoder->status = CompanyModer::STATUS_READ;

            if ($Pmoder->validate()) {
                if ($Pmoder->save()) {

                    Yii::$app->session->setFlash('deactiveMessage', true);

                    return $this->redirect('/product-moder');
                }
            }
        }

        return $this->render('deactive', [
            'model' => $model,
            'product' => $product

        ]);
    }


}
