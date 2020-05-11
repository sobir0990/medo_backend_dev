<?php /** @noinspection PhpComposerExtensionStubsInspection */

namespace backend\controllers;

use common\models\Post;
use common\models\PostSearch;
use common\models\Product;
use common\models\ProductSearch;
use common\models\Profile;
use common\models\Review;
use common\models\ReviewSearch;
use common\models\Social;
use common\models\User;
use common\models\VacationSearch;
use Yii;
use common\models\Company;
use common\models\CompanySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends Controller
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

	/**
	 * Lists all Company models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new CompanySearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->orderBy(['id' => SORT_DESC]);
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Company model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Company model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Company();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $message = \Yii::t("main", "Sizning nomingizga kompaniya ochildi".$model->name_ru);
            $profile = Profile::findOne($model->profile_id);
            $user = User::findOne($profile->user_id);
            if (is_object($user)) {
//                \Yii::$app->playmobile->sendSms($user->phone, $message);
            }
			return $this->redirect(['update', 'id' => $model->id]);
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing Company model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
//	public function actionUpdate($id)
//	{
//		$model = $this->findModel($id);
//        //product
//        $productSearch = new ProductSearch();
//        $product = $productSearch->search(Yii::$app->request->queryParams);
//        $product->query->where(['product.company_id'=> $id])->orderBy(['id' => SORT_DESC]);
//        //post
//        $postSearch = new PostSearch();
//        $post = $postSearch->search(Yii::$app->request->queryParams);
//        $post->query->where(['post.company_id'=> $id])->orderBy(['id' => SORT_DESC]);
//        //vacation
//        $vacationSearch = new VacationSearch();
//        $vacation = $vacationSearch->search(Yii::$app->request->queryParams);
//        $vacation->query->where(['vacation.company_id' => $id])->orderBy(['id' => SORT_DESC]);
//        //review
//
//		if ($model->load(Yii::$app->request->post()) && $model->save()) {
//			return $this->redirect(['update', 'id' => $model->id]);
//		}
//
//		return $this->render('update', [
//			'model' => $model,
//            'productSearch' => $productSearch,
//            'product' => $product,
//            'vacation'=> $vacation,
//            'vacationSearch' => $vacationSearch,
//            'post' => $post,
//            'postSearch' => $postSearch,
//		]);
//	}

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

	/**
	 * Deletes an existing Company model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 * @throws \Throwable
	 * @throws \yii\db\StaleObjectException
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	public function actionSocial()
	{
		if (Yii::$app->request->isAjax) {
			$data = Yii::$app->request->post();
			$model = new Social();
			$model->load($data,'');
			if ($model->validate()) {
				$model->save();
				return json_encode(["status" => "ok", "data" => $model->toArray()], JSON_UNESCAPED_SLASHES);
			}
			else return json_encode(["status" => "error", "data" => $model->getErrors()], JSON_UNESCAPED_SLASHES);
		}
		return $this->goHome();
	}

	public function actionDeleteSocial($id)
	{
		if (Yii::$app->request->isAjax) {
			$model = Social::findOne(['id' => $id]);
			$comp = $model->company_id;
			if ($model->delete()) {
				$res = Social::find()->where(['company_id' => $comp])->asArray()->all();
				return json_encode(["status" => "ok", "data" => $res], JSON_UNESCAPED_SLASHES);
			}
			else return json_encode(["status" => "error", "data" => $model->getErrors()], JSON_UNESCAPED_SLASHES);
		}
		return $this->goHome();
	}

	/**
	 * Finds the Company model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Company the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Company::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
