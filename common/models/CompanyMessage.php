<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_message".
 *
 * @property int $company_id
 * @property int $message_id
 * @property int $status
 *
 * @property Company $company
 * @property Message $message
 */
class CompanyMessage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'message_id'], 'required'],
            [['company_id', 'message_id', 'status'], 'default', 'value' => null],
            [['company_id', 'message_id', 'status'], 'integer'],
            [['company_id', 'message_id'], 'unique', 'targetAttribute' => ['company_id', 'message_id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['message_id'], 'exist', 'skipOnError' => true, 'targetClass' => Message::className(), 'targetAttribute' => ['message_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'company_id' => 'Company ID',
            'message_id' => 'Message ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
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
     * @return CompanyMessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyMessageQuery(get_called_class());
    }
}
