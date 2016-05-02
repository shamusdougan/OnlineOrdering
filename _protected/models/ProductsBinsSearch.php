<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProductsBins;

/**
 * ProductsBinsSearch represents the model behind the search form about `app\models\ProductsBins`.
 */
class ProductsBinsSearch extends ProductsBins
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'bin_id', 'location_id', 'order', 'bin_type', 'capacity'], 'integer'],
            [['description', 'name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = ProductsBins::find();

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
            'bin_id' => $this->bin_id,
            'location_id' => $this->location_id,
            'order' => $this->order,
            'bin_type' => $this->bin_type,
            'capacity' => $this->capacity,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
