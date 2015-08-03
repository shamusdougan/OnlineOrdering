<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\trucks;

/**
 * trucksSearch represents the model behind the search form about `app\models\trucks`.
 */
class trucksSearch extends trucks
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'CreatedBy', 'defaultTrailer', 'Status', 'Auger', 'Blower', 'Tipper'], 'integer'],
            [['registration', 'description', 'SpecialInstruction'], 'safe'],
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
        $query = trucks::find();

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
            'CreatedBy' => $this->CreatedBy,
            'defaultTrailer' => $this->defaultTrailer,
            'Status' => $this->Status,
            'Auger' => $this->Auger,
            'Blower' => $this->Blower,
            'Tipper' => $this->Tipper,
        ]);

        $query->andFilterWhere(['like', 'registration', $this->registration])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'SpecialInstruction', $this->SpecialInstruction]);

        return $dataProvider;
    }
}
