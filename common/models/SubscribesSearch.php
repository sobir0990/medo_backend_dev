<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CitySearch represents the model behind the search form of `common\models\City`.
 */
class SubscribesSearch extends Subscribes
{
	/**
	 * {@inheritdoc}
	 */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['status'], 'default', 'value' => 1],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 128],
            ['email', 'unique'],
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
		$query = Subscribes::find();

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
			'status' => $this->status,
		]);

		$query->andFilterWhere(['like', 'email', $this->email]);

		return $dataProvider;
	}
}
