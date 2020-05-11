<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "review_moder".
 *
 * @property int $id
 * @property int $review_id
 * @property int $reason_id
 * @property int $status
 * @property int $created
 *
 * @property ModerReason $reason
 * @property Review $review
 */
class ReviewModer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review_moder';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['review_id', 'reason_id'], 'required'],
            [['review_id', 'reason_id', 'status', 'created'], 'default', 'value' => null],
            [['review_id', 'reason_id', 'status', 'created'], 'integer'],
            [['reason_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModerReason::className(), 'targetAttribute' => ['reason_id' => 'id']],
            [['review_id'], 'exist', 'skipOnError' => true, 'targetClass' => Review::className(), 'targetAttribute' => ['review_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'review_id' => 'Review ID',
            'reason_id' => 'Reason ID',
            'status' => 'Status',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReason()
    {
        return $this->hasOne(ModerReason::className(), ['id' => 'reason_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReview()
    {
        return $this->hasOne(Review::className(), ['id' => 'review_id']);
    }
}
