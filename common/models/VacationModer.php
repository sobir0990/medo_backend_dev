<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vacation_moder".
 *
 * @property int $id
 * @property int $vacation_id
 * @property int $reason_id
 * @property int $status
 * @property int $created
 *
 * @property ModerReason $reason
 * @property Vacation $vacation
 */
class VacationModer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacation_moder';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vacation_id', 'reason_id'], 'required'],
            [['vacation_id', 'reason_id', 'status', 'created'], 'default', 'value' => null],
            [['vacation_id', 'reason_id', 'status', 'created'], 'integer'],
            [['reason_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModerReason::className(), 'targetAttribute' => ['reason_id' => 'id']],
            [['vacation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vacation::className(), 'targetAttribute' => ['vacation_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vacation_id' => 'Vacation ID',
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
    public function getVacation()
    {
        return $this->hasOne(Vacation::className(), ['id' => 'vacation_id']);
    }
}
