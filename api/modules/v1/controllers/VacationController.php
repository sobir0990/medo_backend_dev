<?php
/**
 * @api      {get} /vacation Вакансия лист
 * @apiName  GetVacationsList
 * @apiGroup Vacation
 *
 * @apiSuccess {String} title Названия
 * @apiSuccess {String} text Текст
 * @apiSuccess {Number} type Тип компания 1 - Прозводитель, 2 - Поставщик, 3 - Мед учреждение, 4 - Мед училище
 * @apiSuccess {String} files Файл
 * @apiSuccess {Number} status Статус 0-DEACTIVE, 1-WAITING, 3-ACTIVE
 * @apiSuccess {Number} phone Телефон
 * @apiSuccess {Number} salary оплата труда
 * @apiSuccess {Number} salary_type тип зарплаты
 * @apiSuccess {Number} experience опыть
 * @apiSuccess {Number} type Тип
 * @apiSuccess {Object} profile Профиль
 */
/**
 * @api      {post} /vacation/create Создать Вакансия
 * @apiName  CreateVacation
 * @apiGroup Vacation
 *
 * @apiParam {String} title Названия
 * @apiParam {String} text Текст
 * @apiParam {Number} type Тип
 * @apiParam {String} files Файл
 * @apiParam {Number} phone Телефон
 * @apiParam {Number} salary оплата труда
 * @apiParam {Number} salary_type тип зарплаты
 * @apiParam {Number} experience опыть
 * @apiParam {Number} type Тип
 *
 * @apiSuccess {Object} vacation Вакансия
 */
/**
 * @api      {get} /vacation/delete/:id Удалить Вакансия
 * @apiName  DeleteVacation
 * @apiGroup Vacation
 *
 * @apiParam {Number} id Удалёний  id Вакансия
 *
 * @apiSuccess {Number}  ID удалёний Вакансия
 *
 */
/**
 * @api      {post} /vacation/update/:id  Изменения Вакансия
 * @apiName  UpdateVacation
 * @apiGroup Vacation
 *
 * @apiParam {Number} id  Изменения Вакансия id
 * @apiParam {String} title Названия
 * @apiParam {String} text Текст
 * @apiParam {Number} type Тип
 * @apiParam {String} files Файл
 * @apiParam {Number} phone Телефон
 * @apiParam {Number} salary оплата труда
 * @apiParam {Number} salary_type тип зарплаты
 * @apiParam {Number} experience опыть
 * @apiParam {Number} type Тип
 *
 * @apiSuccess {Object} vacation Вакансия
 */
/**
 * @api      {get} /vacation/my  Мой Вакансия
 * @apiName  MyVacationList
 * @apiGroup Vacation
 *
 * @apiSuccess {Object} vacation Всех Вакансия пользовителя
 *
 */

namespace api\modules\v1\controllers;

use api\components\ApiController;
use api\modules\v1\forms\CreateVacationForm;
use api\modules\v1\forms\UpdateVacation;
use common\components\Categories;
use common\filemanager\models\Files;
use common\models\Chat;
use common\models\Company;
use common\models\CompanyCategories;
use common\models\Message;
use common\models\Profile;
use common\models\User;
use common\models\Vacation;
use common\models\VacationCategories;
use common\models\VacationSearch;
use common\modules\category\models\Category;
use common\modules\langs\components\Lang;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
use yii\web\UploadedFile;

class VacationController extends ApiController
{

    public $modelClass = Vacation::class;
    public $searchModelClass = VacationSearch::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view']);
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        $requestParams = Yii::$app->request->getQueryParams();
        if ($requestParams == null) {
            $requestParams = Yii::$app->request->getBodyParams();
        }

        $query = Vacation::find();

        if (($region_id = Yii::$app->request->getQueryParam('filter')['region_id']) !== null) {
            $query->leftJoin('profile', '"vacation".profile_id = "profile".id');
            $query->andWhere(['profile.region_id' => $region_id]);
        }

        if (($place_id = Yii::$app->request->getQueryParam('filter')['place_id']) !== null) {
            $query->andWhere(['place_id' => $requestParams['filter']['place_id']]);
        }

        if (($company_id = Yii::$app->request->getQueryParam('filter')['company_id']) !== null) {
            $query->andWhere(['company_id' => $requestParams['filter']['company_id']]);
        }

        if (($status = Yii::$app->request->getQueryParam('filter')['status']) !== null) {
            $query->andWhere(['"vacation".status' => $requestParams['filter']['status']]);
        }

        if (($city_id = Yii::$app->request->getQueryParam('filter')['city_id']) !== null) {
//            $query->leftJoin('profile', '"vacation".profile_id = "profile".id');
            $query->andWhere(['profile.city_id' => $city_id]);
        }

        return new ActiveDataProvider([
            'query' => $query
        ]);
    }

    /**
     * @param $id
     * @return Vacation
     * @throws NotFoundHttpException
     */
    public function actionView($id): Vacation
    {
        $model = $this->findModel($id);
        $user = User::findOne($id);
        if ($user->profile->id !== $model->profile_id) {
            $model->updateCounters(['view' => 1]);
        }
        return $model;
    }

    /**
     * @param $id Vacation model ID
     * @return string Vacation->phone
     * @throws NotFoundHttpException
     */
    public function actionPhone($id)
    {
        /** @var Vacation $model */
        $model = $this->findModel($id);
        $model->updateCounters(['phone_view' => 1]);
        return $model->phone;
    }

    public function actionCategoryList()
    {
        $category = Category::find()
            ->andWhere(['type' => 'Vacation'])
            ->andWhere(['status' => Category::STATUS_ACTIVE])
            ->andWhere(['lang' => Lang::getLangId()])
            ->all();
        return $category;

    }

    public function actionProfileList()
    {
        $category = Category::find()
            ->andWhere(['type' => 'Profile'])
            ->andWhere(['status' => Category::STATUS_ACTIVE])
            ->andWhere(['lang' => Lang::getLangId()])
            ->all();
        return $category;

    }

    public function actionPlaceList()
    {
        return Vacation::find()
            ->select(['COUNT(vacation.*)', 'category.id', 'category.name'])
            ->leftJoin('category', 'category.id = vacation.place_id AND category.parent_id = 51')
            ->groupBy('category.id, vacation.status')
            ->having(['vacation.status' => 2])
            ->orderBy('count DESC')
            ->asArray()->all();
    }

    /**
     * @return Vacation
     * @throws UnauthorizedHttpException
     */
    public function actionCreate()
    {
        $model = new CreateVacationForm();
        $model->load($this->requestParams(),'');
        return $model->create();
    }

    /**
     * @param $id
     * @return UpdateVacation|bool|null
     */
    public function actionUpdate($id){
        $model = new UpdateVacation(['id' => $id]);
        $model->load($this->requestParams(), '');
        return $model->update();
    }

    public function actionDelete($id)
    {
        $vacation = Vacation::findOne(['id' => $id]);
        if ($vacation && $vacation->status != Vacation::STATUS_DEACTIVE) {
            $vacation->status = Vacation::STATUS_DEACTIVE;
            $vacation->save();
            return $vacation;

        }
        throw new NotFoundHttpException();
    }


    public function actionMy()
    {
        $user = User::authorize();
        $query = $user->profile->getVacations();
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
            return ['resume' => 'Нет резюме'];
        }
    }

    /**
     * @param $id
     * @return array|Message
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionSendMsg($id)
    {
        $vacation = Vacation::findOne($id);
        if ($vacation === null)
            throw new NotFoundHttpException('Vacation not found');
        /** @var Profile $user */
        $user = Yii::$app->user->identity->profile;
        $reciev = $vacation->profile;
        if ($reciev->id === $user->id) {
            throw new BadRequestHttpException('You can\'t send sms to yourself');
        }
        $rqst = Yii::$app->request->post();
        $chat = $user->getChats((int)$vacation->company->id)
            ->andWhere([
                'chat.user_1' => $user->id,
                'chat.user_2' => $reciev->id,
                'chat.ext_id' => $vacation->id,
                'chat.type' => Chat::TYPE_VACATION,
            ])
            ->one();
        if (!$chat) {
            $chat = new Chat();
            $chat->company_id = $vacation->company->id;
            $chat->title = $rqst['title'];
            $chat->type = Chat::TYPE_VACATION;
            $chat->ext_id = $vacation->id;
            $chat->user_1 = $user->id;
            $chat->user_2 = $reciev->id;
            $chat->save();
        }
        $message = new Message();
        $message->chat_id = $chat->id;
        $message->from_user = $user->id;
        $message->message = $rqst['message'];
        if ($message->save()) {
            return $message;
        } else return $message->getErrors();
    }

}
