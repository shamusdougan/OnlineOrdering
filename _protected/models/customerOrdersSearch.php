<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CustomerOrders;

/**
 * CustomerOrdersSearch represents the model behind the search form about `app\models\CustomerOrders`.
 */
class CustomerOrdersSearch extends CustomerOrders
{
	
	
	//ChildObject Fakeouts
	public function attributes()
	{
		  return array_merge(parent::attributes(), ['client.Company_Name', 'createdByUser.fullname']);
	}
	
	
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Customer_id', 'Mix_Type', 'Qty_Tonnes', 'Billing_company', 'Billing_type', 'Created_By', 'Discount_pT', 'Discount_pT_Base', 'Discount_type', 'Feed_Days_Remaining', 'Feed_Type', 'Herd_Size', 'Modified_By', 'Order_notification', 'Owner', 'Price_Production', 'Price_Production_Base', 'Price_production_pT', 'Price_production_pT_Base', 'Price_Transport', 'Price_Transport_Base', 'Price_transport_pT', 'Price_transport_pT_Base', 'Process', 'Process_Stage', 'Product_Category', 'Second_Customer', 'Second_customer_Order_percent', 'Ship_To', 'Status', 'Storage_Unit', 'Submitted_Status', 'Submitted_Status_Description'], 'integer'],
            [['Order_ID', 'Name', 'Nearest_Town', 'Date_Fulfilled', 'Date_Submitted', 'Status_Reason', 'Anticipated_Sales', 'Created_On', 'Discount_notation', 'Load_Due', 'Modified_On', 'Order_instructions', 'Product_Name', 'Requested_Delivery_by'], 'safe'],
            [['Discount_Percent', 'Feed_QOH_Tonnes', 'Feed_Rate_Kg_Day', 'Price_pT', 'Price_pT_Base', 'Price_Sub_Total', 'Price_Sub_Total_Base', 'Price_Total', 'Price_Total_Base', 'Price_Total_pT', 'Price_Total_pT_Base'], 'number'],
            [['client.Company_Name', 'createdByUser.fullname'], 'safe']
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
        $query = CustomerOrders::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


		$dataProvider->sort->attributes['client.Company_Name'] = [
		      'asc' => ['clients.Company_Name' => SORT_ASC],
		      'desc' => ['clients.Company_Name' => SORT_DESC],
		];
		$dataProvider->sort->attributes['createdByUser.fullname'] = [
		      'asc' => ['user.firstname' => SORT_ASC],
		      'desc' => ['user.firstname' => SORT_DESC],
		];
		
		$query->joinWith(['client']); 
		$query->joinWith(['createdByUser']); 

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'Customer_id' => $this->Customer_id,
            'Mix_Type' => $this->Mix_Type,
            'Qty_Tonnes' => $this->Qty_Tonnes,
            'Date_Fulfilled' => $this->Date_Fulfilled,
            'Date_Submitted' => $this->Date_Submitted,
            'Billing_company' => $this->Billing_company,
            'Billing_type' => $this->Billing_type,
            'Created_By' => $this->Created_By,
            'Created_On' => $this->Created_On,
            'Discount_Percent' => $this->Discount_Percent,
            'Discount_pT' => $this->Discount_pT,
            'Discount_pT_Base' => $this->Discount_pT_Base,
            'Discount_type' => $this->Discount_type,
            'Feed_Days_Remaining' => $this->Feed_Days_Remaining,
            'Feed_QOH_Tonnes' => $this->Feed_QOH_Tonnes,
            'Feed_Rate_Kg_Day' => $this->Feed_Rate_Kg_Day,
            'Feed_Type' => $this->Feed_Type,
            'Herd_Size' => $this->Herd_Size,
            'Load_Due' => $this->Load_Due,
            'Modified_By' => $this->Modified_By,
            'Modified_On' => $this->Modified_On,
            'Order_notification' => $this->Order_notification,
            'Owner' => $this->Owner,
            'Price_pT' => $this->Price_pT,
            'Price_pT_Base' => $this->Price_pT_Base,
            'Price_Production' => $this->Price_Production,
            'Price_Production_Base' => $this->Price_Production_Base,
            'Price_production_pT' => $this->Price_production_pT,
            'Price_production_pT_Base' => $this->Price_production_pT_Base,
            'Price_Sub_Total' => $this->Price_Sub_Total,
            'Price_Sub_Total_Base' => $this->Price_Sub_Total_Base,
            'Price_Total' => $this->Price_Total,
            'Price_Total_Base' => $this->Price_Total_Base,
            'Price_Total_pT' => $this->Price_Total_pT,
            'Price_Total_pT_Base' => $this->Price_Total_pT_Base,
            'Price_Transport' => $this->Price_Transport,
            'Price_Transport_Base' => $this->Price_Transport_Base,
            'Price_transport_pT' => $this->Price_transport_pT,
            'Price_transport_pT_Base' => $this->Price_transport_pT_Base,
            'Process' => $this->Process,
            'Process_Stage' => $this->Process_Stage,
            'Product_Category' => $this->Product_Category,
            'Requested_Delivery_by' => $this->Requested_Delivery_by,
            'Second_Customer' => $this->Second_Customer,
            'Second_customer_Order_percent' => $this->Second_customer_Order_percent,
            'Ship_To' => $this->Ship_To,
            'customer_orders.Status' => $this->Status,
            'Storage_Unit' => $this->Storage_Unit,
            'Submitted_Status' => $this->Submitted_Status,
            'Submitted_Status_Description' => $this->Submitted_Status_Description,
        ]);

        $query->andFilterWhere(['like', 'Order_ID', $this->Order_ID])
            ->andFilterWhere(['like', 'Name', $this->Name])
            ->andFilterWhere(['like', 'Nearest_Town', $this->Nearest_Town])
            ->andFilterWhere(['like', 'customer_orders.Status', $this->Status])
            ->andFilterWhere(['like', 'Anticipated_Sales', $this->Anticipated_Sales])
            ->andFilterWhere(['like', 'Discount_notation', $this->Discount_notation])
            ->andFilterWhere(['like', 'Order_instructions', $this->Order_instructions])
            ->andFilterWhere(['like', 'Product_Name', $this->Product_Name])
            ->andFilterWhere(['like', 'clients.Company_Name', $this->getAttribute('client.Company_Name')])
            ->andFilterWhere(['like', 'user.fullname', $this->getAttribute('createdByUser.fullname')]);

        return $dataProvider;
    }
    
    
    public function getActiveOrders($params)
    {
        $query = CustomerOrders::find()
        	->Where('customer_orders.Status = '.CustomerOrders::STATUS_ACTIVE)
        	->andWhere('Customer_id != :id', ['id'=>Clients::DUMMY]);

		return $this->dataQuery($params, $query);
	}
	
	
	 public function getSubmittedOrders($params)
    {
        $query = CustomerOrders::find()
        	->Where('customer_orders.Status = '.CustomerOrders::STATUS_SUBMITTED)
        	->andWhere('Customer_id != :id', ['id'=>Clients::DUMMY]);

		return $this->dataQuery($params, $query);
	}
	
	public function getAllOrders($params)
	{
		$query = CustomerOrders::find()->where('Customer_id != :id', ['id'=>Clients::DUMMY]);
		return $this->dataQuery($params, $query);
		
	}
	
	
	
	
	
public function dataQuery($params, $query)
		{
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


		$dataProvider->sort->attributes['client.Company_Name'] = [
		      'asc' => ['clients.Company_Name' => SORT_ASC],
		      'desc' => ['clients.Company_Name' => SORT_DESC],
		];
		$dataProvider->sort->attributes['createdByUser.fullname'] = [
		      'asc' => ['user.firstname' => SORT_ASC],
		      'desc' => ['user.firstname' => SORT_DESC],
		];
		
		$query->joinWith(['client']); 
		$query->joinWith(['createdByUser']); 

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'Customer_id' => $this->Customer_id,
            'Mix_Type' => $this->Mix_Type,
            'Qty_Tonnes' => $this->Qty_Tonnes,
            'Date_Fulfilled' => $this->Date_Fulfilled,
            'Date_Submitted' => $this->Date_Submitted,
            'Billing_company' => $this->Billing_company,
            'Billing_type' => $this->Billing_type,
            'Created_By' => $this->Created_By,
            'Created_On' => $this->Created_On,
            'Discount_Percent' => $this->Discount_Percent,
            'Discount_pT' => $this->Discount_pT,
            'Discount_pT_Base' => $this->Discount_pT_Base,
            'Discount_type' => $this->Discount_type,
            'Feed_Days_Remaining' => $this->Feed_Days_Remaining,
            'Feed_QOH_Tonnes' => $this->Feed_QOH_Tonnes,
            'Feed_Rate_Kg_Day' => $this->Feed_Rate_Kg_Day,
            'Feed_Type' => $this->Feed_Type,
            'Herd_Size' => $this->Herd_Size,
            'Load_Due' => $this->Load_Due,
            'Modified_By' => $this->Modified_By,
            'Modified_On' => $this->Modified_On,
            'Order_notification' => $this->Order_notification,
            'Owner' => $this->Owner,
            'Price_pT' => $this->Price_pT,
            'Price_pT_Base' => $this->Price_pT_Base,
            'Price_Production' => $this->Price_Production,
            'Price_Production_Base' => $this->Price_Production_Base,
            'Price_production_pT' => $this->Price_production_pT,
            'Price_production_pT_Base' => $this->Price_production_pT_Base,
            'Price_Sub_Total' => $this->Price_Sub_Total,
            'Price_Sub_Total_Base' => $this->Price_Sub_Total_Base,
            'Price_Total' => $this->Price_Total,
            'Price_Total_Base' => $this->Price_Total_Base,
            'Price_Total_pT' => $this->Price_Total_pT,
            'Price_Total_pT_Base' => $this->Price_Total_pT_Base,
            'Price_Transport' => $this->Price_Transport,
            'Price_Transport_Base' => $this->Price_Transport_Base,
            'Price_transport_pT' => $this->Price_transport_pT,
            'Price_transport_pT_Base' => $this->Price_transport_pT_Base,
            'Process' => $this->Process,
            'Process_Stage' => $this->Process_Stage,
            'Product_Category' => $this->Product_Category,
            'Requested_Delivery_by' => $this->Requested_Delivery_by,
            'Second_Customer' => $this->Second_Customer,
            'Second_customer_Order_percent' => $this->Second_customer_Order_percent,
            'Ship_To' => $this->Ship_To,
            'customer_orders.Status' => $this->Status,
            'Storage_Unit' => $this->Storage_Unit,
            'Submitted_Status' => $this->Submitted_Status,
            'Submitted_Status_Description' => $this->Submitted_Status_Description,
        ]);

        $query->andFilterWhere(['like', 'Order_ID', $this->Order_ID])
            ->andFilterWhere(['like', 'Name', $this->Name])
            ->andFilterWhere(['like', 'Nearest_Town', $this->Nearest_Town])
            ->andFilterWhere(['like', 'customer_orders.Status', $this->Status])
            ->andFilterWhere(['like', 'Anticipated_Sales', $this->Anticipated_Sales])
            ->andFilterWhere(['like', 'Discount_notation', $this->Discount_notation])
            ->andFilterWhere(['like', 'Order_instructions', $this->Order_instructions])
            ->andFilterWhere(['like', 'Product_Name', $this->Product_Name])
            ->andFilterWhere(['like', 'clients.Company_Name', $this->getAttribute('client.Company_Name')])
            ->andFilterWhere(['like', 'user.fullname', $this->getAttribute('createdByUser.fullname')]);

        return $dataProvider;
    }
    
    
}
