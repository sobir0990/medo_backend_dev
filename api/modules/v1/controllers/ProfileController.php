<?php

namespace api\modules\v1\controllers;

use api\components\ApiController;
use api\modules\v1\forms\ProfileUpdateForm;
use api\modules\v1\forms\UpdateUserForm;
use common\models\Chat;
use common\models\CompanySearch;
use common\models\Message;
use common\models\MessageSearch;
use common\models\Profile;
use common\models\ProfileSearch;
use common\models\User;
use common\modules\category\models\Category;
use common\filemanager\models\Files;
use common\modules\chat\ChatRepository;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
use yii\web\UnprocessableEntityHttpException;

/**
 * @api      {get} /profile/ Профил Листь
 * @apiName  ProfileList
 * @apiGroup Profile
 *
 * @apiParam {String} all-categories Запрос категория
 *
 * @apiSuccess {Number} id Профил UNIQUE ID.
 * @apiSuccess {String} full_name Имя Профиля
 * @apiSuccess {String} phone Телефон
 * @apiSuccess {String} email Email
 * @apiSuccess {String} bio Биография
 * @apiSuccess {Number} rating Рейтинг
 * @apiSuccess {Number} top ТОП
 * @apiSuccess {Object} region Область
 * @apiSuccess {Object} city Город
 * @apiSuccess {Object} address Улица
 * @apiSuccess {Object} user Ползавитель
 * @apiSuccess {Number} type value JOURNALIST = 3; JURIST = 2; ADVOCATE = 1; USER = 0.
 */
/**
 * @api      {get} /profile/:id Запрос Ползаватель
 * @apiName  ProfileID
 * @apiGroup Profile
 *
 * @apiParam {Number} id Запрос Ползаватель
 *
 * @apiSuccess {Number} id Профил UNIQUE ID.
 * @apiSuccess {String} full_name Имя Профиля
 * @apiSuccess {String} phone Телефон
 * @apiSuccess {String} email Email
 * @apiSuccess {String} bio Биография
 * @apiSuccess {Number} rating Рейтинг
 * @apiSuccess {Number} top ТОП
 * @apiSuccess {Object} region Область
 * @apiSuccess {Object} city Город
 * @apiSuccess {Object} address Улица
 * @apiSuccess {Object} user Ползователь
 * @apiSuccess {Number} type value JOURNALIST = 3; JURIST = 2; ADVOCATE = 1; USER = 0.
 */
/**
 * @api      {post} /profile/change-photo/  Дабавить Изображения
 * @apiName  AddChangePhoto
 * @apiGroup Profile
 *
 * @apiParam {String} files  Изображения
 *
 * @apiSuccess {Array} success Готов.
 * @apiSuccess {Number} user_id User id  присвязн на Профиль.
 * @apiSuccess {Number} date_create  Создания дата.
 * @apiSuccess {String} title  названия файла.
 * @apiSuccess {String} description  названия файла.
 * @apiSuccess {String} description  названия файла.
 * @apiSuccess {String} type  Тип файла.
 * @apiSuccess {String} file  Хеш названия.
 * @apiSuccess {Number} file_id Файл ИД.
 * @apiSuccess {Array} error Can't save.
 *
 */
/**
 * @return ProfileUpdateForm|array|null
 * @throws UnprocessableEntityHttpException
 * @api      {put} /profile/ Изменение данных профиля
 * @apiName  UpdateProfile
 * @apiGroup Profile
 *
 * @apiParam {String} full_name
 * @apiParam {String} email
 * @apiParam {String} old_password
 * @apiParam {String} password
 * @apiParam {String} region
 * @apiParam {String} bio
 * @apiParam {Integer} gender
 * @apiParam {Integer} region_id
 * @apiParam {Integer} city
 * @apiParam {String} adress
 * @apiParam {String} adress_desc
 * @apiParam {Array} category_id
 *
 * @apiSuccess {Object} Profile Возвращает измененные данные
 *
 */
/**
 * @api      {post} /profile/add-category Дабавить категория ползователя
 * @apiName  AddCategory
 * @apiGroup Profile
 *
 * @apiParam {Array} category_id  ID Категорий ползователя
 *
 * @apiSuccess {Array} Category Сахранёние категории
 *
 *
 */

/**
 * @api      {delete} /profile/delete-category/:id Удалить категория ползователя
 * @apiName  DeleteCategory
 * @apiGroup Profile
 *
 * @apiParam {Number} id Категория ID
 *
 * @apiSuccess {Success} 204 Success
 *
 */
class ProfileController extends ApiController
{
    public $modelClass = Profile::class;
    public $searchModelClass = ProfileSearch::class;


    public function actionAllCategories()
    {
        $category = Category::find()
            ->andWhere(['type' => 'Profile'])
            ->andWhere(['status' => Category::STATUS_ACTIVE])
            ->all();

        return new ActiveDataProvider([
            'query' => $category
        ]);
    }

    /**
     * @return array
     * @throws UnprocessableEntityHttpException
     */
    public function actionUpdate()
    {
        $model = new  ProfileUpdateForm();
        $model->load(Yii::$app->request->post(), '');
        return $model->update();
    }

    /**
     * @param $id
     * @return array|bool
     * @throws \yii\base\Exception
     * @api profile/id/user
     * @method PUT
     */
    public function actionUpdateUser($id)
    {
        $model = new UpdateUserForm(['id' => $id]);
        $model->load($this->requestParams(), '');
        return $model->update();
    }


    /**
     * @return array|ActiveDataProvider
     * @throws NotFoundHttpException
     * @throws UnauthorizedHttpException
     */
    public function actionChats()
    {
        $user = User::authorize();
        $query = $user->profile->getCompanies();

        if ($user) {
            if ($query) {
                return $this->getFilteredData($query, CompanySearch::class);
            }
            return ['company' => 'Нет company'];
        }

        Yii::$app->response->setStatusCode(422);
        throw  new UnauthorizedHttpException('Вы не авторизование!');

    }


    /**
     * Gets all chats in one company given by $id
     * @param $id integer
     * @return array|Chat[]|Message[]
     */
    public function actionCompanyChats($id)
    {
        $profileID = Yii::$app->user->identity->profile->id;
        if ((int)$id === 0) {
            return Chat::find()
                ->joinWith(['messages'])
                ->orWhere(['company_id' => null, 'chat.user_2' => $profileID])
                ->orWhere(['chat.user_1' => $profileID,])
                ->all();
        }

        $chat = Chat::find()->where(['company_id' => (int)$id, 'chat.user_2' => $profileID])
            ->all();

        return $chat;
    }

    public function actionMessages($chatId)
    {
        Message::updateAll(['is_read' => 1], ['chat_id' => $chatId]);
        $q = Message::find()->with('fromUser')
            ->where(['message.chat_id' => $chatId]);
        return $this->getFilteredData($q, MessageSearch::class);
    }

    public function actionSendMsg(int $reciever, $comp_id = null)
    {

        $requstParams = $this->requestParams();

        /** @var Profile $user */
        $user = Yii::$app->user->identity->profile;
        if ($reciever === $user->id) {
            throw new BadRequestHttpException('You can\'t send sms to yourself');
        }
        $profile = Profile::findOne($reciever);
        $chat = $user->getChats((int)$comp_id)
            ->where("(chat.user_2 = {$profile->id} AND chat.user_1 = {$user->id}) OR (chat.user_1 = {$profile->id} AND chat.user_2 = {$user->id})")
            ->one();

        if (!$chat) {
            $chat = new Chat();
            $chat->company_id = $comp_id;
            $chat->title = $requstParams['title'];
            $chat->user_1 = $user->id;
            $chat->user_2 = $profile->id;
            $chat->save();
        }
        $message = new Message();
        $message->chat_id = $chat->id;
        $message->from_user = $user->id;
        $message->message = $requstParams['message'];
        if (!$message->save()) {
            return $message->getErrors();
        }
        return $message;

    }

    /**
     * @param $chatid
     * @return Message
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function actionReply($chatid)
    {
        if (!($chat = Chat::findOne($chatid))) {
            throw new NotFoundHttpException();
        }

        $requestParams = $this->requestParams();

        $user = Yii::$app->user->identity->profile;
        $message = new Message();
        $message->chat_id = $chat->id;
        $message->from_user = $user->id;
        $message->message = $requestParams['message'];
        if (!$message->save()) {
            Yii::$app->response->setStatusCode(422);
        }
        return $message;

    }

    public function actionChangeType()
    {
        /** @var Profile $profile */
        $profile = Yii::$app->user->identity->profile;

        $profile->updateAttributes(['type' => Profile::TYPE_DOCTOR]);
        return $profile;
    }
}
