<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Storage;

/**
 * StorageSearch represents the model behind the search form about `app\models\Storage`.
 */
class StorageSearch extends Storage
{
	
	
	
	 public $company;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'Status'], 'integer'],
            [['Description', 'Delivery_Instructions', 'Postcode', 'Street_1', 'SuburbTown'], 'safe'],
            [['Capacity'], 'number'],
            [['Auger', 'Blower', 'Tipper'], 'boolean'],
            [['company'], 'safe']
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
        $query = Storage::find();
        $query->joinWith(['company']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

		$dataProvider->sort->attributes['company'] =
 			[
 			'asc' => ['clients.Company_Name' => SORT_ASC],
      		'desc' => ['clients.Company_Name' => SORT_DESC],
 			];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'Capacity' => $this->Capacity,
            'Auger' => $this->Auger,
            'Blower' => $this->Blower,
            'Status' => $this->Status,
            'Tipper' => $this->Tipper,
        ]);

        $query->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'Delivery_Instructions', $this->Delivery_Instructions])
            ->andFilterWhere(['like', 'Postcode', $this->Postcode])
            ->andFilterWhere(['like', 'Street_1', $this->Street_1])
            ->andFilterWhere(['like', 'SuburbTown', $this->SuburbTown])
            ->andFilterWhere(['like', 'clients.Company_Name', $this->company]);

        return $dataProvider;
    }
}
