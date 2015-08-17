<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DeliveryLoad;

/**
 * DeliveryLoadSearch represents the model behind the search form about `app\models\DeliveryLoad`.
 */
class DeliveryLoadSearch extends DeliveryLoad
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'delivery_id', 'trailer_bin_id'], 'integer'],
            [['load_qty'], 'number'],
            [['delivery_on', 'delivery_completed_on'], 'safe'],
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
        $query = DeliveryLoad::find();

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
            'delivery_id' => $this->delivery_id,
            'load_qty' => $this->load_qty,
            'trailer_bin_id' => $this->trailer_bin_id,
            'delivery_on' => $this->delivery_on,
            'delivery_completed_on' => $this->delivery_completed_on,
        ]);

        return $dataProvider;
    }
}
