<?php

namespace common\modules\paycom\models;

use common\models\User;
use common\modules\fixture\models\Fixture;
use common\modules\paycom\dto\PaymentHistoryDTO;
use common\modules\post\models\Post;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "payment_history".
 *
 * @property int $id
 * @property int $user_id
 * @property int $payment_type
 * @property int $amount
 * @property int $created_at
 * @property string $description
 *
 * @property User $user
 */
class PaymentHistory extends \yii\db\ActiveRecord
{

    const PAYMENT_TYPE_PAYCOM = 1;
    const PAYMENT_TYPE_PAYNET = 2;
    const PAYMENT_TYPE_CLICK = 3;
    const PAYMENT_TYPE_UZCARD = 4;
    const PAYMENT_TYPE_UPAY = 5;
    const PAYMENT_TYPE_OSON = 6;

    const PAYMENT_TYPE_MANUAL = 7;

    const PAYMENT_CANCELLED_TYPE_PAYCOM = -1;
    const PAYMENT_CANCELLED_TYPE_PAYNET = -2;
    const PAYMENT_CANCELLED_TYPE_CLICK = -3;
    const PAYMENT_CANCELLED_TYPE_UZCARD = -4;
    const PAYMENT_CANCELLED_TYPE_UPAY = -5;
    const PAYMENT_CANCELLED_TYPE_OSON = -6;

    const PAYMENT_CANCELLED_TYPE_MANUAL = -7;

    const PAYED_TYPE_COMMENT = -100;

    const COMMENT_TYPE_POST = 1;
    const COMMENT_TYPE_FIXTURE = 2;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'payment_type', 'amount', 'created_at'], 'default', 'value' => null],
            [['user_id', 'payment_type', 'amount', 'created_at', 'transaction_id'], 'integer'],
            [['description'], 'string'],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    public function behaviors()
    {
        return array(
            'date_filter' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],

        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'payment_type' => 'Payment Type',
            'amount' => 'Amount',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\paycom\models\query\PaymentHistoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\paycom\models\query\PaymentHistoryQuery(get_called_class());
    }

    public static function add(PaymentHistoryDTO $dto)
    {
        $history = new static();
        $history->user_id = $dto->user_id;
        $history->payment_type = $dto->payment_type;
        $history->amount = $dto->amount;
        $history->description = $dto->description;
        $history->save();
    }

}
