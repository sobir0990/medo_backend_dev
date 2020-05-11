<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "moder_reason".
 *
 * @property integer $id
 * @property string $title
 * @property string $message
 * @property integer $category_id
 * @property string $created
 */
class ModerReason extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT =>['created']
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }



    public static function tableName()
    {
        return 'moder_reason';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['message'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'message' => 'Message',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionModers()
    {
        return $this->hasMany(QuestionModer::className(), ['reason_id' => 'id']);
    }
}
