<?php

namespace common\models;

use common\behaviors\SlugBehavior;
use common\components\Categories;
use common\filemanager\behaviors\InputModelBehavior;
use common\filemanager\models\Files;
use common\modules\categories\behaviors\CategoryModelBehavior;
use common\modules\category\models\Category;
use common\modules\langs\components\ModelBehavior;
use common\modules\settings\models\Settings;
use common\modules\translit\LatinBehaviour;
use common\modules\translit\LatinTokenizer;
use common\modules\translit\TextInterpreter;

use jakharbek\filemanager\behaviors\FileRelationBehavior;
use kcfinder\text;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "post".
 *
 * @property int $user_id
 * @property int $correct
 * @property int $question_id
 * @property int $answer_id
 * @property int $created_at
 * @property int $updated_at
 */
class FavoriteQuestion extends ActiveRecord
{

    const STATUS_CORRECT = 1;
    const STATUS_NO_CORRECT = 0;

    public static function tableName()
    {
        return 'favorite_question';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'question_id'], 'required'],
            [['correct', 'question_id', 'answer_id', 'user_id','created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User Id',
            'question_id' => 'Question Id',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'correct' => 'Correct',
        ];
    }

    public function getQuestion()
    {
        return $this->hasOne(TestQuestion::class, ['id' => 'question_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getAnswer()
    {
        return $this->hasOne(TestAnswer::class, ['id' => 'answer_id']);
    }


}
