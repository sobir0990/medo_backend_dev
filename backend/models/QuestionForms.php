<?php
/**
 * Created by PhpStorm.
 * User: OKS
 * Date: 26.09.2019
 * Time: 13:45
 */

namespace backend\models;


use common\models\TestAnswer;
use common\models\TestQuestion;
use yii\base\Model;

class QuestionForms extends Model
{
    public $id;
    public $question;
    public $category_id;
    public $status;
    public $correct;
    public $answers;

    public function rules()
    {
        return [
            [['question'], 'required'],
            [['status', 'id', 'correct', 'category_id'], 'integer'],
            [['question'], 'string'],
            [['answers'], 'safe']
        ];
    }

    public function create()
    {
        if (!$this->validate()) {
            return false;
        }

        $question = new TestQuestion();
        $question->question = $this->question;
        $question->status = $this->status;
        $question->category_id = $this->category_id;
        if (!$question->save()) {
            \Yii::$app->response->statusCode = 400;
            return $question->errors;
        }
        if (is_array($this->answers)) {
            foreach ($this->answers['title'] as $item) {
                $answer = new TestAnswer();
                $answer->answer = $item;
                $answer->question_id = $question->id;
                $answer->save();
            }
        }

        return $question;
    }

    public function update()
    {
        if (!$this->validate()) {
            return false;
        }
        $question = TestQuestion::findOne($this->id);
        $question->question = $this->question;
        $question->status = $this->status;
        $question->category_id = $this->category_id;
        if (!$question->save()) {
            \Yii::$app->response->statusCode = 400;
            return $question->errors;
        }
        TestAnswer::deleteAll(['question_id' => $question->id]);
        if (is_array($this->answers)) {
            foreach ($this->answers['title'] as $item) {
                $answer = new TestAnswer();
                $answer->answer = $item;
                $answer->question_id = $question->id;
                $answer->save();
            }
        }
        return $question;
    }

}
