<?php

namespace api\modules\v1\controllers;

use api\components\ApiController;
use api\modules\v1\forms\CreateCompanyForms;
use api\modules\v1\forms\UpdateCompanyForms;
use common\filemanager\models\Files;
use common\models\Chat;
use common\models\Company;
use common\models\CompanyCategories;
use common\models\CompanyReviews;
use common\models\CompanySearch;
use common\models\Message;
use common\models\Review;
use common\models\ReviewSearch;
use common\models\User;
use common\components\Categories;
use common\modules\category\models\Category;
use common\modules\chat\ChatRepository;
use common\modules\chat\form\CreateMessageForm;
use common\modules\langs\components\Lang;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
use yii\web\UnprocessableEntityHttpException;
use yii\web\UploadedFile;

/**
 * @api      {get} /company Компания лист
 * @apiName  GetCompanyList
 * @apiGroup Company
 *
 * @apiSuccess {String} name Названия компания
 * @apiSuccess {Number} profile_id Профил компания
 * @apiSuccess {Number} type Тип компания 1 - Прозводитель, 2 - Поставщик, 3 - Мед учреждение, 4 - Мед училище
 * @apiSuccess {String} image Картинки icon - маленкий w = 50, h =50; small - w=320, h=320; low - w= 40, h=640; normal, null - Нет картинку
 * @apiSuccess {Number} status Статус 0-DEACTIVE, 1-WAITING, 3-ACTIVE
 * @apiSuccess {Number} description Текст о компанию
 * @apiSuccess {Number} phone Телефон
 * @apiSuccess {address} address Адрес
 * @apiSuccess {Number} created_at Время создания
 * @apiSuccess {Number} updated_at Время изменения
 */

/**
 * @api      {get} /company/:id Запрос один компания
 * @apiName  GetCompany
 * @apiGroup Company
 *
 * @apiParam {Number} id Компания ID
 *
 * @apiSuccess {String} name Названия компания
 * @apiSuccess {Number} profile_id Профил компания
 * @apiSuccess {Number} type Тип компания 1 - Прозводитель, 2 - Поставщик, 3 - Мед учреждение, 4 - Мед училище
 * @apiSuccess {String} image Картинки icon - маленкий w = 50, h =50; small - w=320, h=320; low - w= 40, h=640; normal, null - Нет картинку
 * @apiSuccess {Number} status Статус 0-DEACTIVE, 1-WAITING, 3-ACTIVE
 * @apiSuccess {String} description Текст о компанию
 * @apiSuccess {Number} phone Телефон
 * @apiSuccess {String} address Адрес
 * @apiSuccess {Number} created_at Время создания
 * @apiSuccess {Number} updated_at Время изменения
 *
 */

/**
 * @api      {get} /company/delete-category/:id Удаления Категория
 * @apiName  DeleteСategory
 * @apiGroup Company
 *
 * @apiParam {Number} id Категория ID
 *
 * @apiSuccess {Number} id Удалёний Категория ID
 *
 */


/**
 * @api      {post} /company/add-company Дабавления компания
 * @apiName  AddCompany
 * @apiGroup Company
 *
 * @apiSuccess {String} name  Названия компания
 * @apiSuccess {String} description Текст о компанию
 * @apiSuccess {Number} phone Телефон
 * @apiSuccess {String} address Адрес
 * @apiSuccess {Number} type Тип компания 1 - Прозводитель, 2 - Поставщик, 3 - Мед учреждение, 4 - Мед училище
 * @apiSuccess {String} files[] Картинка
 * @apiSuccess {Array} category_id[] Дабавления Категория ID
 *
 */
/**
 * @api      {post} /company/update/:id Изменения компания
 * @apiName  UpdateCompany
 * @apiGroup Company
 *
 * @apiParam {Number} id Компания ID
 *
 * @apiSuccess {String} name  Названия компания
 * @apiSuccess {String} description Текст о компанию
 * @apiSuccess {Number} phone Телефон
 * @apiSuccess {String} address Адрес
 * @apiSuccess {Number} type Тип компания 1 - Прозводитель, 2 - Поставщик, 3 - Мед учреждение, 4 - Мед училище
 * @apiSuccess {String} files[] Картинка
 * @apiSuccess {Array} category_id[] Дабавления Категория ID
 *
 */
/**
 * @api      {get} /company?include=profile Запрось Профиль
 * @apiName  GetProfile
 * @apiGroup Company
 *
 * @apiParam {String} profile Профиль
 *
 * @apiSuccess {Object} profile Список Ползоватиле
 *
 */

/**
 * @api      {get} /company?include=vacations Запрось Вакансии
 * @apiName  GetVacations
 * @apiGroup Company
 *
 * @apiParam {String} vacations Вакансии
 *
 * @apiSuccess {Object} vacations Список Вакансии
 *
 */

/**
 * @api      {get} /company?include=products Запрось Продукты
 * @apiName  GetProducts
 * @apiGroup Company
 *
 * @apiParam {String} products Продукты
 *
 * @apiSuccess {Object} products Список Продукты
 *
 */

/**
 * @api      {get} /company?include=posts Запрось Посты
 * @apiName  GetPosts
 * @apiGroup Company
 *
 * @apiParam {String} posts Посты
 *
 * @apiSuccess {Object} posts Список Посты
 *
 */
/**
 * @api      {get} /company?include=categories Запрось Категори компания
 * @apiName  GetСategories
 * @apiGroup Company
 *
 * @apiParam {String} categories Категори компания
 *
 * @apiSuccess {Object} categories  Список категории
 *
 */

/**
 * @api      {get} /company?include=socials Запрос Социалний сеть компании
 * @apiName  GetSocials
 * @apiGroup Company
 *
 * @apiParam {String} socials Список Социалний сеть
 *
 * @apiSuccess {String} name Названия Социалний сеть
 * @apiSuccess {String} link Url Социалний сеть компании
 * @apiSuccess {Object} socials Список категории
 * @apiSuccess {Number} company_id ID  компания
 *
 */

/**
 * @api      {get} /company/my  Мой Kомпания
 * @apiName  MyCompanyList
 * @apiGroup Company
 *
 * @apiSuccess {Object} company Всех компания пользовителя
 *
 */
class CompanyController extends ApiController
{
    public $modelClass = Company::class;
    public $searchModelClass = CompanySearch::class;

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['dataFilter']['attributeMap'] = [
            'name' => 'company.name',
        ];
        unset($actions['index']);
        return $actions;
    }

    /**
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $requestParams = Yii::$app->request->getQueryParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->request->getBodyParams();
        }

        $query = Company::find();

        if ($type = $requestParams['filter']['type']) {
            $query->andWhere(['type' => $type]);
        }
        if (($category_id = Yii::$app->request->getQueryParam('filter')['category_id']) !== null) {
//            $query->leftJoin('company_categories', '"company".id = "company_categories".company_id');
            $query->andWhere(['"company_categories".category_id' => $category_id]);
        }

        if (($region_id = Yii::$app->request->getQueryParam('filter')['region_id']) !== null) {
            $query->andWhere(['"company".region_id' => $region_id]);
        }

        if (($status = Yii::$app->request->getQueryParam('filter')['status']) !== null) {
            $query->andWhere(['"company".status' => $status]);
        }

        if (($city_id = Yii::$app->request->getQueryParam('filter')['city_id']) !== null) {
            $query->andWhere(['"company".city_id' => $city_id]);
        }

        if ($requestParams['filter']['types'] !== null) {
            if ($requestParams['filter']['types'] == 1) {
                $query->andWhere(['type' => [Company::TYPE_MAINTAINER, Company::TYPE_PROVIDER]]);
            } elseif ($requestParams['filter']['types'] == 2) {
                $query->andWhere(['type' => [Company::TYPE_MED_INSTITUTE, Company::TYPE_MED_SCHOOL]]);
            }
        }

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    /**
     * @param $slug
     * @return ActiveDataProvider
     * @throws NotFoundHttpException
     */
    public function actionCategory($slug)
    {
        $query = Category::find()->andWhere(['slug' => $slug])->one();

        if (!$query instanceof Category) {
            throw new NotFoundHttpException("Category not found");
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }

    public function actionCategoryList()
    {
        $category = Category::find()->andWhere(['lang' => Lang::getLangId()])
            ->andWhere(['status' => Category::STATUS_ACTIVE, 'type' => 'Company']);

        return new ActiveDataProvider([
            'query' => $category,
        ]);

    }

    /**
     * @return Company
     */
    public function actionAddCompany()
    {
        $model = new CreateCompanyForms();
        $model->load($this->requestParams(), '');
        return $model->create();
    }


    public function actionDeleteCategory($id)
    {
        $profile = User::authorize();
        if ($profile) {
            $law = CompanyCategories::find()->where(['category_id' => $id, 'company_id' => $profile->profile->company->id])->one();
            $law->delete();
            \Yii::$app->response->setStatusCode(204);
            return ['category_id' => $id];
        }

        throw new UnauthorizedHttpException('не достотична прав');
    }

    public function actionUpdate($id)
    {
        $model = new UpdateCompanyForms(['id' => $id]);
        $model->load($this->requestParams(), '');
        return $model->update();
    }

    /**
     * @return array|ActiveDataProvider
     * @throws UnauthorizedHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionMy()
    {
        $user = User::authorize();
        $query = $user->profile->getCompanies();
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
                return ['vacations' => 'Нет вакансия'];
            }

        } else {
            Yii::$app->response->setStatusCode(422);
            throw  new UnauthorizedHttpException('Вы не авторизование!');
        }
    }

    /**
     * @param $id
     * @return array|bool|Message
     */
    public function actionCreateMessage($id)
    {
        $model = new CreateMessageForm(['id' => $id]);
        $model->load($this->requestParams(), '');
        return $model->create();
    }

    /**
     * @param $id
     * @return Review
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionReview($id)
    {
        /**
         * @var $chatRepository ChatRepository
         */
        $chatRepository = Yii::$container->get(ChatRepository::class);
        return $chatRepository->createReview($id);
    }

    public function actionGetReviews($id)
    {
        $company = Company::findOne($id);
        if ($company === null) {
            throw new NotFoundHttpException('Company not found');
        }

        return $this->getFilteredData($company->getReviews(), ReviewSearch::class);
    }

    public function actionPage($id)
    {
        $company = Company::find()->where(['company.id' => $id])->one();
        if ($company === null) {
            throw new NotFoundHttpException('Company not found');
        }
        return $company;
    }
}
