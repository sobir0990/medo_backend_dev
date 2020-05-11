<?php

namespace common\models;

use tests\codeception\unit\components\HelperTest;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "test_answer".
 *
 * @property int $id
 * @property string $answer
 * @property int $question_id
 * @property int $correct
 * @property int $status
 * @property int $lang
 * @property string $lang_hash
 * @property int $created_at
 * @property int $updated_at
 *
 * @property TestQuestion $question
 */
class TestAnswer extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            'lang' => [
                'class' => \oks\langs\components\ModelBehavior::className(),
                'fill' => [
                    'answer' => '',
                ],
            ],
        ];
    }

    const STATUS_ACTIVE = 10;
    const STATUS_NE_ACTIVE = 1;

    const CORRECT = 1;
    const NO_CORRECT = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['answer', 'question_id'], 'required'],
            [['answer', 'lang_hash'], 'string'],
            ['status', 'default', 'value' => 1],
            [['question_id', 'correct', 'lang', 'status'], 'integer'],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => TestQuestion::class, 'targetAttribute' => ['question_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'answer' => Yii::t('backend', 'Answer'),
            'question_id' => Yii::t('backend', 'Question ID'),
            'correct' => Yii::t('backend', 'Correct'),
            'status' => Yii::t('backend', 'Status'),
            'created_at' => Yii::t('backend', 'Created At'),
            'updated_at' => Yii::t('backend', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(TestQuestion::class, ['id' => 'question_id']);
    }


    public static function statusList(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_NE_ACTIVE => 'Ne Active',
        ];
    }


    public static function correctList(): array
    {
        return [
            self::CORRECT => 'Правильный',
            self::NO_CORRECT => 'Некорректный',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function correctName($status): string
    {
        return ArrayHelper::getValue(self::correctList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case self::STATUS_NE_ACTIVE:
                $class = 'label label-danger';
                break;
            case self::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
        }
        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }

    public static function correctLabel($correct): string
    {
        switch ($correct) {
            case self::NO_CORRECT:
                $class = 'label label-danger';
                break;
            case self::CORRECT:
                $class = 'label label-success';
                break;
        }
        return Html::tag('span', ArrayHelper::getValue(self::correctList(), $correct), [
            'class' => $class,
        ]);
    }

    public function fields()
    {
        return [
            'id',
            'answer',
            'question_id',
            'status',
            'created_at'
        ];
    }
}
