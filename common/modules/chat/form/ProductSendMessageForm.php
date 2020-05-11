<?php


namespace common\modules\chat\form;

use common\models\Chat;
use common\models\Message;
use common\models\Product;
use Yii;
use yii\base\Model;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class ProductSendMessageForm extends Model
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
            [['user_1','user_2', 'ext_id'], 'chatValidator']
        ];
    }

    /**
     * @return bool|void
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function chatValidator()
    {
        $user = Yii::$app->user->identity->profile;
        $model = Product::findOne($this->id);
        if ($model === null)
            throw new NotFoundHttpException('product not found');

        if ($model->profile->id === $user->id) {
            throw new BadRequestHttpException('You can\'t send sms to yourself');
        }

        $chat = $user->getChats((int)$model->company->id)
            ->andWhere(['chat.user_1' => $user->id, 'chat.user_2' => $model->profile->id, 'chat.ext_id' => $model->id])
            ->andWhere(['chat.type' => [Chat::TYPE_ANNOUNCE, Chat::TYPE_PRODUCT]])
            ->exists();

        if ($chat) {
            return true;
        }
        return $this->addError('You\'ve already sent a message');
    }

    /**
     * @return bool|Message
     */
    public function create()
    {
        if(!$this->validate()){
            return false;
        }

        $model = Product::findOne($this->id);
        $user = Yii::$app->user->identity->profile;

        $chat = new Chat();
        $chat->company_id = $model->company->id;
        $chat->title = $this->title;
        $chat->type = $model->type ? Chat::TYPE_ANNOUNCE : Chat::TYPE_PRODUCT;
        $chat->ext_id = $model->id;
        $chat->user_1 = $user->id;
        $chat->user_2 = $model->profile->id;
        if (!$chat->save()) {
            Yii::$app->response->setStatusCode(422);
        }

        $message = new Message();
        $message->chat_id = $chat->id;
        $message->from_user = $user->id;
        $message->message = $this->message;
        if (!$message->save()) {
            Yii::$app->response->setStatusCode(422);
        }
        return $message;
    }

}
