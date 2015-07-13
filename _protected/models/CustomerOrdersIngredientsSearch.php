<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CustomerOrdersIngredients;

/**
 * CustomerOrdersIngredientsSearch represents the model behind the search form about `app\models\CustomerOrdersIngredients`.
 */
class CustomerOrdersIngredientsSearch extends CustomerOrdersIngredients
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category', 'ingredient_id', 'modified_by', 'order_id'], 'integer'],
            [['created_on', 'modified_on'], 'safe'],
            [['ingredient_percent'], 'number'],
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
        $query = CustomerOrdersIngredients::find();

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
            'created_on' => $this->created_on,
            'category' => $this->category,
            'ingredient_id' => $this->ingredient_id,
            'ingredient_percent' => $this->ingredient_percent,
            'modified_by' => $this->modified_by,
            'modified_on' => $this->modified_on,
            'order_id' => $this->order_id,
        ]);

        return $dataProvider;
    }
}
