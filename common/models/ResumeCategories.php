<?php

namespace common\models;

use common\modules\categories\models\Categories;
use Yii;

/**
 * This is the model class for table "resume_categories".
 *
 * @property int $resume_id
 * @property int $category_id
 *
 * @property Categories $category
 * @property Resume $resume
 */
class ResumeCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resume_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['resume_id', 'category_id'], 'default', 'value' => null],
            [['resume_id', 'category_id'], 'integer'],
            [['resume_id', 'category_id'], 'unique', 'targetAttribute' => ['resume_id', 'category_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['resume_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resume::className(), 'targetAttribute' => ['resume_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'resume_id' => 'Resume ID',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResume()
    {
        return $this->hasOne(Resume::className(), ['id' => 'resume_id']);
    }
}
