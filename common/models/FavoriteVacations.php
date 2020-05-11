<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "favorite_vacations".
 *
 * @property int $profile_id
 * @property int $vacation_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Profile $profile
 * @property Vacation $vacation
 */
class FavoriteVacations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorite_vacations';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'vacation_id'], 'required'],
            [['profile_id', 'vacation_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['profile_id', 'vacation_id', 'created_at', 'updated_at'], 'integer'],
            [['profile_id', 'vacation_id'], 'unique', 'targetAttribute' => ['profile_id', 'vacation_id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
            [['vacation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vacation::className(), 'targetAttribute' => ['vacation_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'profile_id' => 'Profile ID',
            'vacation_id' => 'Vacation ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacation()
    {
        return $this->hasOne(Vacation::className(), ['id' => 'vacation_id']);
    }
}
