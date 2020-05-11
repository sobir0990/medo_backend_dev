<?php

namespace common\modules\settings\models;


use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\SluggableBehavior;
/**
 * This is the model class for table "settingsvalues".
 *
 * @property int $setting_id
 * @property int $value_id
 * @property int $sort
 *
 * @property Settings $setting
 * @property Values $value
 */
class SettingsValues extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settingsvalues';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['setting_id', 'value_id'], 'required'],
            [['setting_id', 'value_id', 'sort'], 'default', 'value' => null],
            [['setting_id', 'value_id', 'sort'], 'integer'],
            [['setting_id', 'value_id'], 'unique', 'targetAttribute' => ['setting_id', 'value_id']],
            [['setting_id'], 'exist', 'skipOnError' => true, 'targetClass' => Settings::className(), 'targetAttribute' => ['setting_id' => 'setting_id']],
            [['value_id'], 'exist', 'skipOnError' => true, 'targetClass' => Values::className(), 'targetAttribute' => ['value_id' => 'value_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'setting_id' => 'Setting ID',
            'value_id' => 'Value ID',
            'sort' => 'Sort',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSetting()
    {
        return $this->hasOne(Settings::className(), ['setting_id' => 'setting_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValue()
    {
        return $this->hasOne(Values::className(), ['value_id' => 'value_id']);
    }
}
