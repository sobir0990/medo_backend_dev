<?php


namespace api\modules\v1\forms;


use common\models\FavoriteQuestion;
use common\models\Profile;
use common\models\TestAnswer;
use common\models\TestQuestion;
use common\models\User;
use Yii;
use yii\base\Model;

class QuestionTestForm extends Model
{
    public $id;
    public $user_id;
    public $correct;
    public $question_id;
    public $answer_id;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id', 'question_id'], 'required'],
            [['correct', 'answer_id', 'question_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    public function create()
    {
        $user = User::authorize();


        $model = new FavoriteQuestion();
        $model->question_id = $this->question_id;
        $model->user_id = $user->id;

        $answer = TestAnswer::find()->andWhere(['question_id' => $this->question_id])
            ->andWhere(['correct' => 1])
            ->one();
        if ($answer->id == $this->answer_id) {
            $model->correct = FavoriteQuestion::STATUS_CORRECT;
        } else {
            $model->correct = FavoriteQuestion::STATUS_NO_CORRECT;
        }
        $model->save();

        $count = FavoriteQuestion::find()
            ->andWhere(['user_id' => $user->id])
            ->count();

        if ($count < 5) {
            return $model;
        } elseif ($count == 5) {
            $rating = FavoriteQuestion::find()
                ->andWhere(['user_id' => $user->id])
                ->andWhere(['correct' => FavoriteQuestion::STATUS_CORRECT])
                ->count();

            if ($rating > 3) {
                $user->updateAttributes(['role' => User::ROLE_DOCTOR]);
                $profile = Profile::findOne(['user_id' => $user->id]);
                $profile->updateAttributes(['type' => Profile::TYPE_DOCTOR]);
                $profile->save();
                $delete = FavoriteQuestion::deleteAll(['user_id' => $user->id]);
                return array_merge(['count' => $count, 'correct' => $rating, 'no_correct' => $count - $rating, 'role' => 'Doctor']);
            }
            $delete = FavoriteQuestion::deleteAll(['user_id' => $user->id]);
            return array_merge(['count' => $count, 'correct' => $rating, 'no_correct' => $count - $rating, 'role' => 'User']);
        }

    }

}
