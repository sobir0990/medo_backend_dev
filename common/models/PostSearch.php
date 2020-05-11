<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Post;

/**
 * PostSearch represents the model behind the search form of `common\models\Post`.
 */
class PostSearch extends Post
{
    public $category_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lang', 'created_at', 'updated_at', 'type', 'status', 'company_id', 'category_id', 'top', 'tags', 'view'], 'integer'],
            [['title', 'publish_time', 'slug', 'description', 'text', 'lang_hash', 'files','profile_id'], 'safe'],
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
        $query = Post::find()->joinWith('profile')->orderBy('updated_at DESC');
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
            'post.lang' => $this->lang,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type' => $this->type,
            'tags' => $this->tags,
            'status' => $this->status,
            'company_id' => $this->company_id,
            'top' => $this->top,
            'view' => $this->view,
            'categories.id' => $this->category_id,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'slug', $this->slug])
            ->andFilterWhere(['ilike', 'tags', $this->tags])
            ->andFilterWhere(['ilike', 'description', $this->description])
            ->andFilterWhere(['ilike', 'text', $this->text])
            ->andFilterWhere(['ilike', 'lang_hash', $this->lang_hash])
            ->andFilterWhere(['ilike', 'profile.first_name', $this->profile_id])
            ->andFilterWhere(['ilike', 'files', $this->files]);

        return $dataProvider;
    }
}
