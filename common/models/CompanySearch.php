<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Company;

/**
 * CompanySearch represents the model behind the search form of `common\models\Company`.
 */
class CompanySearch extends Company
{
    public $region_id;
    public $category_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'profile_id', 'type', 'status', 'created_at', 'updated_at', 'city_id', 'region_id'], 'integer'],
            [['name_ru', 'name_uz', 'image', 'description_uz', 'description_ru', 'phone', 'address', 'category_id'], 'safe'],
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
        $query = Company::find();

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
            'profile_id' => $this->profile_id,
            'type' => $this->type,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'categories.id' => $this->category_id,
            'city.id' => $this->city_id,
            'city.region_id' => $this->region_id,
        ]);

        $query->andFilterWhere(['ilike', '"company".name_uz', $this->name_uz])
            ->andFilterWhere(['ilike', '"company".name_ru', $this->name_ru])
            ->andFilterWhere(['ilike', 'description_uz', $this->description_uz])
            ->andFilterWhere(['ilike', 'description_ru', $this->description_ru])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'address', $this->address]);

        return $dataProvider;
    }
}
