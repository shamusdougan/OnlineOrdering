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
	const SALES_STATUS_INACTIVE = 4;
	
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
            'Feed_QOH_Tonnes' => 'Feed QOH Tonnes',
            'Feed_QOH_Update' => 'QOH Udated',
            'Feed_Rate_Kg_Day' => 'Feed Rate Kg/Day',
            'Herd_Notes' => 'Herd  Notes',
            'Herd_Size' => 'Default Herd Size',
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
	
	public function findStorageByName($storageName)
	{
		foreach($this->storage as $storageObject)
		{
		if($storageObject->Description == $storageName)
			{
			return $storageObject->id;	
			}
		}
		
		return "Unable to find Storage from Name: ".$storageName." for client: ".$this->Company_Name;
		
	}
	
	/**
	* get Feed Days remaining - Returns the number of days of feed remaining for the client
	* Based upon the current system date and calculated from the Feed_QOH_update, Feed_QOH_Tonnes and the client given Feed Rate.
	* Each one of these parameters is updated everytime an order is delivered and marked as completed.
	* 
	* @return
	*/
	public function getFeedDaysRemaining()
	{
		$feed_QOH = $this->getFeedQOH(); // the current amount of feed right now base on system date
		
		
		if($this->Herd_Size == 0)
			{
			return "Herd Size Not Set";
			}
		if($this->Feed_Rate_Kg_Day == 0)
			{
			return "Feed Rate Not Set";
			}

		//echo $feed_QOH." / ".$this->Herd_Size." * ".$this->Feed_Rate_Kg_Day." / 1000 <br>";
		return floor($feed_QOH / ($this->Herd_Size * $this->Feed_Rate_Kg_Day / 1000));

		
	
	}
	
	
	
	/**
	* getFeedQOH
	* 
	* Description: this function calculates the Feed currently on hand based upon the Herd Size, Feed Rate per Day, and the updated time from the QOH
	* If the Herd Size or the Feed Rate per day is 0 then simply return the QOH if the Late update of the QOH is in the future then grab the feed rate, qoh and herd numbers from the last
	* order placed that was delivered
	* 
	* @return
	*/
	public function getFeedQOH()
	{
		$QOH_Update = new \DateTime($this->Feed_QOH_Update);
		$currentDate = new \DateTime();
		$daysDifference = (int)$currentDate->diff($QOH_Update)->format('%R%a');
		
		//If the last known delivery date is in the future use the details from the last delivery before today
		if($daysDifference > 0) // in the future
			{
			$lastDelivery = $this->getLastDeliveryBefore(time());
			
			//If there hasn't been a delivery before then return 0 Feed on hand
			if(!$lastDelivery)
				{
				//echo $this->Feed_QOH_Tonnes."<br>";
				return $this->Feed_QOH_Tonnes;
				}
			else{
				$Feed_QOH_Tonnes = $lastDelivery->delivery_qty + $lastDelivery->customerOrder->Feed_QOH_Tonnes - ($lastDelivery->return ? $lastDelivery->return->amount : 0);
				$Feed_Rate_Kg_Day = $lastDelivery->customerOrder->Feed_Rate_Kg_Day;
				$Feed_QOH_Update = $lastDelivery->delivery_on;
				$Herd_Size = $lastDelivery->customerOrder->Herd_Size;
				$daysDifference = (int)$currentDate->diff($Feed_QOH_Update)->format('%R%a');
				
				//echo $Feed_QOH_Tonnes. " -(".$daysDifference." * ".$Herd_Size." * ".$Feed_Rate_Kg_Day." /1000) <br>";
				return floor($Feed_QOH_Tonnes + ($daysDifference * $Herd_Size * $Feed_Rate_Kg_Day / 1000));
				}
			}
		else{
			//echo $this->Feed_QOH_Tonnes. " -(".$daysDifference." * ".$this->Herd_Size." * ".$this->Feed_Rate_Kg_Day." /1000) <br>";
			return floor($this->Feed_QOH_Tonnes + ($daysDifference * $this->Herd_Size * $this->Feed_Rate_Kg_Day / 1000));
		}
	}
	
	public function getLastDelivery()
	{
		
		return Delivery::find()
					->joinWith('customerOrder')
					->where(['Customer_id' => $this->id, Delivery::tablename().'.status' => Delivery::STATUS_COMPLETED])
					->orderBy(Delivery::tablename().'.delivery_on DESC')
					->one();
					
					
	}


	public function getLastDeliveryBefore($date)
	{
		
		$lastDelivery = Delivery::find()
					->joinWith('customerOrder')
					->where(['Customer_id' => $this->id, Delivery::tablename().'.status' => Delivery::STATUS_COMPLETED])
					->andWhere(Delivery::tablename().'.delivery_on < '.date("Y-m-d", $date))
					->orderBy(Delivery::tablename().'.delivery_on DESC')
					->one();
	}


	public function updateFeedRates($delivery)
	{
		//If there is no delivery then dont do anything
		if($delivery)
			{
			$delivery->customerOrder->client->Feed_QOH_Tonnes = $delivery->delivery_qty + $delivery->customerOrder->Feed_QOH_Tonnes - ($delivery->return ? $delivery->return->amount : 0);
			$delivery->customerOrder->client->Feed_Rate_Kg_Day = $delivery->customerOrder->Feed_Rate_Kg_Day;
			$delivery->customerOrder->client->Feed_QOH_Update = $delivery->delivery_on;
			$delivery->customerOrder->client->Herd_Size = $delivery->customerOrder->Herd_Size;
			$delivery->customerOrder->client->save();	
			}
	}

	public function getAnticipatedSales($user_id = null)
	{
		
		//Get the list of clients
		if($user_id != null)
			{
			$clientsList = Clients::find()
						->where(['Owner_id' => $user_id, 'Is_Customer' => true])
						->andWhere(['in', 'Sales_Status', [Clients::SALES_STATUS_CURRENT, Clients::SALES_STATUS_INTER]])
						->select(['id', 'Company_Name', 'Account_Number', 'Feed_QOH_Tonnes', 'Feed_QOH_Update', 'Feed_Rate_Kg_Day', 'Herd_Size'])

						->all();
			}
		else{
			$clientsList = Clients::find()
						->where(['Is_Customer' => 1, 'Credit_Hold' => false])
						->andWhere(['in', 'Sales_Status', [Clients::SALES_STATUS_CURRENT, Clients::SALES_STATUS_INTER]])
						->select(['Feed_QOH_Tonnes', 'Feed_QOH_Update', 'Feed_Rate_Kg_Day', 'Herd_Size'])

						->all();
			}		
		
		$salesArray = array();
		foreach($clientsList as $client)
			{
			$salesArray[$client->id] = [
					'id' => $client->id,
					'Company_Name' => $client->Company_Name, 
					'Account_Number' => $client->Account_Number, 
					'Feed_QOH_Tonnes' => $client->getFeedQOH(),
					'Herd_Size' => $client->Herd_Size,
					'Feed_Rate_Kg_Day' => $client->Feed_Rate_Kg_Day,
					'Feed_Days_Remaining' => $client->getFeedDaysRemaining()
					];
			}
		
		foreach ($salesArray as $key => $row) 
			{
		    $Feed_Days_Remaining[$key]  = $row['Feed_Days_Remaining'];
			}
			
		asort($Feed_Days_Remaining, SORT_NUMERIC );
			
		array_multisort($Feed_Days_Remaining, SORT_ASC, $salesArray);
		
		return $salesArray;
	}



	public function getDailySalesFigures()
	{
		$testDate = mktime(0,0,0,5,26,2016);
		$orderList = CustomerOrders::find()
						->joinWith('delivery')
						->where(['delivery_on' => date('Y-m-d', $testDate)])
						->all();
			
		$salesArray = array();			
		foreach($orderList as $order)
			{
				
			$ordered = $order->Qty_Tonnes;
			$dispatched =  $order->delivery->delivery_qty;
			if($order->delivery->return)
				{
				$returned = $order->delivery->return->amount;
				}
			else{
				$returned = 0;	
				}
			
				
			if(array_key_exists($order->Customer_id, $salesArray))
				{
				$salesArray[$order->Customer_id]['ordered'] += $ordered;
				$salesArray[$order->Customer_id]['dispatched'] += $dispatched;
				$salesArray[$order->Customer_id]['returned'] += $returned;
				$salesArray[$order->Customer_id]['difference'] = $salesArray[$order->Customer_id]['ordered'] - ($salesArray[$order->Customer_id]['dispatched'] + $salesArray[$order->Customer_id]['returned']);
				}
			else{
				$salesArray[$order->Customer_id] = array(
						'id' => $order->Customer_id,
						'client_name' => $order->client->Company_Name,
						'ordered' => $ordered,
						'dispatched' => $dispatched,
						'returned' => $returned,
						'difference' => $ordered - ($dispatched + $returned),
						);
				}
			
			}
			
		return $salesArray;
						
	}
	
	
	
	public function isOnCreditHold()
	{
		return ($this->Credit_Hold == True);
	}
}

