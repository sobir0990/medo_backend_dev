<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile_message".
 *
 * @property int $profile_id
 * @property int $message_id
 * @property int $status
 *
 * @property Company $profile
 * @property Message $message
 */
class ProfileMessage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'message_id'], 'required'],
            [['profile_id', 'message_id', 'status'], 'default', 'value' => null],
            [['profile_id', 'message_id', 'status'], 'integer'],
            [['profile_id', 'message_id'], 'unique', 'targetAttribute' => ['profile_id', 'message_id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['profile_id' => 'id']],
            [['message_id'], 'exist', 'skipOnError' => true, 'targetClass' => Message::className(), 'targetAttribute' => ['message_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'profile_id' => 'Profile ID',
            'message_id' => 'Message ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Company::className(), ['id' => 'profile_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['id' => 'message_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProfileMessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfileMessageQuery(get_called_class());
    }
}
