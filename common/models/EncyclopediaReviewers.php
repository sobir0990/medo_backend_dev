<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "encyclopedia_reviewers".
 *
 * @property int $encyclopedia_id
 * @property int $reviewer_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Encyclopedia $encyclopedia
 * @property Profile $reviewer
 */
class EncyclopediaReviewers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'encyclopedia_reviewers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['encyclopedia_id', 'reviewer_id'], 'required'],
            [['encyclopedia_id', 'reviewer_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['encyclopedia_id', 'reviewer_id', 'created_at', 'updated_at'], 'integer'],
            [['encyclopedia_id', 'reviewer_id'], 'unique', 'targetAttribute' => ['encyclopedia_id', 'reviewer_id']],
            [['encyclopedia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Encyclopedia::className(), 'targetAttribute' => ['encyclopedia_id' => 'id']],
            [['reviewer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['reviewer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'encyclopedia_id' => 'Encyclopedia ID',
            'reviewer_id' => 'Reviewer ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEncyclopedia()
    {
        return $this->hasOne(Encyclopedia::className(), ['id' => 'encyclopedia_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewer()
    {
        return $this->hasOne(Profile::className(), ['id' => 'reviewer_id']);
    }
}
