<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\trailers;

/**
 * trailersSearch represents the model behind the search form about `app\models\trailers`.
 */
class trailersSearch extends trailers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Max_Capacity', 'NumBins', 'Auger', 'Blower', 'Tipper', 'Status'], 'integer'],
            [['Registration', 'Description'], 'safe'],
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
        $query = trailers::find();

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
            'Max_Capacity' => $this->Max_Capacity,
            'NumBins' => $this->NumBins,
            'Auger' => $this->Auger,
            'Blower' => $this->Blower,
            'Tipper' => $this->Tipper,
            'Status' => $this->Status,
        ]);

        $query->andFilterWhere(['like', 'Registration', $this->Registration])
            ->andFilterWhere(['like', 'Description', $this->Description]);

        return $dataProvider;
    }
}
