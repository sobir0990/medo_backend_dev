<?php
/**
 * Created by PhpStorm.
 * User: xurshid
 * Date: 2/5/19
 * Time: 5:47 PM
 */

/**
 * @api      {get} /product/ Все Обявления
 * @apiName  GetProduct
 * @apiGroup Product
 *
 * @apiSuccess {Object} profile Профиль создатител пость
 * @apiSuccess {Object} company Компания создатител поста эсли эсть
 * @apiSuccess {String} title Названия.
 * @apiSuccess {String} content Текст.
 * @apiSuccess {Number} phone Телефон.
 * @apiSuccess {String} address Адрес.
 * @apiSuccess {Number} type Тип PRODUCT = 0, SERVICE = 1 .
 * @apiSuccess {Number} view  Сколка посматрения.
 * @apiSuccess {Number} view_phone  Сколка посматрения  телефон.
 * @apiSuccess {Number} favorite  Избранное
 * @apiSuccess {Number} price Цена
 * @apiSuccess {Number} price_type Тип Цена  AGREED = 1, ACCURATE = 0;
 * @apiSuccess {Number} status  Статус 1 актив 0 неактив
 * @apiSuccess {Number} top  Для паказать отделний
 * @apiSuccess {Number} created_at  Время создания ответа.
 * @apiSuccess {Number} updated_at  Время  изменения моделя.
 * @apiSuccess {String} files Файл
 * @apiSuccess {String} images Картинки icon - маленкий w = 50, h =50; small - w=320, h=320; low - w= 40, h=640; normal -
 *  w=1024, h=1024
 * @apiSuccess {Array} categories Категория на пости
 *
 */

/**
 * @api      {post} /product/create Создать Обявления
 * @apiName  CreateProduct
 * @apiGroup Product
 *
 * @apiParam {String} title Названия.
 * @apiParam {String} content Текст.
 * @apiParam {Number} phone Телефон.
 * @apiParam {String} address Адрес.
 * @apiParam {Number} type Тип PRODUCT = 0, SERVICE = 1 .
 * @apiParam {Number} view  Сколка посматрения.
 * @apiParam {Number} view_phone  Сколка посматрения  телефон.
 * @apiParam {Number} price Цена
 * @apiParam {Number} price_type Тип Цена  AGREED = 1, ACCURATE = 0;
 * @apiParam {Number} status  Статус 1 актив 0 неактив
 * @apiParam {String} files Файл
 * @apiParam {String} images Картинки icon - маленкий w = 50, h =50; small - w=320, h=320; low - w= 40, h=640; normal -
 *  w=1024, h=1024
 * @apiParam {Array} category_id Категория на пости
 *
 * @apiSuccess {Object} product Обявления
 */

/**
 * @api      {get} /product/delete/:id Удалить Обявления
 * @apiName  DeleteProduct
 * @apiGroup Product
 *
 * @apiParam {Number} id Удалёний  id Обявления
 *
 * @apiSuccess {Number}  ID удалёний Обявления
 *
 */

/**
 * @api      {post} /product/update/:id  Изменения Обявления
 * @apiName  UpdateProduct
 * @apiGroup Product
 *
 * @apiParam {String} title Названия.
 * @apiParam {String} content Текст.
 * @apiParam {Number} phone Телефон.
 * @apiParam {String} address Адрес.
 * @apiParam {Number} type Тип PRODUCT = 0, SERVICE = 1 .
 * @apiParam {Number} view  Сколка посматрения.
 * @apiParam {Number} view_phone  Сколка посматрения  телефон.
 * @apiParam {Number} price Цена
 * @apiParam {Number} price_type Тип Цена  AGREED = 1, ACCURATE = 0;
 * @apiParam {Number} status  Статус 1 актив 0 неактив
 * @apiParam {String} files Файл
 * @apiParam {String} images Картинки icon - маленкий w = 50, h =50; small - w=320, h=320; low - w= 40, h=640; normal -
 *  w=1024, h=1024
 * @apiParam {Array} category_id Категория на пости
 *
 * @apiSuccess {Object} product  Обявления
 */
/**
 * @api      {get} /product/my  Мой Обявления
 * @apiName  MyProductList
 * @apiGroup Product
 *
 * @apiSuccess {Object} product Всех Обявления пользовителя
 *
 */

namespace api\modules\v1\controllers;


use api\components\ApiController;
use api\modules\v1\forms\CreateProductForms;
use api\modules\v1\forms\UpdateProductForms;
use common\models\Chat;
use common\models\Message;
use common\models\Product;
use common\models\ProductCategories;
use common\models\ProductSearch;
use common\models\Profile;
use common\models\User;
use common\modules\category\models\Category;
use common\modules\chat\form\ProductSendMessageForm;
use common\modules\langs\components\Lang;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class ProductController extends ApiController
{

    public $modelClass = Product::class;
    public $searchModelClass = ProductSearch::class;

    public function actions()
    {
        $action = parent::actions();
        unset($action['create']);
        unset($action['view']);
        unset($action['index']);
        return $action;
    }

    public function actionIndex()
    {
        $requestParams = Yii::$app->request->getQueryParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->request->getBodyParams();
        }

        $query = Product::find();

        if ($requestParams['filter']['type'] !== null) {
            $query->andWhere(['product.type' => $requestParams['filter']['type']]);
        }
        if ($requestParams['filter']['profile_id'] !== null) {
            $query->andWhere(['"product".profile_id' => $requestParams['filter']['profile_id']]);
        }
        if ($requestParams['filter']['company_id'] !== null) {
            $query->andWhere(['"product".company_id' => $requestParams['filter']['company_id']]);
        }

        if (($status = Yii::$app->request->getQueryParam('filter')['status']) !== null) {
            $query->andWhere(['"product".status' => $requestParams['filter']['status']]);
        }

        if ($requestParams['filter']['category_id'] !== null) {
            $query->leftJoin('product_categories', '"product".id = "product_categories".product_id');
            $query->andWhere(['product_categories.category_id' => $requestParams['filter']['category_id']]);
        }

        if ($requestParams['filter']['not_id'] !== null) {
            $query->andWhere(['NOT', ['"product".id' => $requestParams['filter']['not_id']]]);
        }

        $query->leftJoin('company', '"product".company_id = "company".id');
        $query->leftJoin('profile', '"product".profile_id = "profile".id');

        if (($region_id = Yii::$app->request->getQueryParam('filter')['region_id']) !== null) {
            $query->andWhere(['company.region_id' => $region_id]);
            if ($query->andWhere(['company.region_id' => $region_id]) == null) {
                $query->andWhere(['profile.region_id' => $region_id]);
            }
        }

        if (($city_id = Yii::$app->request->getQueryParam('filter')['city_id']) !== null) {
            $query->andWhere(['company.city_id' => $city_id]);
            if ($query->andWhere(['company.city_id' => $city_id]) == null) {
                $query->orWhere(['profile.city_id' => $city_id]);
            }
        }

        return new ActiveDataProvider([
            'query' => $query
        ]);

    }


    /**
     * @param $id
     * @return Product|null
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $product = Product::findOne($id);
        if ($product === null) {
            throw new NotFoundHttpException('product not found');
        }

        $user = User::findOne($id);
        if ($user->profile->id !== $product->profile_id) {
            $product->updateCounters(['view' => 1]);
        }

        return $product;
    }

    /**
     * @param $slug
     * @return ActiveDataProvider
     */
//    public function actionCategory($slug)
//    {
//        $query = ProductSearch::find()->category($slug);
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]);
//
//        return $dataProvider;
//    }

    private function actionCategory($id)
    {
        $model = Product::find()
            ->leftJoin('product_categories', '"product".id = "product_categories".product_id')
            ->andWhere(['"product".id' => '"product_categories".category_id'])
            ->all();

        return $dataProvider = new ActiveDataProvider([
            'query' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPhone($id)
    {
        /** @var Product $model */
        $model = $this->findModel($id);
        $model->updateCounters(['view_phone' => 1]);
        return $model->phone;
    }

    public function actionCategories()
    {
        $category = Product::find()->select(['COUNT(product.*)', 'category.id', 'category.name', 'category.slug'])
            ->leftJoin('product_categories', '"product".id = "product_categories".product_id')
            ->leftJoin('category', 'category.id = product_categories.category_id')
            ->groupBy('category.id, product.status')
            ->having(['product.status' => 2])
            ->orderBy('count DESC')
            ->asArray()
            ->all();
        return $category;

    }

    public function actionCategoryList()
    {
        $category = Category::find()->andWhere(['lang' => Lang::getLangId()])
            ->andWhere(['status' => Category::STATUS_ACTIVE, 'type' => 'Products'])
            ->all();
        return $category;

    }

    /**
     * @return array|Product|null
     * @throws UnauthorizedHttpException
     */
    public function actionCreate()
    {
        $model = new CreateProductForms();
        $model->load($this->requestParams(), '');
        return $model->create();
    }

    public function actionUpdate($id)
    {
        $model = new UpdateProductForms(['id' => $id]);
        $model->load($this->requestParams(), '');
        return $model->update();
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws UnauthorizedHttpException
     */
    public function actionDelete($id)
    {
        $model = Product::findOne($id);
        $user = User::authorize();
        if ($model->profile_id == $user->profile->id) {
            $model->status = Product::STATUS_DEACTIVE;
            $model->save();
            return $model;
        } else {
            throw new UnauthorizedHttpException('У вас нет право удаления!');
        }
    }

    /**
     * @return array|ActiveDataProvider
     * @throws NotFoundHttpException
     * @throws UnauthorizedHttpException
     */
    public function actionMy()
    {
        $user = User::authorize();
        $query = $user->profile->getProducts()->orderBy(['id' => SORT_DESC]);
        if ($user) {
            if ($query) {
                return $this->getFilteredData($query, ProductSearch::class);
            }
            return ['product' => 'Нет продукты'];
        }

        Yii::$app->response->setStatusCode(422);
        throw  new UnauthorizedHttpException('Вы не авторизование!');
    }

    /**
     * @param $id
     * @return bool|Message
     */
    public function actionSendMsg($id)
    {
        $model = new ProductSendMessageForm(['id' => $id]);
        $model->load($this->requestParams(), '');
        return $model->create();
    }
}
