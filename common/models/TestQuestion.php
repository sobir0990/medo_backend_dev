<?php

namespace common\models;

use common\components\Categories;
use common\modules\categories\behaviors\CategoryModelBehavior;
use common\modules\category\models\Category;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "test_question".
 *
 * @property int $id
 * @property string $question
 * @property int $status
 * @property int $lang
 * @property int $category_id
 * @property string $lang_hash
 * @property int $created_at
 * @property int $updated_at
 *
 * @property QuestionCategory[] $questionCategories
 * @property Categories[] $categories
 * @property TestAnswer[] $answers
 */
class TestQuestion extends \yii\db\ActiveRecord
{
    public $category_id;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            'lang' => [
                'class' => \oks\langs\components\ModelBehavior::className(),
                'fill' => [
                    'question' => '',
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question'], 'required'],
            [['question'], 'string'],
            [['status'], 'default', 'value' => 1],
            [['status', 'lang', 'category_id'], 'integer'],
            [['lang_hash'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'question' => Yii::t('backend', 'Question'),
            'status' => Yii::t('backend', 'Status'),
            'lang' => Yii::t('backend', 'Lang'),
            'lang_hash' => Yii::t('backend', 'Lang Hash'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionCategories()
    {
        return $this->hasMany(QuestionCategory::class, ['question_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->via('questionCategories');
    }

    public function getCategoryNew()
    {
        return QuestionCategory::findOne(['question_id' => $this->id]) ?: new Category();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(TestAnswer::class, ['question_id' => 'id']);
    }

    public function fields()
    {
        return array_merge(parent::fields(), ['answers']);
    }

    public function afterSave($insert, $attr = NULL)
    {

        $this->saveRelationItems();
        return parent::afterSave($insert, $attr = NULL);
    }

    public function saveRelationItems()
    {
        if (!empty($this->category_id)) {
            $category = new QuestionCategory();
            $category->question_id = $this->id;
            $category->category_id = $this->category_id;
            $category->save();
        }

    }

    public function beforeDelete()
    {
        QuestionCategory::deleteAll(['question_id' => $this->id]);
        return parent::beforeValidate();
    }

    public function beforeSave($insert, $attr = NULL)
    {

        if (!$this->isNewRecord) {
            QuestionCategory::deleteAll(['question_id' => $this->id]);
        }
        return parent::beforeSave($insert, $attr);
    }

}
