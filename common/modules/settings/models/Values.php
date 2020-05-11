<?php

namespace common\modules\settings\models;


use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\SluggableBehavior;
/**
 * This is the model class for table "values".
 *
 * @property int $value_id
 * @property int $type
 * @property string $value
 */
class Values extends \yii\db\ActiveRecord
{
    const SCENARIO_SEARCH = "search";
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'default', 'value' => null],
            [['type'], 'integer'],
            [['value'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'value_id' => 'Value ID',
            'type' => 'Type',
            'value' => 'Value',
        ];
    }


    /**
     * @inheritdoc
     * @return ValuesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ValuesQuery(get_called_class());
    }

}
