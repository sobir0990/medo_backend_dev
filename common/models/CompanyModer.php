<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_moder".
 *
 * @property int $id
 * @property int $company_id
 * @property int $reason_id
 * @property int $status
 * @property int $created
 *
 * @property Company $company
 * @property ModerReason $reason
 */
class CompanyModer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_moder';
    }
    const STATUS_NEW = 0;
    const STATUS_READ = 1;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'reason_id'], 'required'],
            [['company_id', 'reason_id', 'status', 'created'], 'default', 'value' => null],
            [['company_id', 'reason_id', 'status', 'created'], 'integer'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['reason_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModerReason::className(), 'targetAttribute' => ['reason_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'reason_id' => 'Reason ID',
            'status' => 'Status',
            'created' => 'Created',
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
    public function getReason()
    {
        return $this->hasOne(ModerReason::className(), ['id' => 'reason_id']);
    }
}
