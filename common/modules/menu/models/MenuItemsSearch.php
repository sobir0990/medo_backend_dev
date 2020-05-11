<?php

namespace common\modules\menu\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

use common\modules\menu\models\MenuItems;

/**
 * MenuItemsSearch represents the model behind the search form of `common\modules\menu\models\MenuItems`.
 */
class MenuItemsSearch extends MenuItems
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [["menu_item_id","menu_id","title","url","sort","menu_item_parent_id",],'safe']
              ];
    }

    public function init()
    {
        parent::init();
        $this->setScenario(self::SCENARIO_SEARCH);
    }
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return ArrayHelper::merge(Model::scenarios(),[
                self::SCENARIO_SEARCH => [
                    "menu_item_id","menu_id","title","url","sort","menu_item_parent_id",                ],
        ]);
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
        $query = MenuItems::find();

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
            'menu_item_id' => $this->menu_item_id,
            'menu_id' => $this->menu_id,
            'sort' => $this->sort,
            'menu_item_parent_id' => $this->menu_item_parent_id,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'url', $this->url]);

        return $dataProvider;
    }
}
