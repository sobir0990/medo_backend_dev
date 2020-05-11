<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Vacation;

/**
 * VacationSearch represents the model behind the search form of `common\models\Vacation`.
 */
class VacationSearch extends Vacation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','salary', 'salary_type', 'type', 'status', 'phone_view', 'view', 'created_at', 'updated_at', 'place_id'], 'integer'],
            [['title', 'text', 'files', 'phone', 'experience', 'address','profile_id','company_id', 'category_id'], 'safe'],
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
        $query = Vacation::find()->joinWith('profile')->joinWith('company')->joinWith('categories');

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
            'salary' => $this->salary,
            'salary_type' => $this->salary_type,
            'type' => $this->type,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'categories.id' => $this->category_id,
            'place_id' => $this->place_id,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'text', $this->text])
            ->andFilterWhere(['ilike', 'files', $this->files])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'company.name', $this->company_id])
            ->andFilterWhere(['ilike', 'profile.first_name', $this->profile_id])
            ->andFilterWhere(['ilike', 'experience', $this->experience])
            ->andFilterWhere(['ilike', 'address', $this->address]);

        return $dataProvider;
    }
}
