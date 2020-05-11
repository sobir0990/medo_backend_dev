<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Encyclopedia;

/**
 * EncyclopediaSearch represents the model behind the search form of `common\models\Encyclopedia`.
 */
class EncyclopediaSearch extends Encyclopedia
{
    public $category_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'author_id', 'lang', 'created_at', 'updated_at', 'type', 'status', 'publish_time', 'top', 'view'], 'integer'],
            [['title', 'slug', 'description', 'text', 'lang_hash', 'files', 'letter', 'category_id',], 'safe'],
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
        $query = Encyclopedia::find();

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
            'author_id' => $this->author_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type' => $this->type,
            'status' => $this->status,
            'publish_time' => $this->publish_time,
            'top' => $this->top,
            'view' => $this->view,
            'categories.id' => $this->category_id,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', '"encyclopedia".slug', $this->slug])
            ->andFilterWhere(['ilike', 'description', $this->description])
            ->andFilterWhere(['ilike', 'text', $this->text])
            ->andFilterWhere(['ilike', 'lang_hash', $this->lang_hash])
            ->andFilterWhere(['ilike', 'files', $this->files])
            ->andFilterWhere(['ilike', 'letter', $this->letter]);

        return $dataProvider;
    }
}
