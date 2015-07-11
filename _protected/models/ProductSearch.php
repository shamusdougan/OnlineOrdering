<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

/**
 * ProductSearch represents the model behind the search form about `app\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Product_ID', 'Status', 'Decimals_Supported', 'Default_Unit', 'Mix_Type', 'Product_Category'], 'integer'],
            [['Name', 'Description', 'Feed_notes'], 'safe'],
            [['cp', 'List_Price_pT_Base', 'me', 'Mix_Margin', 'Mix_Margin_Base', 'ndf', 'Retail_Price_t'], 'number'],
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
        $query = Product::find();

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
            'Product_ID' => $this->Product_ID,
            'Status' => $this->Status,
            'cp' => $this->cp,
            'Decimals_Supported' => $this->Decimals_Supported,
            'Default_Unit' => $this->Default_Unit,
            'List_Price_pT_Base' => $this->List_Price_pT_Base,
            'me' => $this->me,
            'Mix_Margin' => $this->Mix_Margin,
            'Mix_Margin_Base' => $this->Mix_Margin_Base,
            'Mix_Type' => $this->Mix_Type,
            'ndf' => $this->ndf,
            'Product_Category' => $this->Product_Category,
            'Retail_Price_t' => $this->Retail_Price_t,
        ]);

        $query->andFilterWhere(['like', 'Name', $this->Name])
            ->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'Feed_notes', $this->Feed_notes]);

        return $dataProvider;
    }
}
