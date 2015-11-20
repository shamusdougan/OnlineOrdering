<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WeighbridgeTicket;
use app\models\Trucks;

/**
 * WeighbridgeTicketSearch represents the model behind the search form about `app\models\WeighbridgeTicket`.
 */
class WeighbridgeTicketSearch extends WeighbridgeTicket
{
	
	
	//ChildObject Fakeouts
	public function attributes()
	{
		  return array_merge(parent::attributes(), ['truck.registration']);
	}
	
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'delivery_id', 'truck_id'], 'integer'],
            [['date', 'driver', 'Notes'], 'safe'],
            [['gross', 'tare', 'net', 'Moisture', 'Protein', 'testWeight', 'screenings'], 'number'],
            [['truck.registration'], 'safe'],
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
        $query = WeighbridgeTicket::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


		//$query->joinWith(['Trucks']); 

		$filterOnDate = "";
		if($this->date != "")
			{
			$filterOnDate = date("Y-m-d", strtotime($this->date));
			}

        $query->andFilterWhere([
            'id' => $this->id,
            'delivery_id' => $this->delivery_id,
            'truck_id' => $this->truck_id,
            'date' => $filterOnDate,
            'gross' => $this->gross,
            'tare' => $this->tare,
            'net' => $this->net,
            'Moisture' => $this->Moisture,
            'Protein' => $this->Protein,
            'testWeight' => $this->testWeight,
            'screenings' => $this->screenings,
        ]);

        $query->andFilterWhere(['like', 'driver', $this->driver])
            ->andFilterWhere(['like', 'Notes', $this->Notes]);
			//->andFilterWhere(['like', 'truck.registration', $this->getAttribute('truck.registration')]);

        return $dataProvider;
    }
}
