<?php
/**
 * Created by PhpStorm.
 * User: xurshid
 * Date: 1/28/19
 * Time: 4:37 PM
 */
/**
 * @api      {get} /resume Резюме лист
 * @apiName  GetResumeList
 * @apiGroup Resume
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
 * @api      {post} /resume/create Создать резюме
 * @apiName  CreateResume
 * @apiGroup Resume
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
 * @apiSuccess {Object} resume Резюме
 */

/**
 * @api      {get} /resume/delete/:id Удалить Резюме
 * @apiName  DeleteResume
 * @apiGroup Resume
 *
 * @apiParam {Number} id Удалёний  id резюме
 *
 * @apiSuccess {Number}  ID удалёний резюме
 *
 */

/**
 * @api      {post} /resume/update/:id  Изменения резюме
 * @apiName  UpdateResume
 * @apiGroup Resume
 *
 * @apiParam {Number} id  Изменения резюме id
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
 * @apiSuccess {Object} resume  Резюме
 */
/**
 * @api      {get} /resume/my  Мой Резюме
 * @apiName  MyResumeList
 * @apiGroup Resume
 *
 * @apiSuccess {Object} resume Всех Резюме пользовителя
 *
 */

namespace api\modules\v1\controllers;


use api\components\ApiController;
use api\modules\v1\forms\CreateResumeForms;
use api\modules\v1\forms\UpdateResumeForms;
use common\components\Categories;
use common\filemanager\models\Files;
use common\models\Chat;
use common\models\Message;
use common\models\Profile;
use common\models\Region;
use common\models\Resume;
use common\models\ResumeCategories;
use common\models\ResumeSearch;
use common\models\Review;
use common\models\User;
use common\modules\category\models\Category;
use common\modules\chat\form\ResumeSendMessageForm;
use common\modules\langs\components\Lang;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
use yii\web\UploadedFile;

class ResumeController extends ApiController
{

    public $modelClass = Resume::class;
    public $searchModelClass = ResumeSearch::class;

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

        $query = Resume::find();
        $query->leftJoin('profile', '"resume".profile_id = "profile".id');

        if ($requestParams['filter']['status'] !== null) {
            $query->andWhere(['"resume".status' => $requestParams['filter']['status']]);
        }

        if ($requestParams['filter']['profile_id'] !== null) {
            $query->andWhere(['profile_id' => $requestParams['filter']['profile_id']]);
        }

        if ($requestParams['filter']['place_id'] !== null) {
            $query->andWhere(['place_id' => $requestParams['filter']['place_id']]);
        }

        if (($region_id = Yii::$app->request->getQueryParam('filter')['region_id']) !== null) {
            $query->andWhere(['profile.region_id' => $region_id]);
        }

        if (($city_id = Yii::$app->request->getQueryParam('filter')['city_id']) !== null) {
//            $query->leftJoin('profile', '"resume".profile_id = "profile".id');
            $query->andWhere(['profile.city_id' => $city_id]);
        }

        if (($category_id = Yii::$app->request->getQueryParam('filter')['category_id']) !== null) {
            $query->leftJoin('resume_categories', '"resume".id = "resume_categories".resume_id');
            $query->andWhere(['"resume_categories".category_id' => $category_id]);

        }


        return new ActiveDataProvider([
            'query' => $query
        ]);
    }


    /**
     * @param $id
     * @return Resume
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id): Resume
    {
        $model = $this->findModel($id);
        $user = User::findOne($id);
        if ($user->profile->id !== $model->profile_id) {
            $model->updateCounters(['view' => 1]);
        }
        return $model;
    }

    /**
     * @return Resume
     */
    public function actionCreate()
    {
        $model = new CreateResumeForms();
        $model->load($this->requestParams(), '');
        return $model->create();
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws UnauthorizedHttpException
     */
    public function actionDelete($id)
    {
        $model = Resume::findOne($id);
        $user = User::authorize();
        if ($model->profile_id == $user->profile->id) {
            $model->status = Resume::STATUS_DEACTIVE;
            if ($model->save()) return $model;
        } else {
            throw new UnauthorizedHttpException('У вас нет право удаления!');
        }
    }

    public function actionCategoryList()
    {
        $category = Category::find()->andWhere(['status' => Category::STATUS_ACTIVE])
            ->andWhere(['type' => 'Profile'])
            ->andWhere(['lang' => Lang::getLangId()])
            ->all();
        return $category;
    }

    public function actionPlaceList()
    {
        return Resume::find()
            ->select(['COUNT(resume.*)', 'category.id', 'category.name'])
            ->leftJoin('category', 'category.id = resume.place_id AND category.parent_id = 51')
            ->groupBy('category.id, resume.status')
            ->having(['resume.status' => 2])
            ->orderBy('count DESC')
            ->asArray()
            ->all();

    }

    public function actionCategories()
    {
        return Resume::find()
            ->select(['COUNT(resume.*)', 'category.id', 'category.name', 'category.slug'])
            ->leftJoin('category', 'category.id = resume_categories.category_id')
            ->groupBy('category.id, resume.status')
            ->having(['resume.status' => 2])
            ->orderBy('count DESC')
            ->asArray()
            ->all();
    }

    public function actionUpdate($id)
    {
        $model = new UpdateResumeForms(['id' => $id]);
        $model->load($this->requestParams(), '');
        return $model->update();
    }

    public function actionPhone($id)
    {
        /** @var Resume $model */
        $model = $this->findModel($id);
        $model->updateCounters(['phone_view' => 1]);
        return $model->phone;
    }

    /**
     * @return array|ActiveDataProvider
     * @throws NotFoundHttpException
     * @throws UnauthorizedHttpException
     */
    public function actionMy()
    {
        $user = User::authorize();
        $query = $user->profile->getResumes();
        if ($user) {
            if ($query) {
                return $this->getFilteredData($query, ResumeSearch::class);
            }
            return ['resume' => 'Нет resume'];
        }

        Yii::$app->response->setStatusCode(422);
        throw  new UnauthorizedHttpException('Вы не авторизование!');
    }

    public function actionSendMsg($id)
    {
        $model = new ResumeSendMessageForm(['id' => $id]);
        $model->load($this->requestParams(), '');
        return $model->sendMessage();
    }

}
