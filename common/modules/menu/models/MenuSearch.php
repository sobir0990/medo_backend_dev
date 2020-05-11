<?php

namespace common\modules\menu\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

use common\modules\menu\models\Menu;

/**
 * MenuSearch represents the model behind the search form of `common\modules\menu\models\Menu`.
 */
class MenuSearch extends Menu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [["menu_id","title","type","lang_hash","lang",],'safe']
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
                    "menu_id","title","type","lang_hash","lang",                ],
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
        $query = Menu::find();

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
            'menu_id' => $this->menu_id,
            'type' => $this->type,
            'lang' => $this->lang,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'lang_hash', $this->lang_hash]);

        return $dataProvider;
    }
}
