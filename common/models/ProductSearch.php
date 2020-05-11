<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;

/**
 * ProductSearch represents the model behind the search form of `common\models\Product`.
 */
class ProductSearch extends Product
{
    public $region_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'profile_id', 'company_id', 'type', 'status', 'price', 'price_type', 'lang', 'delivery', 'top', 'view', 'view_phone', 'created_at', 'updated_at', 'city_id'], 'integer'],
            [['images', 'title_uz', 'title_ru', 'content_uz', 'content_ru', 'phone', 'files', 'lang_hash', 'address', 'region_id', 'category_id'], 'safe'],
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
        $query = Product::find()->joinWith('categories');

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
            'company_id' => $this->company_id,
            'type' => $this->type,
            'status' => $this->status,
            'price' => $this->price,
            'price_type' => $this->price_type,
            'lang' => $this->lang,
            'delivery' => $this->delivery,
            'top' => $this->top,
            'view' => $this->view,
            'view_phone' => $this->view_phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'city_id' => $this->city_id,
            'city.region_id' => $this->region_id,
            'categories.id' => $this->category_id,
        ]);

        $query->andFilterWhere(['ilike', 'images', $this->images])
            ->andFilterWhere(['ilike', 'title_uz', $this->title_uz])
            ->andFilterWhere(['ilike', 'title_ru', $this->title_ru])
            ->andFilterWhere(['ilike', 'content_uz', $this->content_uz])
            ->andFilterWhere(['ilike', 'content_ru', $this->content_ru])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'address', $this->address]);

        return $dataProvider;
    }
}
