<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer_orders".
 *
 * @property string $Order_ID
 * @property string $Customer
 * @property string $Name
 * @property string $Mix_Type
 * @property integer $Qty_Tonnes
 * @property string $Nearest_Town
 * @property string $Date_Fulfilled
 * @property string $Date_Submitted
 * @property string $Status_Reason
 * @property string $Anticipated_Sales
 * @property string $Bill_To_Address
 * @property string $Bill_to_Contact_Name
 * @property string $Bill_To_Fax
 * @property string $Bill_To_Phone
 * @property string $Bill_to_Address_Name
 * @property string $Bill_to_CountryRegion
 * @property string $Bill_to_Postal_Code
 * @property string $Bill_to_StateProvince
 * @property string $Bill_to_Street_1
 * @property string $Bill_to_Street_2
 * @property string $Bill_to_Street_3
 * @property string $Bill_to_TownSuburbCity
 * @property string $Billing_company
 * @property string $Billing_company_admin_fee
 * @property string $Billing_company_admin_fee_Base
 * @property string $Billing_company_purchase_order
 * @property string $Billing_type
 * @property string $cp
 * @property string $Created_By
 * @property string $Created_By_Delegate
 * @property string $Created_On
 * @property string $Currency
 * @property string $Current_Cost_pT
 * @property string $Current_Cost_pT_Base
 * @property string $Custom_Mix
 * @property string $Delivery_created
 * @property string $Description
 * @property string $Discount_
 * @property string $Discount_pT
 * @property string $Discount_pT_Base
 * @property string $Discount_notation
 * @property string $Discount_type
 * @property string $Exchange_Rate
 * @property integer $Feed_Days_Remaining
 * @property string $Feed_QOH_Tonnes
 * @property string $Feed_Rate_Kg_Day
 * @property string $Feed_Type
 * @property string $Freight_Amount
 * @property string $Freight_Amount_Base
 * @property string $Freight_Terms
 * @property integer $Herd_Size
 * @property string $Ingredient_Price_Base
 * @property string $Ingredients_Percentage_Total
 * @property string $IsMostRecentOrderByCustomer
 * @property string $IsMostRecentOrderByCustomerAndProduct
 * @property string $Last_Submitted_to_Back_Office
 * @property string $List_Price_pT
 * @property string $Load_Due
 * @property string $me
 * @property string $Modified_By
 * @property string $Modified_By_Delegate
 * @property string $Modified_On
 * @property string $Opportunity
 * @property string $Order_Discount_
 * @property string $Order_Discount_Amount
 * @property string $Order_Discount_Amount_Base
 * @property string $Order_instructions
 * @property string $Order_notification
 * @property string $Owner
 * @property string $Payment_Terms
 * @property string $PntFin
 * @property string $PntOpps
 * @property string $Price_pT
 * @property string $Price_pT_Base
 * @property string $Price_List
 * @property string $Price_Production
 * @property string $Price_Production_Base
 * @property string $Price_production_pT
 * @property string $Price_production_pT_Base
 * @property string $Price_Sub_Total
 * @property string $Price_Sub_Total_Base
 * @property string $Price_Total
 * @property string $Price_Total_Base
 * @property string $Price_Total_pT
 * @property string $Price_Total_pT_Base
 * @property string $Price_Transport
 * @property string $Price_Transport_Base
 * @property string $Price_transport_pT
 * @property string $Price_transport_pT_Base
 * @property string $Prices_Locked
 * @property string $Priority
 * @property string $Process
 * @property string $Process_Stage
 * @property string $Product
 * @property string $Product_Category
 * @property string $Product_Name
 * @property string $Quote
 * @property string $Record_Created_On
 * @property string $Requested_Delivery_by
 * @property string $Second_Customer
 * @property string $Second_customer_Order_percent
 * @property string $Ship_To
 * @property string $Ship_To_Address
 * @property string $Ship_To_Name
 * @property string $Ship_to_Contact_Name
 * @property string $Ship_to_CountryRegion
 * @property string $Ship_to_Fax
 * @property string $Ship_to_Freight_Terms
 * @property string $Ship_to_Phone
 * @property string $Ship_to_Postal_Code
 * @property string $Ship_to_StateProvince
 * @property string $Ship_to_Street_1
 * @property string $Ship_to_Street_2
 * @property string $Ship_to_Street_3
 * @property string $Ship_to_TownSuburbCity
 * @property string $Shipping_Method
 * @property string $Source_Campaign
 * @property string $Standard_Cost_pT
 * @property string $Standard_Cost_pT_Base
 * @property string $Status
 * @property string $Storage_Unit
 * @property string $Submitted_Status
 * @property string $Submitted_Status_Description
 * @property string $Total_Amount
 * @property string $Total_Amount_Base
 * @property string $Total_Detail_Amount
 * @property string $Total_Detail_Amount_Base
 * @property string $Total_Discount_Amount
 * @property string $Total_Discount_Amount_Base
 * @property string $Total_Line_Item_Discount_Amount
 * @property string $Total_Line_Item_Discount_Amount_Base
 * @property string $Total_PreFreight_Amount
 * @property string $Total_PreFreight_Amount_Base
 * @property string $Total_Tax
 * @property string $Total_Tax_Base
 * @property string $triggerSubmit
 */
class CustomerOrders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
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
            [['Order_ID'], 'required'],
            [['Qty_Tonnes', 'Feed_Days_Remaining', 'Herd_Size'], 'integer'],
            [['Date_Fulfilled', 'Date_Submitted', 'Load_Due', 'Requested_Delivery_by'], 'safe'],
            [['Exchange_Rate', 'Feed_QOH_Tonnes', 'Feed_Rate_Kg_Day', 'Price_pT', 'Price_production_pT', 'Price_Total_pT', 'Price_Transport', 'Price_transport_pT', 'Total_Amount', 'Total_Detail_Amount', 'Total_Discount_Amount', 'Total_Line_Item_Discount_Amount', 'Total_PreFreight_Amount', 'Total_Tax'], 'number'],
            [['Order_ID', 'Status_Reason', 'Billing_type', 'Price_pT_Base', 'Price_Production', 'Price_Sub_Total', 'Price_Total_pT_Base', 'Price_Transport_Base'], 'string', 'max' => 8],
            [['Customer', 'Billing_company', 'Second_Customer'], 'string', 'max' => 30],
            [['Name'], 'string', 'max' => 51],
            [['Mix_Type', 'Bill_To_Address', 'Bill_to_Contact_Name', 'Bill_To_Fax', 'Bill_To_Phone', 'Bill_to_Address_Name', 'Bill_to_CountryRegion', 'Bill_to_Postal_Code', 'Bill_to_StateProvince', 'Bill_to_Street_1', 'Bill_to_Street_2', 'Bill_to_Street_3', 'Bill_to_TownSuburbCity', 'Billing_company_admin_fee', 'Billing_company_admin_fee_Base', 'Billing_company_purchase_order', 'cp', 'Created_By_Delegate', 'Current_Cost_pT', 'Current_Cost_pT_Base', 'Description', 'Discount_', 'Discount_pT', 'Discount_pT_Base', 'Discount_notation', 'Freight_Amount', 'Freight_Amount_Base', 'Freight_Terms', 'Ingredient_Price_Base', 'Ingredients_Percentage_Total', 'Last_Submitted_to_Back_Office', 'List_Price_pT', 'me', 'Modified_By_Delegate', 'Opportunity', 'Order_Discount_', 'Order_Discount_Amount', 'Order_Discount_Amount_Base', 'Payment_Terms', 'Process', 'Process_Stage', 'Product', 'Quote', 'Record_Created_On', 'Second_customer_Order_percent', 'Ship_To_Address', 'Ship_To_Name', 'Ship_to_Contact_Name', 'Ship_to_CountryRegion', 'Ship_to_Fax', 'Ship_to_Phone', 'Ship_to_Postal_Code', 'Ship_to_StateProvince', 'Ship_to_Street_1', 'Ship_to_Street_2', 'Ship_to_Street_3', 'Ship_to_TownSuburbCity', 'Shipping_Method', 'Source_Campaign', 'Standard_Cost_pT', 'Standard_Cost_pT_Base', 'Submitted_Status', 'Submitted_Status_Description', 'triggerSubmit'], 'string', 'max' => 1],
            [['Nearest_Town'], 'string', 'max' => 45],
            [['Anticipated_Sales', 'Discount_type'], 'string', 'max' => 3],
            [['Created_By', 'Owner', 'Priority', 'Product_Name', 'Ship_to_Freight_Terms'], 'string', 'max' => 13],
            [['Created_On', 'Delivery_created'], 'string', 'max' => 19],
            [['Currency', 'Modified_By'], 'string', 'max' => 17],
            [['Custom_Mix', 'IsMostRecentOrderByCustomer', 'IsMostRecentOrderByCustomerAndProduct', 'Order_notification', 'PntFin', 'PntOpps', 'Prices_Locked'], 'string', 'max' => 2],
            [['Feed_Type'], 'string', 'max' => 5],
            [['Modified_On'], 'string', 'max' => 18],
            [['Order_instructions'], 'string', 'max' => 92],
            [['Price_List', 'Total_Amount_Base', 'Total_Detail_Amount_Base', 'Total_Discount_Amount_Base', 'Total_Line_Item_Discount_Amount_Base', 'Total_PreFreight_Amount_Base', 'Total_Tax_Base'], 'string', 'max' => 6],
            [['Price_Production_Base', 'Price_Sub_Total_Base'], 'string', 'max' => 10],
            [['Price_production_pT_Base', 'Price_transport_pT_Base', 'Ship_To'], 'string', 'max' => 7],
            [['Price_Total', 'Status'], 'string', 'max' => 9],
            [['Price_Total_Base'], 'string', 'max' => 11],
            [['Product_Category', 'Storage_Unit'], 'string', 'max' => 12]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Order_ID' => 'Order  ID',
            'Customer' => 'Customer',
            'Name' => 'Name',
            'Mix_Type' => 'Mix  Type',
            'Qty_Tonnes' => 'Qty  Tonnes',
            'Nearest_Town' => 'Nearest  Town',
            'Date_Fulfilled' => 'Date  Fulfilled',
            'Date_Submitted' => 'Date  Submitted',
            'Status_Reason' => 'Status  Reason',
            'Anticipated_Sales' => 'Anticipated  Sales',
            'Bill_To_Address' => 'Bill  To  Address',
            'Bill_to_Contact_Name' => 'Bill To  Contact  Name',
            'Bill_To_Fax' => 'Bill  To  Fax',
            'Bill_To_Phone' => 'Bill  To  Phone',
            'Bill_to_Address_Name' => 'Bill To  Address  Name',
            'Bill_to_CountryRegion' => 'Bill To  Country Region',
            'Bill_to_Postal_Code' => 'Bill To  Postal  Code',
            'Bill_to_StateProvince' => 'Bill To  State Province',
            'Bill_to_Street_1' => 'Bill To  Street 1',
            'Bill_to_Street_2' => 'Bill To  Street 2',
            'Bill_to_Street_3' => 'Bill To  Street 3',
            'Bill_to_TownSuburbCity' => 'Bill To  Town Suburb City',
            'Billing_company' => 'Billing Company',
            'Billing_company_admin_fee' => 'Billing Company Admin Fee',
            'Billing_company_admin_fee_Base' => 'Billing Company Admin Fee  Base',
            'Billing_company_purchase_order' => 'Billing Company Purchase Order',
            'Billing_type' => 'Billing Type',
            'cp' => 'Cp',
            'Created_By' => 'Created  By',
            'Created_By_Delegate' => 'Created  By  Delegate',
            'Created_On' => 'Created  On',
            'Currency' => 'Currency',
            'Current_Cost_pT' => 'Current  Cost P T',
            'Current_Cost_pT_Base' => 'Current  Cost P T  Base',
            'Custom_Mix' => 'Custom  Mix',
            'Delivery_created' => 'Delivery Created',
            'Description' => 'Description',
            'Discount_' => 'Discount',
            'Discount_pT' => 'Discount P T',
            'Discount_pT_Base' => 'Discount P T  Base',
            'Discount_notation' => 'Discount Notation',
            'Discount_type' => 'Discount Type',
            'Exchange_Rate' => 'Exchange  Rate',
            'Feed_Days_Remaining' => 'Feed  Days  Remaining',
            'Feed_QOH_Tonnes' => 'Feed  Qoh  Tonnes',
            'Feed_Rate_Kg_Day' => 'Feed  Rate  Kg  Day',
            'Feed_Type' => 'Feed  Type',
            'Freight_Amount' => 'Freight  Amount',
            'Freight_Amount_Base' => 'Freight  Amount  Base',
            'Freight_Terms' => 'Freight  Terms',
            'Herd_Size' => 'Herd  Size',
            'Ingredient_Price_Base' => 'Ingredient  Price  Base',
            'Ingredients_Percentage_Total' => 'Ingredients  Percentage  Total',
            'IsMostRecentOrderByCustomer' => 'Is Most Recent Order By Customer',
            'IsMostRecentOrderByCustomerAndProduct' => 'Is Most Recent Order By Customer And Product',
            'Last_Submitted_to_Back_Office' => 'Last  Submitted To  Back  Office',
            'List_Price_pT' => 'List  Price P T',
            'Load_Due' => 'Load  Due',
            'me' => 'Me',
            'Modified_By' => 'Modified  By',
            'Modified_By_Delegate' => 'Modified  By  Delegate',
            'Modified_On' => 'Modified  On',
            'Opportunity' => 'Opportunity',
            'Order_Discount_' => 'Order  Discount',
            'Order_Discount_Amount' => 'Order  Discount  Amount',
            'Order_Discount_Amount_Base' => 'Order  Discount  Amount  Base',
            'Order_instructions' => 'Order Instructions',
            'Order_notification' => 'Order Notification',
            'Owner' => 'Owner',
            'Payment_Terms' => 'Payment  Terms',
            'PntFin' => 'Pnt Fin',
            'PntOpps' => 'Pnt Opps',
            'Price_pT' => 'Price P T',
            'Price_pT_Base' => 'Price P T  Base',
            'Price_List' => 'Price  List',
            'Price_Production' => 'Price  Production',
            'Price_Production_Base' => 'Price  Production  Base',
            'Price_production_pT' => 'Price Production P T',
            'Price_production_pT_Base' => 'Price Production P T  Base',
            'Price_Sub_Total' => 'Price  Sub  Total',
            'Price_Sub_Total_Base' => 'Price  Sub  Total  Base',
            'Price_Total' => 'Price  Total',
            'Price_Total_Base' => 'Price  Total  Base',
            'Price_Total_pT' => 'Price  Total P T',
            'Price_Total_pT_Base' => 'Price  Total P T  Base',
            'Price_Transport' => 'Price  Transport',
            'Price_Transport_Base' => 'Price  Transport  Base',
            'Price_transport_pT' => 'Price Transport P T',
            'Price_transport_pT_Base' => 'Price Transport P T  Base',
            'Prices_Locked' => 'Prices  Locked',
            'Priority' => 'Priority',
            'Process' => 'Process',
            'Process_Stage' => 'Process  Stage',
            'Product' => 'Product',
            'Product_Category' => 'Product  Category',
            'Product_Name' => 'Product  Name',
            'Quote' => 'Quote',
            'Record_Created_On' => 'Record  Created  On',
            'Requested_Delivery_by' => 'Requested  Delivery By',
            'Second_Customer' => 'Second  Customer',
            'Second_customer_Order_percent' => 'Second Customer  Order Percent',
            'Ship_To' => 'Ship  To',
            'Ship_To_Address' => 'Ship  To  Address',
            'Ship_To_Name' => 'Ship  To  Name',
            'Ship_to_Contact_Name' => 'Ship To  Contact  Name',
            'Ship_to_CountryRegion' => 'Ship To  Country Region',
            'Ship_to_Fax' => 'Ship To  Fax',
            'Ship_to_Freight_Terms' => 'Ship To  Freight  Terms',
            'Ship_to_Phone' => 'Ship To  Phone',
            'Ship_to_Postal_Code' => 'Ship To  Postal  Code',
            'Ship_to_StateProvince' => 'Ship To  State Province',
            'Ship_to_Street_1' => 'Ship To  Street 1',
            'Ship_to_Street_2' => 'Ship To  Street 2',
            'Ship_to_Street_3' => 'Ship To  Street 3',
            'Ship_to_TownSuburbCity' => 'Ship To  Town Suburb City',
            'Shipping_Method' => 'Shipping  Method',
            'Source_Campaign' => 'Source  Campaign',
            'Standard_Cost_pT' => 'Standard  Cost P T',
            'Standard_Cost_pT_Base' => 'Standard  Cost P T  Base',
            'Status' => 'Status',
            'Storage_Unit' => 'Storage  Unit',
            'Submitted_Status' => 'Submitted  Status',
            'Submitted_Status_Description' => 'Submitted  Status  Description',
            'Total_Amount' => 'Total  Amount',
            'Total_Amount_Base' => 'Total  Amount  Base',
            'Total_Detail_Amount' => 'Total  Detail  Amount',
            'Total_Detail_Amount_Base' => 'Total  Detail  Amount  Base',
            'Total_Discount_Amount' => 'Total  Discount  Amount',
            'Total_Discount_Amount_Base' => 'Total  Discount  Amount  Base',
            'Total_Line_Item_Discount_Amount' => 'Total  Line  Item  Discount  Amount',
            'Total_Line_Item_Discount_Amount_Base' => 'Total  Line  Item  Discount  Amount  Base',
            'Total_PreFreight_Amount' => 'Total  Pre Freight  Amount',
            'Total_PreFreight_Amount_Base' => 'Total  Pre Freight  Amount  Base',
            'Total_Tax' => 'Total  Tax',
            'Total_Tax_Base' => 'Total  Tax  Base',
            'triggerSubmit' => 'Trigger Submit',
        ];
    }
}
