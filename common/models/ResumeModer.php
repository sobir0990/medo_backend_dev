<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "resume_moder".
 *
 * @property int $id
 * @property int $resume_id
 * @property int $reason_id
 * @property int $status
 * @property int $created
 *
 * @property ModerReason $reason
 * @property Resume $resume
 */
class ResumeModer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resume_moder';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['resume_id', 'reason_id'], 'required'],
            [['resume_id', 'reason_id', 'status', 'created'], 'default', 'value' => null],
            [['resume_id', 'reason_id', 'status', 'created'], 'integer'],
            [['reason_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModerReason::className(), 'targetAttribute' => ['reason_id' => 'id']],
            [['resume_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resume::className(), 'targetAttribute' => ['resume_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'resume_id' => 'Resume ID',
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
    public function getResume()
    {
        return $this->hasOne(Resume::className(), ['id' => 'resume_id']);
    }
}
