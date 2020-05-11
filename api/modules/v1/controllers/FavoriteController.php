<?php
/**
 * Created by PhpStorm.
 * User: xurshid
 * Date: 2/7/19
 * Time: 3:39 PM
 */

/**
 * @api {get} /product/ Избраний продукт
 * @apiName GetProductFavoriteList
 * @apiGroup Favorite
 *
 * @apiSuccess {Object} Product
 *
 */
/**
 * @api {get} /product/add-product/:id  Дабавить продукт Избраний
 * @apiName AddProductFavorite
 * @apiGroup Favorite
 *
 * @apiParam {Number} id ID Product
 *
 * @apiSuccess {Number} product_id Product ID
 * @apiSuccess {Number} profile_id Profile ID
 * @apiSuccess {Number} created_at Создания время
 * @apiSuccess {Number} updated_at Изменения время
 *
 */
/**
 * @api {delete} /delete-product/:id  Удалить продукт Избраний
 * @apiName DeleteProductFavorite
 * @apiGroup Favorite
 *
 * @apiParam {Number} id ID продукт
 *
 * @apiSuccess {Number} id продукт ID
 *
 */
/**
 * @api {get} /vacation/ Избраний вакансия
 * @apiName GetVacationFavoriteList
 * @apiGroup Favorite
 *
 * @apiSuccess {Object} Vacation
 *
 */

/**
 * @api {get} /product/add-vacation/:id  Дабавить вакансия Избраний
 * @apiName AddVacationFavorite
 * @apiGroup Favorite
 *
 * @apiParam {Number} id ID вакансия
 *
 * @apiSuccess {Number} vacation_id Вакансия ID
 * @apiSuccess {Number} profile_id Profile ID
 * @apiSuccess {Number} created_at Создания время
 * @apiSuccess {Number} updated_at Изменения время
 *
 */


/**
 * @api {delete} /delete-vacation/:id  Удалить вакансия Избраний
 * @apiName DeleteVacationFavorite
 * @apiGroup Favorite
 *
 * @apiParam {Number} id ID вакансия
 *
 * @apiSuccess {Number} id Вакансия ID
 *
 */


namespace api\modules\v1\controllers;

use api\components\ApiController;
use common\models\FavoriteProduct;
use common\models\FavoriteVacations;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\QueryExpressionBuilder;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
use yii\web\UnprocessableEntityHttpException;

class FavoriteController extends ApiController
{

    public $modelClass = FavoriteProduct::class;

    public function actions()
    {
        $action = parent::actions();

        unset($action['view']);
        return $action;
    }

    public function actionProduct()
    {
        $user = User::authorize();
        $query = $user->profile->getFavoriteProduct();

        if ($user) {
            if ($query) {
                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'sort' => [
                        'defaultOrder' => [
                            'id' => SORT_DESC,
                        ]
                    ],
                ]);
                return $dataProvider;
            } else {
                return ['favorite' => 'Нет Product favorite'];
            }

        } else {
            throw  new UnauthorizedHttpException('Вы не авторизование!');
        }
    }

    public function actionVacation()
    {
        $user = User::authorize();
        $query = $user->profile->getFavoriteVacation();
        if ($user) {
            if ($query) {
                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'sort' => [
                        'defaultOrder' => [
                            'id' => SORT_DESC,
                        ]
                    ],
                ]);
                return $dataProvider;
            } else {
                return ['favorite' => 'Нет Vacation favorite'];
            }

        } else {
            throw  new UnauthorizedHttpException('Вы не авторизование!');
        }
    }


    public function actionAddProduct($id)
    {
        $user = User::authorize();
        if ($user) {
            $model = new FavoriteProduct();
            $model->product_id = $id;
            $model->profile_id = $user->profile->id;
            if ($model->save()) {
                return $model;
            }  else {
                Yii::$app->response->setStatusCode(422);
                return $model->getErrors();
            }
        } else {
            throw  new UnauthorizedHttpException('Вы не авторизование!');
        }
    }


    public function actionAddVacation($id)
    {
        $user = User::authorize();
        if ($user) {
            $model = new FavoriteVacations();
            $model->profile_id = $user->profile->id;
            $model->vacation_id = $id;
            if ($model->save()) {
                return $model;
            }  else {
                Yii::$app->response->setStatusCode(422);
                return $model->getErrors();
            }
        } else {
            throw  new UnauthorizedHttpException('Вы не авторизование!');
        }
    }


    public function actionDelete($entity, $id)
    {
        $user = User::authorize();
        if (!$user)
        throw new UnauthorizedHttpException('Вы не авторизованы');

        if (is_numeric($id)) {
            if ($entity == 'product') {
                $model = FavoriteProduct::find()->where(['product_id' => $id, 'profile_id' => $user->profile->id])->one();
                if ($model) {
                    $model->delete();
                    return $model;
                } else throw new NotFoundHttpException();
            }

            if ($entity == 'vacation') {
                $model = FavoriteVacations::find()->where(['vacation_id' => $id, 'profile_id' => $user->profile->id])->one();
                if ($model) {
                    $model->delete();
                    return $model;
                } else throw new NotFoundHttpException();
            }
        } else throw new UnprocessableEntityHttpException('Wrong params');

        throw new NotFoundHttpException();
    }

}
