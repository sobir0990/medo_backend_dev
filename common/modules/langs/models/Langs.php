<?php

namespace common\modules\langs\models;

use Yii;

/**
 * This is the model class for table "langs".
 *
 * @property int $lang_id Идентификатор языка
 * @property string $name Название (имя) языка
 * @property string $code Код языка
 * @property string $flag Флаг языка (изображение)
 * @property bool $status Язык используеться в системе или нет
 *
 */
class Langs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'langs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['flag'], 'string'],
            [['status'], 'boolean'],
            [['name'], 'string', 'max' => 45],
            [['code'], 'string', 'max' => 3],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lang_id' => 'Идентификатор языка',
            'name' => 'Название (имя) языка',
            'code' => 'Код языка',
            'flag' => 'Флаг языка (изображение)',
            'status' => 'Язык используеться в системе или нет',
        ];
    }

    public static function find()
    {
        return new LangsQuery(get_called_class());
    }

}
