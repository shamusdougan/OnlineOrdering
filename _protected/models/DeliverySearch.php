<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Delivery;

/**
 * DeliverySearch represents the model behind the search form about `app\models\Delivery`.
 */
class DeliverySearch extends Delivery
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['weigh_bridge_ticket', 'weighed_by', 'delivery_on', 'delivery_completed_on', 'status'], 'safe'],
            [['delivery_qty'], 'number'],
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
        $query = Delivery::find();

      	return $this->dataQuery($params, $query);
    }
    
    public function getDashboardDeliveries()
    {
		$query =  Delivery::find()
			->where(['delivery_on' => date("Y-m-d")]);

		return $this->dataQuery(null, $query);
	}
    
    public function dataQuery($params, $query)
    	{
		
		$dataProvider = new ActiveDataProvider([
        	'query' => $query,
        	]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


		//change the filter date tot the correct format fort he SQL execution statement
		$filterDeliveryOnDate = "";
		if($this->delivery_on != "")
			{
			$filterDeliveryOnDate = date("Y-m-d", strtotime($this->delivery_on));
			}

        $query->andFilterWhere([
            'id' => $this->id,
            'delivery_qty' => $this->delivery_qty,
            'delivery_on' => $filterDeliveryOnDate,
            'delivery_completed_on' => $this->delivery_completed_on,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'weigh_bridge_ticket', $this->weigh_bridge_ticket])
            ->andFilterWhere(['like', 'weighed_by', $this->weighed_by]);

        return $dataProvider;
		}
}
