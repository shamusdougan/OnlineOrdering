<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\clients;

/**
 * clientsSearch represents the model behind the search form about `app\models\clients`.
 */
class clientsSearch extends clients
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Fax', 'Address_1_Address_Type', 'Address_1_Postal_Code', 'Address_2_Address_Type', 'Address_2_Postal_Code', 'Billing_contact', 'Billing_type', 'Business_Type', 'Client_Status', 'Created_By', 'Dairy_No', 'Exchange_Rate', 'Farm_Operation', 'Feed_Days_Remaining', 'Feed_QOH_Tonnes', 'Herd_Size', 'Herd_Type', 'Modified_By', 'No_of_Employees', 'Owner', 'Status'], 'integer'],
            [['Company_Name', 'Account_Number', 'Main_Phone', '3rd_Party_Company', 'ABN', 'Address_1', 'Address_1_CountryRegion', 'Address_1_StateProvince', 'Address_1_Street_1', 'Address_1_Street_2', 'Address_1_Street_3', 'Address_1_Telephone_2', 'Address_1_Telephone_3', 'Address_2', 'Address_2_CountryRegion', 'Address_2_StateProvince', 'Address_2_Street_1', 'Address_2_Street_2', 'Address_2_Street_3', 'Address_2_Telephone_1', 'Address_2_Telephone_2', 'Address_2_Telephone_3', 'Address_2_TownSuburb', 'Address_Phone', 'Billing_company_admin_fee', 'Billing_company_admin_fee_Base', 'Category', 'Copy_addess', 'Copy_address', 'Created_On', 'Dairy_Notes', 'Delivery_Directions', 'Description', 'Email', 'Email_Address_2', 'Email_Address_3', 'Farm_Mgr', 'Farm_No', 'Feed_empty', 'Feed_QOH_Update', 'Herd_Notes', 'Main_Competitor', 'Map_Reference', 'Mobile_Phone', 'Modified_On', 'Nearest_Town', 'Parent_Region', 'Payment_Terms', 'Preferred_Day', 'Preferred_FacilityEquipment', 'Property_Name', 'Sub_Region', 'Supplies_to', 'Trading_as', 'Website'], 'safe'],
            [['Is_Customer', 'Is_Factory', 'Is_Supplier', 'Address1_IsBillTo', 'Address1_IsShipTo', 'Credit_Hold', 'Do_not_allow_Bulk_Emails', 'Do_not_allow_Bulk_Mails', 'Do_not_allow_Emails', 'Do_not_allow_Faxes', 'Do_not_allow_Mails', 'Do_not_allow_Phone_Calls', 'Is_Internal', 'Is_Provider'], 'boolean'],
            [['Feed_Rate_Kg_Day'], 'number'],
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
        $query = clients::find();

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
            'Fax' => $this->Fax,
            'Is_Customer' => $this->Is_Customer,
            'Is_Factory' => $this->Is_Factory,
            'Is_Supplier' => $this->Is_Supplier,
            'Address_1_Address_Type' => $this->Address_1_Address_Type,
            'Address_1_Postal_Code' => $this->Address_1_Postal_Code,
            'Address_2_Address_Type' => $this->Address_2_Address_Type,
            'Address_2_Postal_Code' => $this->Address_2_Postal_Code,
            'Address1_IsBillTo' => $this->Address1_IsBillTo,
            'Address1_IsShipTo' => $this->Address1_IsShipTo,
            'Billing_contact' => $this->Billing_contact,
            'Billing_type' => $this->Billing_type,
            'Business_Type' => $this->Business_Type,
            'Client_Status' => $this->Client_Status,
            'Created_By' => $this->Created_By,
            'Created_On' => $this->Created_On,
            'Credit_Hold' => $this->Credit_Hold,
            'Dairy_No' => $this->Dairy_No,
            'Do_not_allow_Bulk_Emails' => $this->Do_not_allow_Bulk_Emails,
            'Do_not_allow_Bulk_Mails' => $this->Do_not_allow_Bulk_Mails,
            'Do_not_allow_Emails' => $this->Do_not_allow_Emails,
            'Do_not_allow_Faxes' => $this->Do_not_allow_Faxes,
            'Do_not_allow_Mails' => $this->Do_not_allow_Mails,
            'Do_not_allow_Phone_Calls' => $this->Do_not_allow_Phone_Calls,
            'Exchange_Rate' => $this->Exchange_Rate,
            'Farm_Operation' => $this->Farm_Operation,
            'Feed_Days_Remaining' => $this->Feed_Days_Remaining,
            'Feed_empty' => $this->Feed_empty,
            'Feed_QOH_Tonnes' => $this->Feed_QOH_Tonnes,
            'Feed_QOH_Update' => $this->Feed_QOH_Update,
            'Feed_Rate_Kg_Day' => $this->Feed_Rate_Kg_Day,
            'Herd_Size' => $this->Herd_Size,
            'Herd_Type' => $this->Herd_Type,
            'Is_Internal' => $this->Is_Internal,
            'Is_Provider' => $this->Is_Provider,
            'Modified_By' => $this->Modified_By,
            'Modified_On' => $this->Modified_On,
            'No_of_Employees' => $this->No_of_Employees,
            'Owner' => $this->Owner,
            'Status' => $this->Status,
        ]);

        $query->andFilterWhere(['like', 'Company_Name', $this->Company_Name])
            ->andFilterWhere(['like', 'Account_Number', $this->Account_Number])
            ->andFilterWhere(['like', 'Main_Phone', $this->Main_Phone])
            ->andFilterWhere(['like', 'ABN', $this->ABN])
            ->andFilterWhere(['like', 'Address_1', $this->Address_1])
            ->andFilterWhere(['like', 'Address_1_CountryRegion', $this->Address_1_CountryRegion])
            ->andFilterWhere(['like', 'Address_1_StateProvince', $this->Address_1_StateProvince])
            ->andFilterWhere(['like', 'Address_1_Street_1', $this->Address_1_Street_1])
            ->andFilterWhere(['like', 'Address_1_Street_2', $this->Address_1_Street_2])
            ->andFilterWhere(['like', 'Address_1_Street_3', $this->Address_1_Street_3])
            ->andFilterWhere(['like', 'Address_1_Telephone_2', $this->Address_1_Telephone_2])
            ->andFilterWhere(['like', 'Address_1_Telephone_3', $this->Address_1_Telephone_3])
            ->andFilterWhere(['like', 'Address_2', $this->Address_2])
            ->andFilterWhere(['like', 'Address_2_CountryRegion', $this->Address_2_CountryRegion])
            ->andFilterWhere(['like', 'Address_2_StateProvince', $this->Address_2_StateProvince])
            ->andFilterWhere(['like', 'Address_2_Street_1', $this->Address_2_Street_1])
            ->andFilterWhere(['like', 'Address_2_Street_2', $this->Address_2_Street_2])
            ->andFilterWhere(['like', 'Address_2_Street_3', $this->Address_2_Street_3])
            ->andFilterWhere(['like', 'Address_2_Telephone_1', $this->Address_2_Telephone_1])
            ->andFilterWhere(['like', 'Address_2_Telephone_2', $this->Address_2_Telephone_2])
            ->andFilterWhere(['like', 'Address_2_Telephone_3', $this->Address_2_Telephone_3])
            ->andFilterWhere(['like', 'Address_2_TownSuburb', $this->Address_2_TownSuburb])
            ->andFilterWhere(['like', 'Address_Phone', $this->Address_Phone])
            ->andFilterWhere(['like', 'Billing_company_admin_fee', $this->Billing_company_admin_fee])
            ->andFilterWhere(['like', 'Billing_company_admin_fee_Base', $this->Billing_company_admin_fee_Base])
            ->andFilterWhere(['like', 'Category', $this->Category])
            ->andFilterWhere(['like', 'Copy_addess', $this->Copy_addess])
            ->andFilterWhere(['like', 'Copy_address', $this->Copy_address])
            ->andFilterWhere(['like', 'Dairy_Notes', $this->Dairy_Notes])
            ->andFilterWhere(['like', 'Delivery_Directions', $this->Delivery_Directions])
            ->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'Email', $this->Email])
            ->andFilterWhere(['like', 'Email_Address_2', $this->Email_Address_2])
            ->andFilterWhere(['like', 'Email_Address_3', $this->Email_Address_3])
            ->andFilterWhere(['like', 'Farm_Mgr', $this->Farm_Mgr])
            ->andFilterWhere(['like', 'Farm_No', $this->Farm_No])
            ->andFilterWhere(['like', 'Herd_Notes', $this->Herd_Notes])
            ->andFilterWhere(['like', 'Main_Competitor', $this->Main_Competitor])
            ->andFilterWhere(['like', 'Map_Reference', $this->Map_Reference])
            ->andFilterWhere(['like', 'Mobile_Phone', $this->Mobile_Phone])
            ->andFilterWhere(['like', 'Nearest_Town', $this->Nearest_Town])
            ->andFilterWhere(['like', 'Parent_Region', $this->Parent_Region])
            ->andFilterWhere(['like', 'Payment_Terms', $this->Payment_Terms])
            ->andFilterWhere(['like', 'Preferred_Day', $this->Preferred_Day])
            ->andFilterWhere(['like', 'Preferred_FacilityEquipment', $this->Preferred_FacilityEquipment])
            ->andFilterWhere(['like', 'Property_Name', $this->Property_Name])
            ->andFilterWhere(['like', 'Sub_Region', $this->Sub_Region])
            ->andFilterWhere(['like', 'Supplies_to', $this->Supplies_to])
            ->andFilterWhere(['like', 'Trading_as', $this->Trading_as])
            ->andFilterWhere(['like', 'Website', $this->Website]);

        return $dataProvider;
    }
}
