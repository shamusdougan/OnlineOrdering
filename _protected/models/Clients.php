<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property string $Company_Name
 * @property string $Trading_as
 * @property string $Main_Phone
 * @property string $TownSuburb
 * @property string $Is_Customer
 * @property string $Is_Factory
 * @property string $Is_Supplier
 * @property string $Credit_Hold
 * @property string $Owner
 * @property string $Account_Number
 * @property string $Third_Party_Company
 * @property string $ABN
 * @property string $Account_Rating
 * @property string $Address_1
 * @property string $Address_1_Address_Type
 * @property string $Address_1_CountryRegion
 * @property string $Address_1_County
 * @property string $Address_1_Fax
 * @property string $Address_1_Freight_Terms
 * @property string $Address_1_Latitude
 * @property string $Address_1_Longitude
 * @property string $Address_1_Name
 * @property string $Address_1_Post_Office_Box
 * @property integer $Address_1_Postal_Code
 * @property string $Address_1_Primary_Contact_Name
 * @property string $Address_1_Shipping_Method
 * @property string $Address_1_StateProvince
 * @property string $Address_1_Street_1
 * @property string $Address_1_Street_2
 * @property string $Address_1_Street_3
 * @property string $Address_1_Telephone_2
 * @property string $Address_1_Telephone_3
 * @property string $Address_1_UPS_Zone
 * @property string $Address_1_UTC_Offset
 * @property string $Address_2
 * @property string $Address_2_Address_Type
 * @property string $Address_2_CountryRegion
 * @property string $Address_2_County
 * @property string $Address_2_Fax
 * @property string $Address_2_Freight_Terms
 * @property string $Address_2_Latitude
 * @property string $Address_2_Longitude
 * @property string $Address_2_Name
 * @property string $Address_2_Post_Office_Box
 * @property integer $Address_2_Postal_Code
 * @property string $Address_2_Primary_Contact_Name
 * @property string $Address_2_Shipping_Method
 * @property string $Address_2_StateProvince
 * @property string $Address_2_Street_1
 * @property string $Address_2_Street_2
 * @property string $Address_2_Street_3
 * @property string $Address_2_Telephone_1
 * @property string $Address_2_Telephone_2
 * @property string $Address_2_Telephone_3
 * @property string $Address_2_TownSuburb
 * @property string $Address_2_UPS_Zone
 * @property string $Address_2_UTC_Offset
 * @property string $Address_Phone
 * @property string $Address1_IsBillTo
 * @property string $Address1_IsShipTo
 * @property string $Aging_30
 * @property string $Aging_30_Base
 * @property string $Aging_60
 * @property string $Aging_60_Base
 * @property string $Aging_90
 * @property string $Aging_90_Base
 * @property string $Annual_Revenue
 * @property string $Annual_Revenue_Base
 * @property string $Beef_Notes
 * @property string $Billing_company_admin_fee
 * @property string $Billing_company_admin_fee_Base
 * @property string $Billing_contact
 * @property string $Billing_type
 * @property string $Business_Type
 * @property string $Category
 * @property string $Classification
 * @property string $Client_Status
 * @property string $Copy_addess
 * @property string $Copy_address
 * @property string $Created_By
 * @property string $Created_By_Delegate
 * @property string $Created_On
 * @property string $Credit_Limit
 * @property string $Credit_Limit_Base
 * @property string $Currency
 * @property string $Customer_Size
 * @property integer $Dairy_No
 * @property string $Dairy_Notes
 * @property string $Delivery_Directions
 * @property string $Description
 * @property string $Do_not_allow_Bulk_Emails
 * @property string $Do_not_allow_Bulk_Mails
 * @property string $Do_not_allow_Emails
 * @property string $Do_not_allow_Faxes
 * @property string $Do_not_allow_Mails
 * @property string $Do_not_allow_Phone_Calls
 * @property string $Email
 * @property string $Email_Address_2
 * @property string $Email_Address_3
 * @property string $Exchange_Rate
 * @property string $Farm_Mgr
 * @property string $Farm_No
 * @property string $Farm_Operation
 * @property integer $Fax
 * @property integer $Feed_Days_Remaining
 * @property string $Feed_empty
 * @property string $Feed_QOH_Tonnes
 * @property string $Feed_QOH_Update
 * @property string $Feed_Rate_Kg_Day
 * @property string $FTP_Site
 * @property string $Herd_Notes
 * @property integer $Herd_Size
 * @property string $Herd_Type
 * @property string $Industry_Code
 * @property string $Is_Internal
 * @property string $Is_Provider
 * @property string $Last_Date_Included_in_Campaign
 * @property string $Main_Competitor
 * @property string $Main_Product
 * @property string $Map_Reference
 * @property string $Market_Capitalization
 * @property string $Market_Capitalization_Base
 * @property string $Mobile_Phone
 * @property string $Modified_By
 * @property string $Modified_By_Delegate
 * @property string $Modified_On
 * @property string $Nearest_Town
 * @property string $No_of_Employees
 * @property string $Originating_Lead
 * @property string $Other_Phone
 * @property string $Ownership
 * @property string $Parent_Company
 * @property string $Parent_Region
 * @property string $Payment_Terms
 * @property string $Preferred_Day
 * @property string $Preferred_FacilityEquipment
 * @property string $Preferred_Method_of_Contact
 * @property string $Preferred_Service
 * @property string $Preferred_Time
 * @property string $Preferred_User
 * @property string $Price_List
 * @property string $Primary_Contact
 * @property string $Process
 * @property string $Process_Stage
 * @property string $Property_Name
 * @property string $Record_Created_On
 * @property string $Relationship_Type
 * @property string $Send_Marketing_Materials
 * @property string $Shares_Outstanding
 * @property string $Shipping_Method
 * @property string $SIC_Code
 * @property string $Status
 * @property string $Status_Reason
 * @property string $Stock_Exchange
 * @property string $Sub_Region
 * @property string $Supplies_to
 * @property string $Telephone_3
 * @property string $Territory
 * @property string $Territory_Code
 * @property string $Ticker_Symbol
 * @property string $Website
 * @property string $Yomi_Account_Name
 * @property string $z_old_Industry
 * @property string $z_old_Payment_Terms
 */
class Clients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Company_Name', 'Is_Customer', 'Is_Factory', 'Is_Supplier', 'Credit_Hold', 'Owner', 'Account_Number', 'Account_Rating', 'Address_1', 'Address_2_Address_Type', 'Address_2_Freight_Terms', 'Address_2_Shipping_Method', 'Address1_IsBillTo', 'Address1_IsShipTo', 'Classification', 'Created_By', 'Created_On', 'Currency', 'Customer_Size', 'Do_not_allow_Bulk_Emails', 'Do_not_allow_Bulk_Mails', 'Do_not_allow_Emails', 'Do_not_allow_Faxes', 'Do_not_allow_Mails', 'Do_not_allow_Phone_Calls', 'Exchange_Rate', 'Feed_QOH_Update', 'Feed_Rate_Kg_Day', 'Herd_Size', 'Is_Internal', 'Modified_By', 'Modified_On', 'Nearest_Town', 'Preferred_Method_of_Contact', 'Price_List', 'Send_Marketing_Materials', 'Shipping_Method', 'Status', 'Status_Reason', 'Territory_Code'], 'required'],
            [['Address_1_Postal_Code', 'Address_2_Postal_Code', 'Dairy_No', 'Fax', 'Feed_Days_Remaining', 'Herd_Size'], 'integer'],
            [['Exchange_Rate', 'Feed_QOH_Tonnes', 'Feed_Rate_Kg_Day'], 'number'],
            [['Feed_empty', 'Feed_QOH_Update'], 'safe'],
            [['Company_Name', 'Address_1_Street_1', 'Address_2_Street_1'], 'string', 'max' => 30],
            [['Trading_as'], 'string', 'max' => 21],
            [['Main_Phone', 'Billing_contact', 'Mobile_Phone', 'Modified_By_Delegate', 'Property_Name'], 'string', 'max' => 12],
            [['TownSuburb'], 'string', 'max' => 15],
            [['Is_Customer', 'Credit_Hold', 'Address_1_StateProvince', 'Address_2_StateProvince', 'Copy_address', 'Preferred_Method_of_Contact'], 'string', 'max' => 3],
            [['Is_Factory', 'Is_Supplier', 'Address1_IsBillTo', 'Address1_IsShipTo', 'Copy_addess', 'Do_not_allow_Bulk_Mails', 'Is_Internal', 'Is_Provider'], 'string', 'max' => 2],
            [['Owner', 'Account_Rating', 'Address_2_Freight_Terms', 'Address_2_Shipping_Method', 'Classification', 'Created_By', 'Customer_Size', 'Modified_By', 'Shipping_Method', 'Territory_Code'], 'string', 'max' => 13],
            [['Account_Number', 'Address_2_Street_2', 'Price_List'], 'string', 'max' => 6],
            [['Third_Party_Company', 'Address_1_Address_Type', 'Address_1_County', 'Address_1_Fax', 'Address_1_Freight_Terms', 'Address_1_Latitude', 'Address_1_Longitude', 'Address_1_Name', 'Address_1_Post_Office_Box', 'Address_1_Primary_Contact_Name', 'Address_1_Shipping_Method', 'Address_1_Street_2', 'Address_1_Telephone_2', 'Address_1_Telephone_3', 'Address_1_UPS_Zone', 'Address_1_UTC_Offset', 'Address_2_County', 'Address_2_Fax', 'Address_2_Latitude', 'Address_2_Longitude', 'Address_2_Name', 'Address_2_Post_Office_Box', 'Address_2_Primary_Contact_Name', 'Address_2_Street_3', 'Address_2_Telephone_1', 'Address_2_Telephone_2', 'Address_2_Telephone_3', 'Address_2_UPS_Zone', 'Address_2_UTC_Offset', 'Address_Phone', 'Aging_30', 'Aging_30_Base', 'Aging_60', 'Aging_60_Base', 'Aging_90', 'Aging_90_Base', 'Annual_Revenue', 'Annual_Revenue_Base', 'Beef_Notes', 'Billing_company_admin_fee', 'Billing_company_admin_fee_Base', 'Category', 'Created_By_Delegate', 'Credit_Limit', 'Credit_Limit_Base', 'Dairy_Notes', 'Description', 'Email_Address_2', 'Email_Address_3', 'Farm_No', 'FTP_Site', 'Herd_Notes', 'Industry_Code', 'Last_Date_Included_in_Campaign', 'Main_Product', 'Market_Capitalization', 'Market_Capitalization_Base', 'No_of_Employees', 'Originating_Lead', 'Other_Phone', 'Ownership', 'Parent_Company', 'Preferred_Day', 'Preferred_FacilityEquipment', 'Preferred_Service', 'Preferred_Time', 'Preferred_User', 'Primary_Contact', 'Process', 'Process_Stage', 'Record_Created_On', 'Relationship_Type', 'Shares_Outstanding', 'SIC_Code', 'Stock_Exchange', 'Telephone_3', 'Territory', 'Ticker_Symbol', 'Website', 'Yomi_Account_Name', 'z_old_Industry', 'z_old_Payment_Terms'], 'string', 'max' => 1],
            [['ABN', 'Address_2_Address_Type', 'Parent_Region'], 'string', 'max' => 14],
            [['Address_1'], 'string', 'max' => 61],
            [['Address_1_CountryRegion', 'Address_2_CountryRegion'], 'string', 'max' => 9],
            [['Address_1_Street_3', 'Client_Status'], 'string', 'max' => 7],
            [['Address_2'], 'string', 'max' => 60],
            [['Address_2_TownSuburb'], 'string', 'max' => 10],
            [['Billing_type', 'Main_Competitor', 'Status', 'Status_Reason'], 'string', 'max' => 8],
            [['Business_Type', 'Farm_Operation'], 'string', 'max' => 11],
            [['Created_On'], 'string', 'max' => 18],
            [['Currency'], 'string', 'max' => 17],
            [['Delivery_Directions'], 'string', 'max' => 265],
            [['Do_not_allow_Bulk_Emails', 'Do_not_allow_Emails', 'Do_not_allow_Faxes', 'Do_not_allow_Mails', 'Do_not_allow_Phone_Calls', 'Herd_Type', 'Map_Reference'], 'string', 'max' => 5],
            [['Email'], 'string', 'max' => 25],
            [['Farm_Mgr'], 'string', 'max' => 20],
            [['Modified_On'], 'string', 'max' => 19],
            [['Nearest_Town'], 'string', 'max' => 51],
            [['Payment_Terms', 'Sub_Region'], 'string', 'max' => 27],
            [['Send_Marketing_Materials'], 'string', 'max' => 4],
            [['Supplies_to'], 'string', 'max' => 24]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Company_Name' => 'Company  Name',
            'Trading_as' => 'Trading As',
            'Main_Phone' => 'Main  Phone',
            'TownSuburb' => 'Town Suburb',
            'Is_Customer' => 'Is  Customer',
            'Is_Factory' => 'Is  Factory',
            'Is_Supplier' => 'Is  Supplier',
            'Credit_Hold' => 'Credit  Hold',
            'Owner' => 'Owner',
            'Account_Number' => 'Account  Number',
            'Third_Party_Company' => 'Third  Party  Company',
            'ABN' => 'Abn',
            'Account_Rating' => 'Account  Rating',
            'Address_1' => 'Address 1',
            'Address_1_Address_Type' => 'Address 1  Address  Type',
            'Address_1_CountryRegion' => 'Address 1  Country Region',
            'Address_1_County' => 'Address 1  County',
            'Address_1_Fax' => 'Address 1  Fax',
            'Address_1_Freight_Terms' => 'Address 1  Freight  Terms',
            'Address_1_Latitude' => 'Address 1  Latitude',
            'Address_1_Longitude' => 'Address 1  Longitude',
            'Address_1_Name' => 'Address 1  Name',
            'Address_1_Post_Office_Box' => 'Address 1  Post  Office  Box',
            'Address_1_Postal_Code' => 'Address 1  Postal  Code',
            'Address_1_Primary_Contact_Name' => 'Address 1  Primary  Contact  Name',
            'Address_1_Shipping_Method' => 'Address 1  Shipping  Method',
            'Address_1_StateProvince' => 'Address 1  State Province',
            'Address_1_Street_1' => 'Address 1  Street 1',
            'Address_1_Street_2' => 'Address 1  Street 2',
            'Address_1_Street_3' => 'Address 1  Street 3',
            'Address_1_Telephone_2' => 'Address 1  Telephone 2',
            'Address_1_Telephone_3' => 'Address 1  Telephone 3',
            'Address_1_UPS_Zone' => 'Address 1  Ups  Zone',
            'Address_1_UTC_Offset' => 'Address 1  Utc  Offset',
            'Address_2' => 'Address 2',
            'Address_2_Address_Type' => 'Address 2  Address  Type',
            'Address_2_CountryRegion' => 'Address 2  Country Region',
            'Address_2_County' => 'Address 2  County',
            'Address_2_Fax' => 'Address 2  Fax',
            'Address_2_Freight_Terms' => 'Address 2  Freight  Terms',
            'Address_2_Latitude' => 'Address 2  Latitude',
            'Address_2_Longitude' => 'Address 2  Longitude',
            'Address_2_Name' => 'Address 2  Name',
            'Address_2_Post_Office_Box' => 'Address 2  Post  Office  Box',
            'Address_2_Postal_Code' => 'Address 2  Postal  Code',
            'Address_2_Primary_Contact_Name' => 'Address 2  Primary  Contact  Name',
            'Address_2_Shipping_Method' => 'Address 2  Shipping  Method',
            'Address_2_StateProvince' => 'Address 2  State Province',
            'Address_2_Street_1' => 'Address 2  Street 1',
            'Address_2_Street_2' => 'Address 2  Street 2',
            'Address_2_Street_3' => 'Address 2  Street 3',
            'Address_2_Telephone_1' => 'Address 2  Telephone 1',
            'Address_2_Telephone_2' => 'Address 2  Telephone 2',
            'Address_2_Telephone_3' => 'Address 2  Telephone 3',
            'Address_2_TownSuburb' => 'Address 2  Town Suburb',
            'Address_2_UPS_Zone' => 'Address 2  Ups  Zone',
            'Address_2_UTC_Offset' => 'Address 2  Utc  Offset',
            'Address_Phone' => 'Address  Phone',
            'Address1_IsBillTo' => 'Address1  Is Bill To',
            'Address1_IsShipTo' => 'Address1  Is Ship To',
            'Aging_30' => 'Aging 30',
            'Aging_30_Base' => 'Aging 30  Base',
            'Aging_60' => 'Aging 60',
            'Aging_60_Base' => 'Aging 60  Base',
            'Aging_90' => 'Aging 90',
            'Aging_90_Base' => 'Aging 90  Base',
            'Annual_Revenue' => 'Annual  Revenue',
            'Annual_Revenue_Base' => 'Annual  Revenue  Base',
            'Beef_Notes' => 'Beef  Notes',
            'Billing_company_admin_fee' => 'Billing Company Admin Fee',
            'Billing_company_admin_fee_Base' => 'Billing Company Admin Fee  Base',
            'Billing_contact' => 'Billing Contact',
            'Billing_type' => 'Billing Type',
            'Business_Type' => 'Business  Type',
            'Category' => 'Category',
            'Classification' => 'Classification',
            'Client_Status' => 'Client  Status',
            'Copy_addess' => 'Copy Addess',
            'Copy_address' => 'Copy Address',
            'Created_By' => 'Created  By',
            'Created_By_Delegate' => 'Created  By  Delegate',
            'Created_On' => 'Created  On',
            'Credit_Limit' => 'Credit  Limit',
            'Credit_Limit_Base' => 'Credit  Limit  Base',
            'Currency' => 'Currency',
            'Customer_Size' => 'Customer  Size',
            'Dairy_No' => 'Dairy  No',
            'Dairy_Notes' => 'Dairy  Notes',
            'Delivery_Directions' => 'Delivery  Directions',
            'Description' => 'Description',
            'Do_not_allow_Bulk_Emails' => 'Do Not Allow  Bulk  Emails',
            'Do_not_allow_Bulk_Mails' => 'Do Not Allow  Bulk  Mails',
            'Do_not_allow_Emails' => 'Do Not Allow  Emails',
            'Do_not_allow_Faxes' => 'Do Not Allow  Faxes',
            'Do_not_allow_Mails' => 'Do Not Allow  Mails',
            'Do_not_allow_Phone_Calls' => 'Do Not Allow  Phone  Calls',
            'Email' => 'Email',
            'Email_Address_2' => 'Email  Address 2',
            'Email_Address_3' => 'Email  Address 3',
            'Exchange_Rate' => 'Exchange  Rate',
            'Farm_Mgr' => 'Farm  Mgr',
            'Farm_No' => 'Farm  No',
            'Farm_Operation' => 'Farm  Operation',
            'Fax' => 'Fax',
            'Feed_Days_Remaining' => 'Feed  Days  Remaining',
            'Feed_empty' => 'Feed Empty',
            'Feed_QOH_Tonnes' => 'Feed  Qoh  Tonnes',
            'Feed_QOH_Update' => 'Feed  Qoh  Update',
            'Feed_Rate_Kg_Day' => 'Feed  Rate  Kg  Day',
            'FTP_Site' => 'Ftp  Site',
            'Herd_Notes' => 'Herd  Notes',
            'Herd_Size' => 'Herd  Size',
            'Herd_Type' => 'Herd  Type',
            'Industry_Code' => 'Industry  Code',
            'Is_Internal' => 'Is  Internal',
            'Is_Provider' => 'Is  Provider',
            'Last_Date_Included_in_Campaign' => 'Last  Date  Included In  Campaign',
            'Main_Competitor' => 'Main  Competitor',
            'Main_Product' => 'Main  Product',
            'Map_Reference' => 'Map  Reference',
            'Market_Capitalization' => 'Market  Capitalization',
            'Market_Capitalization_Base' => 'Market  Capitalization  Base',
            'Mobile_Phone' => 'Mobile  Phone',
            'Modified_By' => 'Modified  By',
            'Modified_By_Delegate' => 'Modified  By  Delegate',
            'Modified_On' => 'Modified  On',
            'Nearest_Town' => 'Nearest  Town',
            'No_of_Employees' => 'No Of  Employees',
            'Originating_Lead' => 'Originating  Lead',
            'Other_Phone' => 'Other  Phone',
            'Ownership' => 'Ownership',
            'Parent_Company' => 'Parent  Company',
            'Parent_Region' => 'Parent  Region',
            'Payment_Terms' => 'Payment  Terms',
            'Preferred_Day' => 'Preferred  Day',
            'Preferred_FacilityEquipment' => 'Preferred  Facility Equipment',
            'Preferred_Method_of_Contact' => 'Preferred  Method Of  Contact',
            'Preferred_Service' => 'Preferred  Service',
            'Preferred_Time' => 'Preferred  Time',
            'Preferred_User' => 'Preferred  User',
            'Price_List' => 'Price  List',
            'Primary_Contact' => 'Primary  Contact',
            'Process' => 'Process',
            'Process_Stage' => 'Process  Stage',
            'Property_Name' => 'Property  Name',
            'Record_Created_On' => 'Record  Created  On',
            'Relationship_Type' => 'Relationship  Type',
            'Send_Marketing_Materials' => 'Send  Marketing  Materials',
            'Shares_Outstanding' => 'Shares  Outstanding',
            'Shipping_Method' => 'Shipping  Method',
            'SIC_Code' => 'Sic  Code',
            'Status' => 'Status',
            'Status_Reason' => 'Status  Reason',
            'Stock_Exchange' => 'Stock  Exchange',
            'Sub_Region' => 'Sub  Region',
            'Supplies_to' => 'Supplies To',
            'Telephone_3' => 'Telephone 3',
            'Territory' => 'Territory',
            'Territory_Code' => 'Territory  Code',
            'Ticker_Symbol' => 'Ticker  Symbol',
            'Website' => 'Website',
            'Yomi_Account_Name' => 'Yomi  Account  Name',
            'z_old_Industry' => 'Z Old  Industry',
            'z_old_Payment_Terms' => 'Z Old  Payment  Terms',
        ];
    }
}
