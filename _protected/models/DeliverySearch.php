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
            [['weigh_bridge_ticket', 'weighed_by', 'delivery_on', 'delivery_completed_on'], 'safe'],
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
            'delivery_qty' => $this->delivery_qty,
            'delivery_on' => $this->delivery_on,
            'delivery_completed_on' => $this->delivery_completed_on,
        ]);

        $query->andFilterWhere(['like', 'weigh_bridge_ticket', $this->weigh_bridge_ticket])
            ->andFilterWhere(['like', 'weighed_by', $this->weighed_by]);

        return $dataProvider;
    }
}
