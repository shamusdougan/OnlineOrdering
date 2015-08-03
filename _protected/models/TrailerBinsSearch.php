<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TrailerBins;

/**
 * TrailerBinsSearch represents the model behind the search form about `app\models\TrailerBins`.
 */
class TrailerBinsSearch extends TrailerBins
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'trailer_id', 'MaxCapacity', 'Status'], 'integer'],
            [['BinNo'], 'safe'],
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
        $query = TrailerBins::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'trailer_id' => $this->trailer_id,
            'MaxCapacity' => $this->MaxCapacity,
            'Status' => $this->Status,
        ]);

        $query->andFilterWhere(['like', 'BinNo', $this->BinNo]);

        return $dataProvider;
    }
}
