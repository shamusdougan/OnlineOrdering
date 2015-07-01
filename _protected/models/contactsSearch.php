<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\contacts;

/**
 * contactsSearch represents the model behind the search form about `app\models\contacts`.
 */
class contactsSearch extends contacts
{
    
    public $company;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['Business_Phone', 'Address_1', 'Address_1_CountryRegion', 'Address_1_Postal_Code', 'Address_1_StateProvince', 'Address_1_Street_1', 'Address_1_Street_2', 'Address_1_TownSuburbCity', 'Email', 'Fax', 'First_Name', 'Job_Title', 'Last_Name', 'Mobile_Phone'], 'safe'],
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
        $query = contacts::find();
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
        ]);

        $query->andFilterWhere(['like', 'Business_Phone', $this->Business_Phone])
            ->andFilterWhere(['like', 'Address_1', $this->Address_1])
            ->andFilterWhere(['like', 'Address_1_CountryRegion', $this->Address_1_CountryRegion])
            ->andFilterWhere(['like', 'Address_1_Postal_Code', $this->Address_1_Postal_Code])
            ->andFilterWhere(['like', 'Address_1_StateProvince', $this->Address_1_StateProvince])
            ->andFilterWhere(['like', 'Address_1_Street_1', $this->Address_1_Street_1])
            ->andFilterWhere(['like', 'Address_1_Street_2', $this->Address_1_Street_2])
            ->andFilterWhere(['like', 'Address_1_TownSuburbCity', $this->Address_1_TownSuburbCity])
            ->andFilterWhere(['like', 'Email', $this->Email])
            ->andFilterWhere(['like', 'Fax', $this->Fax])
            ->andFilterWhere(['like', 'First_Name', $this->First_Name])
            ->andFilterWhere(['like', 'Job_Title', $this->Job_Title])
            ->andFilterWhere(['like', 'Last_Name', $this->Last_Name])
            ->andFilterWhere(['like', 'Mobile_Phone', $this->Mobile_Phone])
            ->andFilterWhere(['like', 'clients.Company_Name', $this->company]);


        return $dataProvider;
    }
}
