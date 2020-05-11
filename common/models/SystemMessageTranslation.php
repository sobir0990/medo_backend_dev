<?php

namespace common\models;

use Yii;

class SystemMessageTranslation extends BaseModel
{
    public static function tableName()
    {
        return '_system_message_translation';
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['language'], 'string', 'max' => 16],
            [['translation'], 'string', 'max' => 4096],
            [['id', 'language'], 'unique', 'targetAttribute' => ['id', 'language'], 'message' => __('The combination of ID and Language has already been taken.')],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'          => __('ID'),
            'language'    => __('Language'),
            'translation' => __('Translation'),
        ];
    }

    public function getId0()
    {
        return $this->hasOne(SystemMessage::className(), ['id' => 'id']);
    }
}
