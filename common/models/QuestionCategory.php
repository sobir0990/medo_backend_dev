<?php

namespace common\models;

use common\modules\category\models\Category;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "question_category".
 *
 * @property int $question_id
 * @property int $category_id
 *
 * @property Categories $category
 * @property TestQuestion $question
 */
class QuestionCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'question_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_id', 'category_id'], 'required'],
            [['question_id', 'category_id'], 'default', 'value' => null],
            [['question_id', 'category_id'], 'integer'],
            [['question_id', 'category_id'], 'unique', 'targetAttribute' => ['question_id', 'category_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => TestQuestion::className(), 'targetAttribute' => ['question_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'question_id' => Yii::t('backend', 'Question ID'),
            'category_id' => Yii::t('backend', 'Category ID'),
        ];
    }

    public function extraFields()
    {
        return [
            'question' => function () {
                return $this->getQuestion();
            },
            'category' => function () {
                return $this->getCategory();
            }
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id'])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(TestQuestion::className(), ['id' => 'question_id'])->one();
    }
}
