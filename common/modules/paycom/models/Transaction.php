<?php

namespace common\modules\paycom\models;

use common\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property string $transaction_id
 * @property int $time
 * @property int $created_at
 * @property int $perform_at
 * @property int $cancel_at
 * @property int $amount
 * @property int $state
 * @property int $reason
 * @property int $user_id
 *
 * @property User $user
 */
class Transaction extends \yii\db\ActiveRecord
{

    const TIMEOUT = 43200000;

    const STATE_CREATED = 1;
    const STATE_COMPLETED = 2;
    const STATE_CANCELLED = -1;
    const STATE_CANCELLED_AFTER_COMPLETE = -2;

    const REASON_RECEIVERS_NOT_FOUND = 1;
    const REASON_PROCESSING_EXECUTION_FAILED = 2;
    const REASON_EXECUTION_FAILED = 3;
    const REASON_CANCELLED_BY_TIMEOUT = 4;
    const REASON_FUND_RETURNED = 5;
    const REASON_UNKNOWN = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['time', 'created_at', 'perform_at', 'cancel_at', 'amount', 'state', 'reason', 'user_id'],
                'default',
                'value' => null
            ],
            [['time', 'created_at', 'perform_at', 'cancel_at', 'amount', 'state', 'reason', 'user_id'], 'integer'],
            [['transaction_id'], 'string', 'max' => 25],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \Yii::$app->user->identityClass,
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
            'transaction_id' => 'Transaction ID',
            'time' => 'Time',
            'created_at' => 'Created At',
            'perform_at' => 'Perform At',
            'cancel_at' => 'Cancel At',
            'amount' => 'Amount',
            'state' => 'State',
            'reason' => 'Reason',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\Yii::$app->user->identityClass, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\paycom\models\query\TransactionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\paycom\models\query\TransactionQuery(get_called_class());
    }

    public function isExpired()
    {
        return ($this->created_at - time()) >= static::TIMEOUT;
    }

    public function cancel($reason)
    {
        $this->cancel_at = time();
        if ($this->state == static::STATE_COMPLETED) {
            $this->state = static::STATE_CANCELLED_AFTER_COMPLETE;
        } else {
            $this->state = static::STATE_CANCELLED;
        }

        $this->reason = $reason;

        $this->save();
    }
}
