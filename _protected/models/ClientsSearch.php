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
            [['Company_Name', 'Trading_as', 'Main_Phone', 'TownSuburb', 'Is_Customer', 'Is_Factory', 'Is_Supplier', 'Credit_Hold', 'Owner', 'Account_Number', 'Third_Party_Company', 'ABN', 'Account_Rating', 'Address_1', 'Address_1_Address_Type', 'Address_1_CountryRegion', 'Address_1_County', 'Address_1_Fax', 'Address_1_Freight_Terms', 'Address_1_Latitude', 'Address_1_Longitude', 'Address_1_Name', 'Address_1_Post_Office_Box', 'Address_1_Primary_Contact_Name', 'Address_1_Shipping_Method', 'Address_1_StateProvince', 'Address_1_Street_1', 'Address_1_Street_2', 'Address_1_Street_3', 'Address_1_Telephone_2', 'Address_1_Telephone_3', 'Address_1_UPS_Zone', 'Address_1_UTC_Offset', 'Address_2', 'Address_2_Address_Type', 'Address_2_CountryRegion', 'Address_2_County', 'Address_2_Fax', 'Address_2_Freight_Terms', 'Address_2_Latitude', 'Address_2_Longitude', 'Address_2_Name', 'Address_2_Post_Office_Box', 'Address_2_Primary_Contact_Name', 'Address_2_Shipping_Method', 'Address_2_StateProvince', 'Address_2_Street_1', 'Address_2_Street_2', 'Address_2_Street_3', 'Address_2_Telephone_1', 'Address_2_Telephone_2', 'Address_2_Telephone_3', 'Address_2_TownSuburb', 'Address_2_UPS_Zone', 'Address_2_UTC_Offset', 'Address_Phone', 'Address1_IsBillTo', 'Address1_IsShipTo', 'Aging_30', 'Aging_30_Base', 'Aging_60', 'Aging_60_Base', 'Aging_90', 'Aging_90_Base', 'Annual_Revenue', 'Annual_Revenue_Base', 'Beef_Notes', 'Billing_company_admin_fee', 'Billing_company_admin_fee_Base', 'Billing_contact', 'Billing_type', 'Business_Type', 'Category', 'Classification', 'Client_Status', 'Copy_addess', 'Copy_address', 'Created_By', 'Created_By_Delegate', 'Created_On', 'Credit_Limit', 'Credit_Limit_Base', 'Currency', 'Customer_Size', 'Dairy_Notes', 'Delivery_Directions', 'Description', 'Do_not_allow_Bulk_Emails', 'Do_not_allow_Bulk_Mails', 'Do_not_allow_Emails', 'Do_not_allow_Faxes', 'Do_not_allow_Mails', 'Do_not_allow_Phone_Calls', 'Email', 'Email_Address_2', 'Email_Address_3', 'Farm_Mgr', 'Farm_No', 'Farm_Operation', 'Feed_empty', 'Feed_QOH_Update', 'FTP_Site', 'Herd_Notes', 'Herd_Type', 'Industry_Code', 'Is_Internal', 'Is_Provider', 'Last_Date_Included_in_Campaign', 'Main_Competitor', 'Main_Product', 'Map_Reference', 'Market_Capitalization', 'Market_Capitalization_Base', 'Mobile_Phone', 'Modified_By', 'Modified_By_Delegate', 'Modified_On', 'Nearest_Town', 'No_of_Employees', 'Originating_Lead', 'Other_Phone', 'Ownership', 'Parent_Company', 'Parent_Region', 'Payment_Terms', 'Preferred_Day', 'Preferred_FacilityEquipment', 'Preferred_Method_of_Contact', 'Preferred_Service', 'Preferred_Time', 'Preferred_User', 'Price_List', 'Primary_Contact', 'Process', 'Process_Stage', 'Property_Name', 'Record_Created_On', 'Relationship_Type', 'Send_Marketing_Materials', 'Shares_Outstanding', 'Shipping_Method', 'SIC_Code', 'Status', 'Status_Reason', 'Stock_Exchange', 'Sub_Region', 'Supplies_to', 'Telephone_3', 'Territory', 'Territory_Code', 'Ticker_Symbol', 'Website', 'Yomi_Account_Name', 'z_old_Industry', 'z_old_Payment_Terms'], 'safe'],
            [['Address_1_Postal_Code', 'Address_2_Postal_Code', 'Dairy_No', 'Fax', 'Feed_Days_Remaining', 'Herd_Size'], 'integer'],
            [['Exchange_Rate', 'Feed_QOH_Tonnes', 'Feed_Rate_Kg_Day'], 'number'],
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
            'Address_1_Postal_Code' => $this->Address_1_Postal_Code,
            'Address_2_Postal_Code' => $this->Address_2_Postal_Code,
            'Dairy_No' => $this->Dairy_No,
            'Exchange_Rate' => $this->Exchange_Rate,
            'Fax' => $this->Fax,
            'Feed_Days_Remaining' => $this->Feed_Days_Remaining,
            'Feed_empty' => $this->Feed_empty,
            'Feed_QOH_Tonnes' => $this->Feed_QOH_Tonnes,
            'Feed_QOH_Update' => $this->Feed_QOH_Update,
            'Feed_Rate_Kg_Day' => $this->Feed_Rate_Kg_Day,
            'Herd_Size' => $this->Herd_Size,
        ]);

        $query->andFilterWhere(['like', 'Company_Name', $this->Company_Name])
            ->andFilterWhere(['like', 'Trading_as', $this->Trading_as])
            ->andFilterWhere(['like', 'Main_Phone', $this->Main_Phone])
            ->andFilterWhere(['like', 'TownSuburb', $this->TownSuburb])
            ->andFilterWhere(['like', 'Is_Customer', $this->Is_Customer])
            ->andFilterWhere(['like', 'Is_Factory', $this->Is_Factory])
            ->andFilterWhere(['like', 'Is_Supplier', $this->Is_Supplier])
            ->andFilterWhere(['like', 'Credit_Hold', $this->Credit_Hold])
            ->andFilterWhere(['like', 'Owner', $this->Owner])
            ->andFilterWhere(['like', 'Account_Number', $this->Account_Number])
            ->andFilterWhere(['like', 'Third_Party_Company', $this->Third_Party_Company])
            ->andFilterWhere(['like', 'ABN', $this->ABN])
            ->andFilterWhere(['like', 'Account_Rating', $this->Account_Rating])
            ->andFilterWhere(['like', 'Address_1', $this->Address_1])
            ->andFilterWhere(['like', 'Address_1_Address_Type', $this->Address_1_Address_Type])
            ->andFilterWhere(['like', 'Address_1_CountryRegion', $this->Address_1_CountryRegion])
            ->andFilterWhere(['like', 'Address_1_County', $this->Address_1_County])
            ->andFilterWhere(['like', 'Address_1_Fax', $this->Address_1_Fax])
            ->andFilterWhere(['like', 'Address_1_Freight_Terms', $this->Address_1_Freight_Terms])
            ->andFilterWhere(['like', 'Address_1_Latitude', $this->Address_1_Latitude])
            ->andFilterWhere(['like', 'Address_1_Longitude', $this->Address_1_Longitude])
            ->andFilterWhere(['like', 'Address_1_Name', $this->Address_1_Name])
            ->andFilterWhere(['like', 'Address_1_Post_Office_Box', $this->Address_1_Post_Office_Box])
            ->andFilterWhere(['like', 'Address_1_Primary_Contact_Name', $this->Address_1_Primary_Contact_Name])
            ->andFilterWhere(['like', 'Address_1_Shipping_Method', $this->Address_1_Shipping_Method])
            ->andFilterWhere(['like', 'Address_1_StateProvince', $this->Address_1_StateProvince])
            ->andFilterWhere(['like', 'Address_1_Street_1', $this->Address_1_Street_1])
            ->andFilterWhere(['like', 'Address_1_Street_2', $this->Address_1_Street_2])
            ->andFilterWhere(['like', 'Address_1_Street_3', $this->Address_1_Street_3])
            ->andFilterWhere(['like', 'Address_1_Telephone_2', $this->Address_1_Telephone_2])
            ->andFilterWhere(['like', 'Address_1_Telephone_3', $this->Address_1_Telephone_3])
            ->andFilterWhere(['like', 'Address_1_UPS_Zone', $this->Address_1_UPS_Zone])
            ->andFilterWhere(['like', 'Address_1_UTC_Offset', $this->Address_1_UTC_Offset])
            ->andFilterWhere(['like', 'Address_2', $this->Address_2])
            ->andFilterWhere(['like', 'Address_2_Address_Type', $this->Address_2_Address_Type])
            ->andFilterWhere(['like', 'Address_2_CountryRegion', $this->Address_2_CountryRegion])
            ->andFilterWhere(['like', 'Address_2_County', $this->Address_2_County])
            ->andFilterWhere(['like', 'Address_2_Fax', $this->Address_2_Fax])
            ->andFilterWhere(['like', 'Address_2_Freight_Terms', $this->Address_2_Freight_Terms])
            ->andFilterWhere(['like', 'Address_2_Latitude', $this->Address_2_Latitude])
            ->andFilterWhere(['like', 'Address_2_Longitude', $this->Address_2_Longitude])
            ->andFilterWhere(['like', 'Address_2_Name', $this->Address_2_Name])
            ->andFilterWhere(['like', 'Address_2_Post_Office_Box', $this->Address_2_Post_Office_Box])
            ->andFilterWhere(['like', 'Address_2_Primary_Contact_Name', $this->Address_2_Primary_Contact_Name])
            ->andFilterWhere(['like', 'Address_2_Shipping_Method', $this->Address_2_Shipping_Method])
            ->andFilterWhere(['like', 'Address_2_StateProvince', $this->Address_2_StateProvince])
            ->andFilterWhere(['like', 'Address_2_Street_1', $this->Address_2_Street_1])
            ->andFilterWhere(['like', 'Address_2_Street_2', $this->Address_2_Street_2])
            ->andFilterWhere(['like', 'Address_2_Street_3', $this->Address_2_Street_3])
            ->andFilterWhere(['like', 'Address_2_Telephone_1', $this->Address_2_Telephone_1])
            ->andFilterWhere(['like', 'Address_2_Telephone_2', $this->Address_2_Telephone_2])
            ->andFilterWhere(['like', 'Address_2_Telephone_3', $this->Address_2_Telephone_3])
            ->andFilterWhere(['like', 'Address_2_TownSuburb', $this->Address_2_TownSuburb])
            ->andFilterWhere(['like', 'Address_2_UPS_Zone', $this->Address_2_UPS_Zone])
            ->andFilterWhere(['like', 'Address_2_UTC_Offset', $this->Address_2_UTC_Offset])
            ->andFilterWhere(['like', 'Address_Phone', $this->Address_Phone])
            ->andFilterWhere(['like', 'Address1_IsBillTo', $this->Address1_IsBillTo])
            ->andFilterWhere(['like', 'Address1_IsShipTo', $this->Address1_IsShipTo])
            ->andFilterWhere(['like', 'Aging_30', $this->Aging_30])
            ->andFilterWhere(['like', 'Aging_30_Base', $this->Aging_30_Base])
            ->andFilterWhere(['like', 'Aging_60', $this->Aging_60])
            ->andFilterWhere(['like', 'Aging_60_Base', $this->Aging_60_Base])
            ->andFilterWhere(['like', 'Aging_90', $this->Aging_90])
            ->andFilterWhere(['like', 'Aging_90_Base', $this->Aging_90_Base])
            ->andFilterWhere(['like', 'Annual_Revenue', $this->Annual_Revenue])
            ->andFilterWhere(['like', 'Annual_Revenue_Base', $this->Annual_Revenue_Base])
            ->andFilterWhere(['like', 'Beef_Notes', $this->Beef_Notes])
            ->andFilterWhere(['like', 'Billing_company_admin_fee', $this->Billing_company_admin_fee])
            ->andFilterWhere(['like', 'Billing_company_admin_fee_Base', $this->Billing_company_admin_fee_Base])
            ->andFilterWhere(['like', 'Billing_contact', $this->Billing_contact])
            ->andFilterWhere(['like', 'Billing_type', $this->Billing_type])
            ->andFilterWhere(['like', 'Business_Type', $this->Business_Type])
            ->andFilterWhere(['like', 'Category', $this->Category])
            ->andFilterWhere(['like', 'Classification', $this->Classification])
            ->andFilterWhere(['like', 'Client_Status', $this->Client_Status])
            ->andFilterWhere(['like', 'Copy_addess', $this->Copy_addess])
            ->andFilterWhere(['like', 'Copy_address', $this->Copy_address])
            ->andFilterWhere(['like', 'Created_By', $this->Created_By])
            ->andFilterWhere(['like', 'Created_By_Delegate', $this->Created_By_Delegate])
            ->andFilterWhere(['like', 'Created_On', $this->Created_On])
            ->andFilterWhere(['like', 'Credit_Limit', $this->Credit_Limit])
            ->andFilterWhere(['like', 'Credit_Limit_Base', $this->Credit_Limit_Base])
            ->andFilterWhere(['like', 'Currency', $this->Currency])
            ->andFilterWhere(['like', 'Customer_Size', $this->Customer_Size])
            ->andFilterWhere(['like', 'Dairy_Notes', $this->Dairy_Notes])
            ->andFilterWhere(['like', 'Delivery_Directions', $this->Delivery_Directions])
            ->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'Do_not_allow_Bulk_Emails', $this->Do_not_allow_Bulk_Emails])
            ->andFilterWhere(['like', 'Do_not_allow_Bulk_Mails', $this->Do_not_allow_Bulk_Mails])
            ->andFilterWhere(['like', 'Do_not_allow_Emails', $this->Do_not_allow_Emails])
            ->andFilterWhere(['like', 'Do_not_allow_Faxes', $this->Do_not_allow_Faxes])
            ->andFilterWhere(['like', 'Do_not_allow_Mails', $this->Do_not_allow_Mails])
            ->andFilterWhere(['like', 'Do_not_allow_Phone_Calls', $this->Do_not_allow_Phone_Calls])
            ->andFilterWhere(['like', 'Email', $this->Email])
            ->andFilterWhere(['like', 'Email_Address_2', $this->Email_Address_2])
            ->andFilterWhere(['like', 'Email_Address_3', $this->Email_Address_3])
            ->andFilterWhere(['like', 'Farm_Mgr', $this->Farm_Mgr])
            ->andFilterWhere(['like', 'Farm_No', $this->Farm_No])
            ->andFilterWhere(['like', 'Farm_Operation', $this->Farm_Operation])
            ->andFilterWhere(['like', 'FTP_Site', $this->FTP_Site])
            ->andFilterWhere(['like', 'Herd_Notes', $this->Herd_Notes])
            ->andFilterWhere(['like', 'Herd_Type', $this->Herd_Type])
            ->andFilterWhere(['like', 'Industry_Code', $this->Industry_Code])
            ->andFilterWhere(['like', 'Is_Internal', $this->Is_Internal])
            ->andFilterWhere(['like', 'Is_Provider', $this->Is_Provider])
            ->andFilterWhere(['like', 'Last_Date_Included_in_Campaign', $this->Last_Date_Included_in_Campaign])
            ->andFilterWhere(['like', 'Main_Competitor', $this->Main_Competitor])
            ->andFilterWhere(['like', 'Main_Product', $this->Main_Product])
            ->andFilterWhere(['like', 'Map_Reference', $this->Map_Reference])
            ->andFilterWhere(['like', 'Market_Capitalization', $this->Market_Capitalization])
            ->andFilterWhere(['like', 'Market_Capitalization_Base', $this->Market_Capitalization_Base])
            ->andFilterWhere(['like', 'Mobile_Phone', $this->Mobile_Phone])
            ->andFilterWhere(['like', 'Modified_By', $this->Modified_By])
            ->andFilterWhere(['like', 'Modified_By_Delegate', $this->Modified_By_Delegate])
            ->andFilterWhere(['like', 'Modified_On', $this->Modified_On])
            ->andFilterWhere(['like', 'Nearest_Town', $this->Nearest_Town])
            ->andFilterWhere(['like', 'No_of_Employees', $this->No_of_Employees])
            ->andFilterWhere(['like', 'Originating_Lead', $this->Originating_Lead])
            ->andFilterWhere(['like', 'Other_Phone', $this->Other_Phone])
            ->andFilterWhere(['like', 'Ownership', $this->Ownership])
            ->andFilterWhere(['like', 'Parent_Company', $this->Parent_Company])
            ->andFilterWhere(['like', 'Parent_Region', $this->Parent_Region])
            ->andFilterWhere(['like', 'Payment_Terms', $this->Payment_Terms])
            ->andFilterWhere(['like', 'Preferred_Day', $this->Preferred_Day])
            ->andFilterWhere(['like', 'Preferred_FacilityEquipment', $this->Preferred_FacilityEquipment])
            ->andFilterWhere(['like', 'Preferred_Method_of_Contact', $this->Preferred_Method_of_Contact])
            ->andFilterWhere(['like', 'Preferred_Service', $this->Preferred_Service])
            ->andFilterWhere(['like', 'Preferred_Time', $this->Preferred_Time])
            ->andFilterWhere(['like', 'Preferred_User', $this->Preferred_User])
            ->andFilterWhere(['like', 'Price_List', $this->Price_List])
            ->andFilterWhere(['like', 'Primary_Contact', $this->Primary_Contact])
            ->andFilterWhere(['like', 'Process', $this->Process])
            ->andFilterWhere(['like', 'Process_Stage', $this->Process_Stage])
            ->andFilterWhere(['like', 'Property_Name', $this->Property_Name])
            ->andFilterWhere(['like', 'Record_Created_On', $this->Record_Created_On])
            ->andFilterWhere(['like', 'Relationship_Type', $this->Relationship_Type])
            ->andFilterWhere(['like', 'Send_Marketing_Materials', $this->Send_Marketing_Materials])
            ->andFilterWhere(['like', 'Shares_Outstanding', $this->Shares_Outstanding])
            ->andFilterWhere(['like', 'Shipping_Method', $this->Shipping_Method])
            ->andFilterWhere(['like', 'SIC_Code', $this->SIC_Code])
            ->andFilterWhere(['like', 'Status', $this->Status])
            ->andFilterWhere(['like', 'Status_Reason', $this->Status_Reason])
            ->andFilterWhere(['like', 'Stock_Exchange', $this->Stock_Exchange])
            ->andFilterWhere(['like', 'Sub_Region', $this->Sub_Region])
            ->andFilterWhere(['like', 'Supplies_to', $this->Supplies_to])
            ->andFilterWhere(['like', 'Telephone_3', $this->Telephone_3])
            ->andFilterWhere(['like', 'Territory', $this->Territory])
            ->andFilterWhere(['like', 'Territory_Code', $this->Territory_Code])
            ->andFilterWhere(['like', 'Ticker_Symbol', $this->Ticker_Symbol])
            ->andFilterWhere(['like', 'Website', $this->Website])
            ->andFilterWhere(['like', 'Yomi_Account_Name', $this->Yomi_Account_Name])
            ->andFilterWhere(['like', 'z_old_Industry', $this->z_old_Industry])
            ->andFilterWhere(['like', 'z_old_Payment_Terms', $this->z_old_Payment_Terms]);

        return $dataProvider;
    }
}
