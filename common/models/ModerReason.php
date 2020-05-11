<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "moder_reason".
 *
 * @property int $id
 * @property string $title
 * @property string $message
 * @property string $created
 *
 * @property CompanyModer[] $companyModers
 * @property PostModer[] $postModers
 * @property ProductModer[] $productModers
 * @property ResumeModer[] $resumeModers
 * @property ReviewModer[] $reviewModers
 * @property VacationModer[] $vacationModers
 */
class ModerReason extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'moder_reason';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'message', 'created'], 'required'],
            [['message'], 'string'],
            [['created'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'message' => 'Message',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyModers()
    {
        return $this->hasMany(CompanyModer::className(), ['reason_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostModers()
    {
        return $this->hasMany(PostModer::className(), ['reason_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductModers()
    {
        return $this->hasMany(ProductModer::className(), ['reason_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResumeModers()
    {
        return $this->hasMany(ResumeModer::className(), ['reason_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewModers()
    {
        return $this->hasMany(ReviewModer::className(), ['reason_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacationModers()
    {
        return $this->hasMany(VacationModer::className(), ['reason_id' => 'id']);
    }
}
