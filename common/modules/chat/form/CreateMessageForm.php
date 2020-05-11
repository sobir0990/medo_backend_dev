<?php

namespace common\modules\chat\form;

use common\models\Chat;
use common\models\Company;
use common\models\Message;
use common\modules\chat\ChatRepository;
use Yii;

class CreateMessageForm extends \yii\base\Model
{

    public $id;
    public $company_id;
    public $title;
    public $chat_id;
    public $from_user;
    public $message;
    public $profile_id;
    const TYPE_COMPANY = 'Company';

    public function rules()
    {
        return [
            [['company_id', 'chat_id', 'from_user'], 'integer'],
            [['title', 'message'], 'string', 'max' => 254],
            [['company_id', 'profile_id'], 'chatValidator']
        ];
    }

    public function chatValidator()
    {
        /**
         * @var $chatRepository ChatRepository
         */
        $chatRepository = Yii::$container->get(ChatRepository::class);
        $chatRepository->chatValidator($this->company_id);
    }

    public function create()
    {
        if (!$this->validate()) {
            return false;
        }

        $company = Company::findOne($this->id);
        $user = Yii::$app->user->identity->profile;
        $chat = new Chat();
        $chat->company_id = $company->id;
        $chat->title = $this->title;
        $chat->type = self::TYPE_COMPANY;
        if (!$chat->save()) {
            Yii::$app->response->setStatusCode(422);
        };

        $message = new Message();
        $message->chat_id = $chat->id;
        $message->from_user = $user->id;
        $message->message = $this->message;
        if (!$message->save()) {
            return $message->getErrors();
        }
        return $message;
    }


}
