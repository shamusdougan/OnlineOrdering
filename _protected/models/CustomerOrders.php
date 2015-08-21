<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer_orders".
 *
 * @property integer $id
 * @property string $Order_ID
 * @property integer $Customer_id
 * @property string $Name
 * @property integer $Mix_Type
 * @property integer $Qty_Tonnes
 * @property string $Nearest_Town
 * @property string $Date_Fulfilled
 * @property string $Date_Submitted
 * @property string $Status_Reason
 * @property string $Anticipated_Sales
 * @property integer $Billing_company
 * @property integer $Billing_type
 * @property integer $Created_By
 * @property string $Created_On
 * @property string $Delivery_created
 * @property string $Discount_Percent
 * @property integer $Discount_pT
 * @property integer $Discount_pT_Base
 * @property string $Discount_notation
 * @property integer $Discount_type
 * @property integer $Feed_Days_Remaining
 * @property string $Feed_QOH_Tonnes
 * @property string $Feed_Rate_Kg_Day
 * @property integer $Feed_Type
 * @property integer $Herd_Size
 * @property string $Load_Due
 * @property integer $Modified_By
 * @property string $Modified_On
 * @property string $Order_instructions
 * @property integer $Order_notification
 * @property integer $Owner
 * @property string $Price_pT
 * @property string $Price_pT_Base
 * @property integer $Price_Production
 * @property integer $Price_Production_Base
 * @property integer $Price_production_pT
 * @property integer $Price_production_pT_Base
 * @property string $Price_Sub_Total
 * @property string $Price_Sub_Total_Base
 * @property string $Price_Total
 * @property string $Price_Total_Base
 * @property string $Price_Total_pT
 * @property string $Price_Total_pT_Base
 * @property integer $Price_Transport
 * @property integer $Price_Transport_Base
 * @property integer $Price_transport_pT
 * @property integer $Price_transport_pT_Base
 * @property integer $Process
 * @property integer $Process_Stage
 * @property integer $Product_Category
 * @property string $Product_Name
 * @property string $Requested_Delivery_by
 * @property integer $Second_Customer
 * @property integer $Second_customer_Order_percent
 * @property integer $Ship_To
 * @property integer $Status
 * @property integer $Storage_Unit
 * @property integer $Submitted_Status
 * @property integer $Submitted_Status_Description
 */
class CustomerOrders extends \yii\db\ActiveRecord
{
	
	const PLACEHOLDERID = 666;
	const STATUS_ACTIVE = 1;
	const STATUS_SUBMITTED = 2;
	const STATUS_PROCESSING = 3;
	const STATUS_DELIVERY = 4;
	
    /**
     * @inheritdoc
     * 
     */
    public static function tableName()
    {
        return 'customer_orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Customer_id', 'Name', 'Created_On', 'Qty_Tonnes', 'Requested_Delivery_by', 'Storage_Unit'], 'required'],
            [['Customer_id', 'Mix_Type', 'Qty_Tonnes', 'Billing_company', 'Billing_type', 'Created_By', 'Discount_pT', 'Discount_pT_Base', 'Discount_type', 'Feed_Days_Remaining', 'Feed_Type', 'Herd_Size', 'Modified_By', 'Order_notification', 'Owner', 'Price_Production', 'Price_Production_Base', 'Price_production_pT', 'Price_production_pT_Base', 'Price_Transport', 'Price_Transport_Base', 'Price_transport_pT', 'Price_transport_pT_Base', 'Process', 'Process_Stage', 'Product_Category', 'Second_Customer', 'Second_customer_Order_percent', 'Ship_To', 'Status', 'Storage_Unit', 'Submitted_Status', 'Submitted_Status_Description'], 'integer'],
            [['Discount_Percent', 'Date_Fulfilled', 'Date_Submitted', 'Created_On', 'Delivery_created', 'Load_Due', 'Modified_On', 'Requested_Delivery_by'], 'safe'],
            [['Feed_QOH_Tonnes', 'Feed_Rate_Kg_Day', 'Price_pT', 'Price_pT_Base', 'Price_Sub_Total', 'Price_Sub_Total_Base', 'Price_Total', 'Price_Total_Base', 'Price_Total_pT', 'Price_Total_pT_Base'], 'number'],
            [['Order_ID'], 'string', 'max' => 8],
            [['Name', 'Nearest_Town', 'Discount_notation'], 'string', 'max' => 200],
            [['Status_Reason'], 'string', 'max' => 50],
            [['Anticipated_Sales'], 'string', 'max' => 3],
            [['Order_instructions'], 'string', 'max' => 800],
            [['Product_Name'], 'string', 'max' => 100],
			[['Percent_ingredients'], 'number', 'min' => 100, 'max' => 100],
            ['Discount_notation', 'required', 'when' => function ($model) 
            	{
            	return $model->Discount_type > 1;
            	},
            	'whenClient' => "function (attribute, value) 
            		{
            			return $('#customerorders-Discount_type').val() > 1;
            		}"
            	],
            
            
        ];
    }

	/*
	* Input Senarios
	*/
	public function scenarios()
    {
		$scenarios = parent::scenarios();
        $scenarios['createDummy'] = ['Customer_id','Created_On', 'Status', 'Name', 'Created_By'];//Scenario Values Only Accepted
        return $scenarios;
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Order_ID' => 'Order  ID',
            'Customer_id' => 'Customer ID',
            'Name' => 'Name',
            'Mix_Type' => 'Mix  Type',
            'Qty_Tonnes' => 'Qty  Tonnes',
            'Nearest_Town' => 'Nearest  Town',
            'Date_Fulfilled' => 'Date  Fulfilled',
            'Date_Submitted' => 'Date  Submitted',
            'Status_Reason' => 'Status  Reason',
            'Anticipated_Sales' => 'Anticipated  Sales',
            'Billing_company' => 'Billing Company',
            'Billing_type' => 'Billing Type',
            'Created_By' => 'Created  By',
            'Created_On' => 'Created  On',
            'Delivery_created' => 'Delivery Created',
            'Discount_Percent' => 'Discount %',
            'Discount_pT' => 'Discount Per Tonne',
            'Discount_pT_Base' => 'Discount P T  Base',
            'Discount_notation' => 'Discount Notation',
            'Discount_type' => 'Discount Type',
            'Feed_Days_Remaining' => 'Feed  Days  Remaining',
            'Feed_QOH_Tonnes' => 'Feed  Qoh  Tonnes',
            'Feed_Rate_Kg_Day' => 'Feed  Rate  Kg  Day',
            'Feed_Type' => 'Feed  Type',
            'Herd_Size' => 'Herd  Size',
            'Load_Due' => 'Load  Due',
            'Modified_By' => 'Modified  By',
            'Modified_On' => 'Modified  On',
            'Order_instructions' => 'Order Instructions',
            'Order_notification' => 'Order Notification',
            'Owner' => 'Owner',
            'Price_pT' => 'Base Price per Ton',
            'Price_pT_Base' => 'Price per Ton  Base',
            'Price_Production' => 'Add Production per Ton',
            'Price_Production_Base' => 'Price  Production  Base',
            'Price_production_pT' => 'Add Production Cost',
            'Price_production_pT_Base' => 'Price Production P T  Base',
            'Price_Sub_Total' => 'Price  Subtotal',
            'Price_Sub_Total_Base' => 'Price  Sub  Total  Base',
            'Price_Total' => 'Price  Total',
            'Price_Total_Base' => 'Price  Total  Base',
            'Price_Total_pT' => 'Price  Total P T',
            'Price_Total_pT_Base' => 'Price  Total P T  Base',
            'Price_Transport' => 'Price  Transport',
            'Price_Transport_Base' => 'Price  Transport  Base',
            'Price_transport_pT' => 'Transport Cost per Ton',
            'Price_transport_pT_Base' => 'Price Transport P T  Base',
            'Process' => 'Process',
            'Process_Stage' => 'Process  Stage',
            'Product_Category' => 'Product  Category',
            'Product_Name' => 'Product  Name',
            'Requested_Delivery_by' => 'Requested Delivery By',
            'Second_Customer' => 'Second  Customer',
            'Second_customer_Order_percent' => 'Second Customer  Order Percent',
            'Ship_To' => 'Ship  To',
            'Status' => 'Status',
            'Storage_Unit' => 'Storage  Unit',
            'Submitted_Status' => 'Submitted  Status',
            'Submitted_Status_Description' => 'Submitted  Status  Description',
        ];
    }
    
    
    public function getClient()
    {
		 return $this->hasOne(Clients::className(), ['id' => 'Customer_id' ]);
	}
	
	public function getIngredients()
	{
		return $this->hasMany(CustomerOrdersIngredients::className(), ['order_id' => 'id' ]);
	}
	
	public function getCreatedByUser()
	{
		return $this->hasOne(user::className(), ['id' => 'Created_By'] );
	}
	
	
	public function getOrderNumber()
	{
		return "ORD".(3000 + $this->id);
	}
   
   
	public function getStorage()
	{
		return $this->hasOne(storage::className(), ['id' => 'Storage_Unit'] );
	}
   
   
    
   public function generateOrderName()
   {
   	return $this->client->Company_Name." ".Lookup::item($this->Product_Category, "ORDER_CATEGORY" )." ".$this->Qty_Tonnes."T";
   }
   
   
   
   public function isDummyClient()
   {
   	return $this->Customer_id == Clients::DUMMY;
   }
   
   
   
   public function calculatePricePT()
   {
   	
		//First calculate the price per ton, which is the sum of the ingedients->product price per tom
   		$sum = 0;
		foreach($this->ingredients as $ingredientItem)
			{
			$sum += $ingredientItem->weightedCost;
			}
		$this->Price_pT_Base = $sum;
		
		//calculate the overall price per tone, added prodcution cost + transport cost
		$this->Price_Sub_Total = $this->Price_pT_Base + $this->Price_production_pT + $this->Price_transport_pT;
		
		
   }
   
   
   
   
   
    public function beforeSave($insert)
	{
    if (parent::beforeSave($insert)) 
    	{
		$this->Name = $this->generateOrderName();
		$this->calculatePricePT();
		return true;
    	} 
    else 
    	{
        return false;
    	}
	}
   
    
}
