<?php

namespace common\modules\settings\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

use common\modules\settings\models\Values;

/**
 * ValuesSearch represents the model behind the search form of `common\modules\settings\models\Values`.
 */
class ValuesSearch extends Values
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [["value_id","type","value",],'safe']
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
"value_id","type","value",                ],
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
        $query = Values::find();

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
            'value_id' => $this->value_id,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['ilike', 'value', $this->value]);

        return $dataProvider;
    }
}
