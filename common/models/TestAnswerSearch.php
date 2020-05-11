<?php

namespace common\models;

use common\modules\langs\components\Lang;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TestQuestionSearch represents the model behind the search form of `common\models\TestQuestion`.
 */
class TestAnswerSearch extends TestAnswer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['answer'], 'string'],
            [['question_id', 'correct', 'status'], 'integer'],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => TestQuestion::class, 'targetAttribute' => ['question_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TestAnswer::find()
            ->andWhere(['lang' => Lang::getLangId()]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'answer' => $this->answer,
            'question_id' => $this->question_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'answer', $this->answer]);
        return $dataProvider;
    }
}
