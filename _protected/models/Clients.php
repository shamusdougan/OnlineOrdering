<?php

namespace app\models;
use webvimark\modules\UserManagement\models\User;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property integer $id
 * @property string $Company_Name
 * @property string $Account_Number
 * @property string $Main_Phone
 * @property integer $Fax
 * @property string $TownSuburb
 * @property boolean $Is_Customer
 * @property boolean $Is_Factory
 * @property boolean $Is_Supplier
 * @property string $3rd_Party_Company
 * @property string $ABN
 * @property string $Address_1
 * @property integer $Address_1_Address_Type
 * @property string $Address_1_CountryRegion
 * @property integer $Address_1_Postal_Code
 * @property string $Address_1_StateProvince
 * @property string $Address_1_Street_1
 * @property string $Address_1_Street_2
 * @property string $Address_1_Street_3
 * @property string $Address_1_Telephone_2
 * @property string $Address_1_Telephone_3
 * @property string $Address_2
 * @property integer $Address_2_Address_Type
 * @property string $Address_2_CountryRegion
 * @property integer $Address_2_Postal_Code
 * @property string $Address_2_StateProvince
 * @property string $Address_2_Street_1
 * @property string $Address_2_Street_2
 * @property string $Address_2_Street_3
 * @property string $Address_2_Telephone_1
 * @property string $Address_2_Telephone_2
 * @property string $Address_2_Telephone_3
 * @property string $Address_2_TownSuburb
 * @property string $Address_Phone
 * @property boolean $Address1_IsBillTo
 * @property boolean $Address1_IsShipTo
 * @property string $Billing_company_admin_fee
 * @property string $Billing_company_admin_fee_Base
 * @property integer $Billing_contact
 * @property integer $Billing_type
 * @property integer $Business_Type
 * @property string $Category
 * @property integer $Client_Status
 * @property string $Copy_addess
 * @property string $Copy_address
 * @property integer $Created_By
 * @property string $Created_On
 * @property boolean $Credit_Hold
 * @property integer $Dairy_No
 * @property string $Dairy_Notes
 * @property string $Delivery_Directions
 * @property string $Description
 * @property boolean $Do_not_allow_Bulk_Emails
 * @property boolean $Do_not_allow_Bulk_Mails
 * @property boolean $Do_not_allow_Emails
 * @property boolean $Do_not_allow_Faxes
 * @property boolean $Do_not_allow_Mails
 * @property boolean $Do_not_allow_Phone_Calls
 * @property string $Email
 * @property string $Email_Address_2
 * @property string $Email_Address_3
 * @property integer $Exchange_Rate
 * @property string $Farm_Mgr
 * @property string $Farm_No
 * @property integer $Farm_Operation
 * @property integer $Feed_Days_Remaining
 * @property string $Feed_empty
 * @property integer $Feed_QOH_Tonnes
 * @property string $Feed_QOH_Update
 * @property string $Feed_Rate_Kg_Day
 * @property string $Herd_Notes
 * @property integer $Herd_Size
 * @property integer $Herd_Type
 * @property boolean $Is_Internal
 * @property boolean $Is_Provider
 * @property string $Main_Competitor
 * @property string $Map_Reference
 * @property string $Mobile_Phone
 * @property integer $Modified_By
 * @property string $Modified_On
 * @property string $Nearest_Town
 * @property integer $No_of_Employees
 * @property integer $Owner_id
 * @property string $Parent_Region
 * @property string $Payment_Terms
 * @property string $Preferred_Day
 * @property string $Preferred_FacilityEquipment
 * @property string $Property_Name
 * @property integer $Status
 * @property string $Sub_Region
 * @property string $Supplies_to
 * @property string $Trading_as
 * @property string $Website
 */
class Clients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     * 
     */
     
     
    const DUMMY = 666;
    const SALES_STATUS_CURRENT = 1;
	const SALES_STATUS_INTER = 2;
	const SALES_STATUS_LOST = 3;
	
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 0;
     
     
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
            [['Company_Name', 'Main_Phone'], 'required'],
            [['id', 'Fax', 'Address_1_Address_Type', 'Address_1_Postal_Code', 'Address_2_Address_Type', 'Address_2_Postal_Code', 'Billing_contact', 'Billing_type', 'Business_Type', 'Client_Status', 'Created_By', 'Dairy_No', 'Exchange_Rate', 'Farm_Operation', 'Feed_Days_Remaining', 'Feed_QOH_Tonnes', 'Herd_Size', 'Herd_Type', 'Modified_By', 'No_of_Employees', 'Owner_id', 'Sales_Status'], 'integer'],
            [['Is_Customer', 'Is_Factory', 'Is_Supplier', 'Address1_IsBillTo', 'Address1_IsShipTo', 'Credit_Hold', 'Do_not_allow_Bulk_Emails', 'Do_not_allow_Bulk_Mails', 'Do_not_allow_Emails', 'Do_not_allow_Faxes', 'Do_not_allow_Mails', 'Do_not_allow_Phone_Calls', 'Is_Internal', 'Is_Provider'], 'boolean'],
            [['Created_On', 'Feed_empty', 'Feed_QOH_Update', 'Modified_On', 'Address_1_TownSuburb'], 'safe'],
            [['Feed_Rate_Kg_Day'], 'number'],
            [['Company_Name', 'Address_1_TownSuburb', '3rd_Party_Company', 'Address_1_CountryRegion', 'Address_1_Street_1', 'Address_1_Street_2', 'Address_1_Street_3', 'Address_2', 'Address_2_CountryRegion', 'Address_2_StateProvince', 'Address_2_Street_1', 'Address_2_Street_2', 'Address_2_Street_3', 'Address_2_TownSuburb', 'Billing_company_admin_fee', 'Billing_company_admin_fee_Base', 'Category', 'Farm_No', 'Main_Competitor', 'Mobile_Phone', 'Nearest_Town', 'Parent_Region', 'Payment_Terms', 'Preferred_Day', 'Preferred_FacilityEquipment', 'Property_Name'], 'string', 'max' => 100],
            [['Account_Number'], 'string', 'max' => 6],
            [['Main_Phone'], 'string', 'max' => 12],
            [['ABN'], 'string', 'max' => 14],
            [['Address_1'], 'string', 'max' => 61],
            [['Address_1_StateProvince'], 'string', 'max' => 5],
            [['Address_1_Telephone_2', 'Address_1_Telephone_3', 'Address_2_Telephone_1', 'Address_2_Telephone_2', 'Address_2_Telephone_3', 'Address_Phone'], 'string', 'max' => 15],
            [['Copy_addess', 'Copy_address'], 'string', 'max' => 2],
            [['Dairy_Notes', 'Description'], 'string', 'max' => 500],
            [['Delivery_Directions'], 'string', 'max' => 419],
            [['Email', 'Email_Address_2', 'Email_Address_3', 'Sub_Region', 'Supplies_to', 'Trading_as', 'Website'], 'string', 'max' => 255],
            [['Farm_Mgr'], 'string', 'max' => 20],
            [['Herd_Notes'], 'string', 'max' => 1000],
            [['Map_Reference'], 'string', 'max' => 8]
        ];
    }



/*
	* Input Senarios
	*/
	public function scenarios()
    {
		$scenarios = parent::scenarios();
        $scenarios['bulkModify'] = [];//Scenario Values Only Accepted
        
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Company_Name' => 'Company  Name',
            'Account_Number' => 'Account  Number',
            'Main_Phone' => 'Main  Phone',
            'Fax' => 'Fax',
            'Address_1_TownSuburb' => 'Town Suburb',
            'Is_Customer' => 'Is  Customer',
            'Is_Factory' => 'Is  Factory',
            'Is_Supplier' => 'Is  Supplier',
            '3rd_Party_Company' => '3rd  Party  Company',
            'ABN' => 'Abn',
            'Address_1' => 'Address 1',
            'Address_1_Address_Type' => 'Address 1  Address  Type',
            'Address_1_CountryRegion' => 'Address 1  Country Region',
            'Address_1_Postal_Code' => 'Address 1  Postal  Code',
            'Address_1_StateProvince' => 'Address 1  State Province',
            'Address_1_Street_1' => 'Address 1  Street 1',
            'Address_1_Street_2' => 'Address 1  Street 2',
            'Address_1_Street_3' => 'Address 1  Street 3',
            'Address_1_Telephone_2' => 'Address 1  Telephone 2',
            'Address_1_Telephone_3' => 'Address 1  Telephone 3',
            'Address_2' => 'Address 2',
            'Address_2_Address_Type' => 'Address 2  Address  Type',
            'Address_2_CountryRegion' => 'Address 2  Country Region',
            'Address_2_Postal_Code' => 'Address 2  Postal  Code',
            'Address_2_StateProvince' => 'Address 2  State Province',
            'Address_2_Street_1' => 'Address 2  Street 1',
            'Address_2_Street_2' => 'Address 2  Street 2',
            'Address_2_Street_3' => 'Address 2  Street 3',
            'Address_2_Telephone_1' => 'Address 2  Telephone 1',
            'Address_2_Telephone_2' => 'Address 2  Telephone 2',
            'Address_2_Telephone_3' => 'Address 2  Telephone 3',
            'Address_2_TownSuburb' => 'Address 2  Town Suburb',
            'Address_Phone' => 'Address  Phone',
            'Address1_IsBillTo' => 'Address1  Is Bill To',
            'Address1_IsShipTo' => 'Address1  Is Ship To',
            'Billing_company_admin_fee' => 'Billing Company Admin Fee',
            'Billing_company_admin_fee_Base' => 'Billing Company Admin Fee  Base',
            'Billing_contact' => 'Billing Contact',
            'Billing_type' => 'Billing Type',
            'Business_Type' => 'Business  Type',
            'Category' => 'Category',
            'Client_Status' => 'Client Status',
            'Copy_addess' => 'Copy Addess',
            'Copy_address' => 'Copy Address',
            'Created_By' => 'Created  By',
            'Created_On' => 'Created  On',
            'Credit_Hold' => 'Credit  Hold',
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
            'Feed_Days_Remaining' => 'Feed  Days  Remaining',
            'Feed_empty' => 'Feed Empty',
            'Feed_QOH_Tonnes' => 'Feed  Qoh  Tonnes',
            'Feed_QOH_Update' => 'Feed  Qoh  Update',
            'Feed_Rate_Kg_Day' => 'Feed  Rate  Kg  Day',
            'Herd_Notes' => 'Herd  Notes',
            'Herd_Size' => 'Herd  Size',
            'Herd_Type' => 'Herd  Type',
            'Is_Internal' => 'Is  Internal',
            'Is_Provider' => 'Is  Provider',
            'Main_Competitor' => 'Main  Competitor',
            'Map_Reference' => 'Map  Reference',
            'Mobile_Phone' => 'Mobile  Phone',
            'Modified_By' => 'Modified  By',
            'Modified_On' => 'Modified  On',
            'Nearest_Town' => 'Nearest  Town',
            'No_of_Employees' => 'No Of  Employees',
            'Parent_Region' => 'Parent  Region',
            'Payment_Terms' => 'Payment  Terms',
            'Preferred_Day' => 'Preferred  Day',
            'Preferred_FacilityEquipment' => 'Preferred  Facility Equipment',
            'Property_Name' => 'Property  Name',
            'Sales_Status' => 'Status',
            'Sub_Region' => 'Sub  Region',
            'Supplies_to' => 'Supplies To',
            'Trading_as' => 'Trading As',
            'Website' => 'Website',
        ];
    }
    
    
    public function getContacts()
    {
		 return $this->hasMany(Contacts::className(), ['Company_id' => 'id']);
	}
	
	 public function getStorage()
    {
		 return $this->hasMany(Storage::className(), ['company_id' => 'id']);
	}
	
	public function getOwner()
	{
		return $this->hasOne(User::className(), ['id' => 'Owner_id']);
	}
	
	public function getClientListName()
	{
		$returnString = $this->Company_Name;
		if($this->Trading_as != "")
			{
			$returnString .= " (".$this->Trading_as.")";
			}
		return $returnString;
	}
	
	
	public function isCustomer()
	{
		if($this->Is_Customer == 1)
			{
			return true;
			}
		return false;
	}
	
	public function getOrders()
    {
		 return $this->hasMany(CustomerOrders::className(), ['Customer_id' => 'id']);
	}


 
    public function getActiveClientListArray()
    	{
		$clientObjects = Clients::find()
    				->where('id != :id', ['id'=>Clients::DUMMY])
    				->select(['id', 'Company_Name'])
    				->all();
    	$clientList = ArrayHelper::map($clientObjects, 'id', 'clientListName') ;
        	
        return $clientList;
		}
	
}
