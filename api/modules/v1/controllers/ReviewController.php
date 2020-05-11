<?php

namespace api\modules\v1\controllers;

use api\components\ApiController;
use common\models\Resume;
use common\models\User;
use common\models\Profile;
use common\models\Review;
use common\models\ReviewSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\UnauthorizedHttpException;

/**
 * @api {post} /review/create Дабавить отзывы
 * @apiName CreateReview
 * @apiGroup Review
 *
 * @apiParam {Number} rating Бал 1 до 5.
 * @apiParam {String} text  Текст отзыва.
 * @apiParam {Number} product_id  Продукт ID.
 * @apiParam {Number} type  Продукт type PRODUCT = 1, COMPANY = 2;
 *
 * @apiSuccess {Object} model Отзывь
 *
 */

/**
 * @api {delete} /review/delete/:id  Удалит отзывы
 * @apiName DeleteReview
 * @apiGroup Review
 *
 * @apiParam {Number} id  Удалёний ID отзывы
 *
 * @apiSuccess {Number} id Удалёний ID
 *
 */
/**
 * @api {get} /review/my  Мой отзывы
 * @apiName MyReviewList
 * @apiGroup Review
 *
 * @apiSuccess {Object} review Всех Отзывы пользовителя
 *
 */
/**
 * @api {post} /review/update/:id Реактирования отзывы
 * @apiName UpdateReview
 * @apiGroup Review
 *
 * @apiParam {Number} rating Бал 1 до 5.
 * @apiParam {String} text  Текст отзыва.
 * @apiParam {Number} product_id  Продукт ID.
 * @apiParam {Number} type  Продукт type PRODUCT = 1, COMPANY = 2;
 *
 * @apiSuccess {Object} model Отзывь
 */
/**
 * Class ReviewController
 * @package api\modules\v1\controllers
 *
 */
class ReviewController extends ApiController
{
	public $modelClass = Review::class;
	public $searchModelClass = ReviewSearch::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

	public function actionIndex(){
        $requestParams = Yii::$app->request->getQueryParams();
        if ($requestParams == null) {
            $requestParams = Yii::$app->request->getBodyParams();
        }

        $query = Review::find();

        if ($requestParams['filter']['company_id'] !== null) {
            $query->andWhere(['"review".company_id' => $requestParams['filter']['company_id']]);
        }

        if ($requestParams['filter']['status'] !== null) {
            $query->andWhere(['"review".status' => $requestParams['filter']['status']]);
        }

        return new ActiveDataProvider([
            'query' => $query,
        ]);

    }

	public function actionCreate()
	{
		$model = new Review();
		$model->load(\Yii::$app->request->post(), '');
		$user = User::authorize();
		$model->profile_id = $user->profile->id;
		if ($model->save()) {
	     return $model;
		} else {
			\Yii::$app->response->setStatusCode(422);
			return $model->getErrors();
		}
	}

	public function actionDelete($id){
	    $model = Review::findOne($id);
	    $user = User::authorize();
	    if($model->profile_id == $user->profile->id){
	        $model->status = Review::STATUS_DEACTIVE;
	        $model->save();
	        return $id;

        }else{
	        throw new UnauthorizedHttpException('У вас нет право удаления!');
        }
    }

    public function actionUpdate($id){

        $model = Review::find()->where(["id" => $id])->one();
        $user_id = User::authorize();
        if ($user_id->profile->id != $model->profile_id) {
            Yii::$app->response->setStatusCode(401);
            return ['status' => 'error', 'message' => 'You don\'t have permission to change this review'];
        }
        $model->load(Yii::$app->request->post(), '');
        $model->status = Review::STATUS_WAITING;
        $model->profile_id = $user_id->profile->id;
        if ($model->save()) {
            return ['status' => 'success', 'message' => 'Review updated successfully'];
        } else {
            Yii::$app->response->setStatusCode(422);
            return $model->getErrors();
        }
    }

    /**
     * @return array|ActiveDataProvider
     * @throws UnauthorizedHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionMy(){
        $user = User::authorize();
        $query = $user->profile->getReview();
        if($user){
            if($query){
                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'sort' => [
                        'defaultOrder' => [
                            'id' => SORT_DESC,
                        ]
                    ],
                ]);
                return $dataProvider;
            }else{
                return ['vacations'=>'Нет отзывы'];
            }

        }else{
            Yii::$app->response->setStatusCode(422);
            throw  new UnauthorizedHttpException('Вы не авторизование!');
        }

    }


}
