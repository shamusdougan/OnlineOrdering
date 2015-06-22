<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\customerOrders;

/**
 * customerOrdersSearch represents the model behind the search form about `app\models\customerOrders`.
 */
class customerOrdersSearch extends customerOrders
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Order_ID', 'Customer', 'Name', 'Mix_Type', 'Nearest_Town', 'Date_Fulfilled', 'Date_Submitted', 'Status_Reason', 'Anticipated_Sales', 'Bill_To_Address', 'Bill_to_Contact_Name', 'Bill_To_Fax', 'Bill_To_Phone', 'Bill_to_Address_Name', 'Bill_to_CountryRegion', 'Bill_to_Postal_Code', 'Bill_to_StateProvince', 'Bill_to_Street_1', 'Bill_to_Street_2', 'Bill_to_Street_3', 'Bill_to_TownSuburbCity', 'Billing_company', 'Billing_company_admin_fee', 'Billing_company_admin_fee_Base', 'Billing_company_purchase_order', 'Billing_type', 'cp', 'Created_By', 'Created_By_Delegate', 'Created_On', 'Currency', 'Current_Cost_pT', 'Current_Cost_pT_Base', 'Custom_Mix', 'Delivery_created', 'Description', 'Discount_', 'Discount_pT', 'Discount_pT_Base', 'Discount_notation', 'Discount_type', 'Feed_Type', 'Freight_Amount', 'Freight_Amount_Base', 'Freight_Terms', 'Ingredient_Price_Base', 'Ingredients_Percentage_Total', 'IsMostRecentOrderByCustomer', 'IsMostRecentOrderByCustomerAndProduct', 'Last_Submitted_to_Back_Office', 'List_Price_pT', 'Load_Due', 'me', 'Modified_By', 'Modified_By_Delegate', 'Modified_On', 'Opportunity', 'Order_Discount_', 'Order_Discount_Amount', 'Order_Discount_Amount_Base', 'Order_instructions', 'Order_notification', 'Owner', 'Payment_Terms', 'PntFin', 'PntOpps', 'Price_pT_Base', 'Price_List', 'Price_Production', 'Price_Production_Base', 'Price_production_pT_Base', 'Price_Sub_Total', 'Price_Sub_Total_Base', 'Price_Total', 'Price_Total_Base', 'Price_Total_pT_Base', 'Price_Transport_Base', 'Price_transport_pT_Base', 'Prices_Locked', 'Priority', 'Process', 'Process_Stage', 'Product', 'Product_Category', 'Product_Name', 'Quote', 'Record_Created_On', 'Requested_Delivery_by', 'Second_Customer', 'Second_customer_Order_percent', 'Ship_To', 'Ship_To_Address', 'Ship_To_Name', 'Ship_to_Contact_Name', 'Ship_to_CountryRegion', 'Ship_to_Fax', 'Ship_to_Freight_Terms', 'Ship_to_Phone', 'Ship_to_Postal_Code', 'Ship_to_StateProvince', 'Ship_to_Street_1', 'Ship_to_Street_2', 'Ship_to_Street_3', 'Ship_to_TownSuburbCity', 'Shipping_Method', 'Source_Campaign', 'Standard_Cost_pT', 'Standard_Cost_pT_Base', 'Status', 'Storage_Unit', 'Submitted_Status', 'Submitted_Status_Description', 'Total_Amount_Base', 'Total_Detail_Amount_Base', 'Total_Discount_Amount_Base', 'Total_Line_Item_Discount_Amount_Base', 'Total_PreFreight_Amount_Base', 'Total_Tax_Base', 'triggerSubmit'], 'safe'],
            [['Qty_Tonnes', 'Feed_Days_Remaining', 'Herd_Size'], 'integer'],
            [['Exchange_Rate', 'Feed_QOH_Tonnes', 'Feed_Rate_Kg_Day', 'Price_pT', 'Price_production_pT', 'Price_Total_pT', 'Price_Transport', 'Price_transport_pT', 'Total_Amount', 'Total_Detail_Amount', 'Total_Discount_Amount', 'Total_Line_Item_Discount_Amount', 'Total_PreFreight_Amount', 'Total_Tax'], 'number'],
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
        $query = customerOrders::find();

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
            'Qty_Tonnes' => $this->Qty_Tonnes,
            'Date_Fulfilled' => $this->Date_Fulfilled,
            'Date_Submitted' => $this->Date_Submitted,
            'Exchange_Rate' => $this->Exchange_Rate,
            'Feed_Days_Remaining' => $this->Feed_Days_Remaining,
            'Feed_QOH_Tonnes' => $this->Feed_QOH_Tonnes,
            'Feed_Rate_Kg_Day' => $this->Feed_Rate_Kg_Day,
            'Herd_Size' => $this->Herd_Size,
            'Load_Due' => $this->Load_Due,
            'Price_pT' => $this->Price_pT,
            'Price_production_pT' => $this->Price_production_pT,
            'Price_Total_pT' => $this->Price_Total_pT,
            'Price_Transport' => $this->Price_Transport,
            'Price_transport_pT' => $this->Price_transport_pT,
            'Requested_Delivery_by' => $this->Requested_Delivery_by,
            'Total_Amount' => $this->Total_Amount,
            'Total_Detail_Amount' => $this->Total_Detail_Amount,
            'Total_Discount_Amount' => $this->Total_Discount_Amount,
            'Total_Line_Item_Discount_Amount' => $this->Total_Line_Item_Discount_Amount,
            'Total_PreFreight_Amount' => $this->Total_PreFreight_Amount,
            'Total_Tax' => $this->Total_Tax,
        ]);

        $query->andFilterWhere(['like', 'Order_ID', $this->Order_ID])
            ->andFilterWhere(['like', 'Customer', $this->Customer])
            ->andFilterWhere(['like', 'Name', $this->Name])
            ->andFilterWhere(['like', 'Mix_Type', $this->Mix_Type])
            ->andFilterWhere(['like', 'Nearest_Town', $this->Nearest_Town])
            ->andFilterWhere(['like', 'Status_Reason', $this->Status_Reason])
            ->andFilterWhere(['like', 'Anticipated_Sales', $this->Anticipated_Sales])
            ->andFilterWhere(['like', 'Bill_To_Address', $this->Bill_To_Address])
            ->andFilterWhere(['like', 'Bill_to_Contact_Name', $this->Bill_to_Contact_Name])
            ->andFilterWhere(['like', 'Bill_To_Fax', $this->Bill_To_Fax])
            ->andFilterWhere(['like', 'Bill_To_Phone', $this->Bill_To_Phone])
            ->andFilterWhere(['like', 'Bill_to_Address_Name', $this->Bill_to_Address_Name])
            ->andFilterWhere(['like', 'Bill_to_CountryRegion', $this->Bill_to_CountryRegion])
            ->andFilterWhere(['like', 'Bill_to_Postal_Code', $this->Bill_to_Postal_Code])
            ->andFilterWhere(['like', 'Bill_to_StateProvince', $this->Bill_to_StateProvince])
            ->andFilterWhere(['like', 'Bill_to_Street_1', $this->Bill_to_Street_1])
            ->andFilterWhere(['like', 'Bill_to_Street_2', $this->Bill_to_Street_2])
            ->andFilterWhere(['like', 'Bill_to_Street_3', $this->Bill_to_Street_3])
            ->andFilterWhere(['like', 'Bill_to_TownSuburbCity', $this->Bill_to_TownSuburbCity])
            ->andFilterWhere(['like', 'Billing_company', $this->Billing_company])
            ->andFilterWhere(['like', 'Billing_company_admin_fee', $this->Billing_company_admin_fee])
            ->andFilterWhere(['like', 'Billing_company_admin_fee_Base', $this->Billing_company_admin_fee_Base])
            ->andFilterWhere(['like', 'Billing_company_purchase_order', $this->Billing_company_purchase_order])
            ->andFilterWhere(['like', 'Billing_type', $this->Billing_type])
            ->andFilterWhere(['like', 'cp', $this->cp])
            ->andFilterWhere(['like', 'Created_By', $this->Created_By])
            ->andFilterWhere(['like', 'Created_By_Delegate', $this->Created_By_Delegate])
            ->andFilterWhere(['like', 'Created_On', $this->Created_On])
            ->andFilterWhere(['like', 'Currency', $this->Currency])
            ->andFilterWhere(['like', 'Current_Cost_pT', $this->Current_Cost_pT])
            ->andFilterWhere(['like', 'Current_Cost_pT_Base', $this->Current_Cost_pT_Base])
            ->andFilterWhere(['like', 'Custom_Mix', $this->Custom_Mix])
            ->andFilterWhere(['like', 'Delivery_created', $this->Delivery_created])
            ->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'Discount_', $this->Discount_])
            ->andFilterWhere(['like', 'Discount_pT', $this->Discount_pT])
            ->andFilterWhere(['like', 'Discount_pT_Base', $this->Discount_pT_Base])
            ->andFilterWhere(['like', 'Discount_notation', $this->Discount_notation])
            ->andFilterWhere(['like', 'Discount_type', $this->Discount_type])
            ->andFilterWhere(['like', 'Feed_Type', $this->Feed_Type])
            ->andFilterWhere(['like', 'Freight_Amount', $this->Freight_Amount])
            ->andFilterWhere(['like', 'Freight_Amount_Base', $this->Freight_Amount_Base])
            ->andFilterWhere(['like', 'Freight_Terms', $this->Freight_Terms])
            ->andFilterWhere(['like', 'Ingredient_Price_Base', $this->Ingredient_Price_Base])
            ->andFilterWhere(['like', 'Ingredients_Percentage_Total', $this->Ingredients_Percentage_Total])
            ->andFilterWhere(['like', 'IsMostRecentOrderByCustomer', $this->IsMostRecentOrderByCustomer])
            ->andFilterWhere(['like', 'IsMostRecentOrderByCustomerAndProduct', $this->IsMostRecentOrderByCustomerAndProduct])
            ->andFilterWhere(['like', 'Last_Submitted_to_Back_Office', $this->Last_Submitted_to_Back_Office])
            ->andFilterWhere(['like', 'List_Price_pT', $this->List_Price_pT])
            ->andFilterWhere(['like', 'me', $this->me])
            ->andFilterWhere(['like', 'Modified_By', $this->Modified_By])
            ->andFilterWhere(['like', 'Modified_By_Delegate', $this->Modified_By_Delegate])
            ->andFilterWhere(['like', 'Modified_On', $this->Modified_On])
            ->andFilterWhere(['like', 'Opportunity', $this->Opportunity])
            ->andFilterWhere(['like', 'Order_Discount_', $this->Order_Discount_])
            ->andFilterWhere(['like', 'Order_Discount_Amount', $this->Order_Discount_Amount])
            ->andFilterWhere(['like', 'Order_Discount_Amount_Base', $this->Order_Discount_Amount_Base])
            ->andFilterWhere(['like', 'Order_instructions', $this->Order_instructions])
            ->andFilterWhere(['like', 'Order_notification', $this->Order_notification])
            ->andFilterWhere(['like', 'Owner', $this->Owner])
            ->andFilterWhere(['like', 'Payment_Terms', $this->Payment_Terms])
            ->andFilterWhere(['like', 'PntFin', $this->PntFin])
            ->andFilterWhere(['like', 'PntOpps', $this->PntOpps])
            ->andFilterWhere(['like', 'Price_pT_Base', $this->Price_pT_Base])
            ->andFilterWhere(['like', 'Price_List', $this->Price_List])
            ->andFilterWhere(['like', 'Price_Production', $this->Price_Production])
            ->andFilterWhere(['like', 'Price_Production_Base', $this->Price_Production_Base])
            ->andFilterWhere(['like', 'Price_production_pT_Base', $this->Price_production_pT_Base])
            ->andFilterWhere(['like', 'Price_Sub_Total', $this->Price_Sub_Total])
            ->andFilterWhere(['like', 'Price_Sub_Total_Base', $this->Price_Sub_Total_Base])
            ->andFilterWhere(['like', 'Price_Total', $this->Price_Total])
            ->andFilterWhere(['like', 'Price_Total_Base', $this->Price_Total_Base])
            ->andFilterWhere(['like', 'Price_Total_pT_Base', $this->Price_Total_pT_Base])
            ->andFilterWhere(['like', 'Price_Transport_Base', $this->Price_Transport_Base])
            ->andFilterWhere(['like', 'Price_transport_pT_Base', $this->Price_transport_pT_Base])
            ->andFilterWhere(['like', 'Prices_Locked', $this->Prices_Locked])
            ->andFilterWhere(['like', 'Priority', $this->Priority])
            ->andFilterWhere(['like', 'Process', $this->Process])
            ->andFilterWhere(['like', 'Process_Stage', $this->Process_Stage])
            ->andFilterWhere(['like', 'Product', $this->Product])
            ->andFilterWhere(['like', 'Product_Category', $this->Product_Category])
            ->andFilterWhere(['like', 'Product_Name', $this->Product_Name])
            ->andFilterWhere(['like', 'Quote', $this->Quote])
            ->andFilterWhere(['like', 'Record_Created_On', $this->Record_Created_On])
            ->andFilterWhere(['like', 'Second_Customer', $this->Second_Customer])
            ->andFilterWhere(['like', 'Second_customer_Order_percent', $this->Second_customer_Order_percent])
            ->andFilterWhere(['like', 'Ship_To', $this->Ship_To])
            ->andFilterWhere(['like', 'Ship_To_Address', $this->Ship_To_Address])
            ->andFilterWhere(['like', 'Ship_To_Name', $this->Ship_To_Name])
            ->andFilterWhere(['like', 'Ship_to_Contact_Name', $this->Ship_to_Contact_Name])
            ->andFilterWhere(['like', 'Ship_to_CountryRegion', $this->Ship_to_CountryRegion])
            ->andFilterWhere(['like', 'Ship_to_Fax', $this->Ship_to_Fax])
            ->andFilterWhere(['like', 'Ship_to_Freight_Terms', $this->Ship_to_Freight_Terms])
            ->andFilterWhere(['like', 'Ship_to_Phone', $this->Ship_to_Phone])
            ->andFilterWhere(['like', 'Ship_to_Postal_Code', $this->Ship_to_Postal_Code])
            ->andFilterWhere(['like', 'Ship_to_StateProvince', $this->Ship_to_StateProvince])
            ->andFilterWhere(['like', 'Ship_to_Street_1', $this->Ship_to_Street_1])
            ->andFilterWhere(['like', 'Ship_to_Street_2', $this->Ship_to_Street_2])
            ->andFilterWhere(['like', 'Ship_to_Street_3', $this->Ship_to_Street_3])
            ->andFilterWhere(['like', 'Ship_to_TownSuburbCity', $this->Ship_to_TownSuburbCity])
            ->andFilterWhere(['like', 'Shipping_Method', $this->Shipping_Method])
            ->andFilterWhere(['like', 'Source_Campaign', $this->Source_Campaign])
            ->andFilterWhere(['like', 'Standard_Cost_pT', $this->Standard_Cost_pT])
            ->andFilterWhere(['like', 'Standard_Cost_pT_Base', $this->Standard_Cost_pT_Base])
            ->andFilterWhere(['like', 'Status', $this->Status])
            ->andFilterWhere(['like', 'Storage_Unit', $this->Storage_Unit])
            ->andFilterWhere(['like', 'Submitted_Status', $this->Submitted_Status])
            ->andFilterWhere(['like', 'Submitted_Status_Description', $this->Submitted_Status_Description])
            ->andFilterWhere(['like', 'Total_Amount_Base', $this->Total_Amount_Base])
            ->andFilterWhere(['like', 'Total_Detail_Amount_Base', $this->Total_Detail_Amount_Base])
            ->andFilterWhere(['like', 'Total_Discount_Amount_Base', $this->Total_Discount_Amount_Base])
            ->andFilterWhere(['like', 'Total_Line_Item_Discount_Amount_Base', $this->Total_Line_Item_Discount_Amount_Base])
            ->andFilterWhere(['like', 'Total_PreFreight_Amount_Base', $this->Total_PreFreight_Amount_Base])
            ->andFilterWhere(['like', 'Total_Tax_Base', $this->Total_Tax_Base])
            ->andFilterWhere(['like', 'triggerSubmit', $this->triggerSubmit]);

        return $dataProvider;
    }
}
