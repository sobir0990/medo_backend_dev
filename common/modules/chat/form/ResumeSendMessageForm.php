<?php


namespace common\modules\chat\form;


use common\models\Chat;
use common\models\Message;
use common\models\Resume;
use Yii;
use yii\base\Model;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class ResumeSendMessageForm extends Model
{

    public $id;
    public $user_1;
    public $user_2;
    public $ext_id;
    public $company_id;
    public $from_user;
    public $chat_id;
    public $title;
    public $message;
    public $type;

    public function rules()
    {
        return [
            [['user_1', 'user_2', 'ext_id', 'company_id', 'from_user', 'chat_id'], 'integer'],
            [['title', 'message', 'type'], 'string', 'max' => 254],
            [['user_1', 'user_2', 'ext_id'], 'chatValidator']
        ];
    }


    public function chatValidator()
    {
        $resume = Resume::findOne($this->id);
        if (!($resume instanceof Resume)) {
            throw new NotFoundHttpException('Resume not found');
        }

        $user = Yii::$app->user->identity->profile;
        $reciev = $resume->profile;
        if ($reciev->id === $user->id) {
            throw new BadRequestHttpException('You can\'t send sms to yourself');
        }
    }


    public function sendMessage()
    {
        $resume = Resume::findOne($this->id);
        $user = Yii::$app->user->identity->profile;

        $chats = $user->getChats()
            ->andWhere(['chat.user_2' => $resume->profile->id, 'chat.user_1' => $user->id, 'chat.ext_id' => $resume->id])
            ->andWhere(['chat.type' => Chat::TYPE_RESUME])
            ->one();

        if (!is_object($chats)) {
            $this->_createChat($resume, $user);
        }

        $message = new Message();
        $message->chat_id = $chats->id;
        $message->from_user = $user->id;
        $message->message = $this->message;
        if (!$message->save()) {
            Yii::$app->response->setStatusCode(422);
        }
        return $message;
    }

    private function _createChat($resume, $user)
    {
        $chat = new Chat();
        $chat->title = $this->message;
        $chat->type = Chat::TYPE_RESUME;
        $chat->ext_id = $resume->id;
        $chat->user_1 = $user->id;
        $chat->user_2 = $resume->profile->id;
        return $chat->save();
    }

}
