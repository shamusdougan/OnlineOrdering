<?php

namespace app\models;
use webvimark\modules\UserManagement\models\User;

use Yii;

/**
 * This is the model class for table "import_functions".
 *
 * @property integer $id
 * @property string $name
 * @property string $function
 */
class ImportFunctions extends \yii\db\ActiveRecord
{
	
	
	public $file;
	public $progress;
	public $recordsImported;
	public $recordsFailed;

	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'import_functions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'function'], 'string', 'max' => 100],
            [['file'], 'file']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'function' => 'Function',
        ];
    }
    
    public function initImport()
    	{
    	$this->progress = "Starting the import process for records\n";
    	$this->recordsFailed = 0;
    	$this->recordsImported = 0;
		}

    public function closeImport()
    	{
    	$this->progress .= "Inported ".$this->recordsImported." records with no errors\n";
    	$this->progress .= "Inported ".$this->recordsFailed." records with ERRORS, check output for further information\n";
    	}
   
    public function importCustomerOrdersCRM($importArray)
		{
			
		//	var_dump($importArray);
		//$this->progress .= "importing record for ".$importArray[3]." client"
		
		//This array discribes the relationship between the database attribute and the column that atttribute is found in on the import CSV
		$mapping = [
			'Order_ID' => 0,
			'Customer_id' => 1,
			'Name' => 2,
			'Mix_Type' => 3,
			'Qty_Tonnes' => 4,
			'Nearest_Town' => 5,
			'Date_Fulfilled' => 6,
  			'Date_Submitted' => 7,
  			'Status_Reason' => 8,
  			'Anticipated_Sales' => 9,
  			'Billing_company' => 22,
  			'Billing_type' => 26,
  			'Created_By' => 28,
  			'Created_On' => 30,
  			'Delivery_created' => 35,
  			'Discount_Percent' => 37,
  			'Discount_pT' => 38,
  			'Discount_pT_Base' => 39,
  			'Discount_notation' => 40,
  			'Discount_type' => 41,
  			'Feed_Days_Remaining' => 43,
  			'Feed_QOH_Tonnes' => 44,
  			'Feed_Rate_Kg_Day' => 45,
  			'Feed_Type' => 46,
  			'Herd_Size' => 50,
  			'Load_Due' => 57 ,
  			'Modified_By' => 59,
  			'Modified_On' => 61,
  			'Order_instructions' => 66,
  			'Order_notification' => 67,
  			'Owner' => 68,
  			'Price_pT' => 72,
  			'Price_pT_Base' => 73,
  			'Price_Production' => 75,
  			'Price_Production_Base' => 76 ,
  			'Price_production_pT' => 77,
  			'Price_production_pT_Base' => 78,
  			'Price_Sub_Total' => 79,
  			'Price_Sub_Total_Base' => 80,
  			'Price_Total' => 81,
  			'Price_Total_Base' => 82,
  			'Price_Total_pT' => 83,
  			'Price_Total_pT_Base' => 84,
  			'Price_Transport' => 85,
  			'Price_Transport_Base' => 86,
  			'Price_transport_pT' => 87,
  			'Price_transport_pT_Base' => 88,
  			'Process' => 91,
  			'Process_Stage' => 92,
  			'Product_Category' => 94,
  			'Product_Name' => 95,
  			'Requested_Delivery_by' => 98,
  			'Second_Customer' => 99,
  			'Second_customer_Order_percent' => 100,
  			'Ship_To' => 101,
  			'Status' => 119,
  			'Storage_Unit' => 120,
  			'Submitted_Status' =>121,
  			'Submitted_Status_Description' => 122
		];
		
		
		
		
		$customerOrder = new CustomerOrders;
		
		
		$customer = Clients::find()->where(['Company_Name' => $importArray[$mapping['Customer_id']]])->one();
		if(!$customer){
			$this->progress .= "WARNING: unable to locate customer record from name: ".$importArray[$mapping['Customer_id']]." for Order record: ".$importArray[$mapping['Order_ID']]."\n";
			$this->recordsFailed++;
			return null;
			}
			
		//$this->progress .=  $importArray[$mapping['Order_ID']];
		$customerOrder->Order_ID = $importArray[$mapping['Order_ID']];
		$customerOrder->Customer_id = $customer->id;
		$customerOrder->Name = $importArray[$mapping['Name']];
		$customerOrder->Mix_Type = $importArray[$mapping['Mix_Type']];
		$customerOrder->Qty_Tonnes = $importArray[$mapping['Qty_Tonnes']];
		$customerOrder->Nearest_Town = $importArray[$mapping['Nearest_Town']];
		$customerOrder->Date_Fulfilled = $this->exceltoepoch($importArray[$mapping['Date_Fulfilled']]);
		$customerOrder->Date_Submitted = $this->exceltoepoch($importArray[$mapping['Date_Submitted']]);
		$customerOrder->Status_Reason = $importArray[$mapping['Status_Reason']];
		
		//$this->progress .= "import record for customer id ".$customer->id."\n";
		//$this->progress .= $customer->id."\n";
		
		
		
		
		
		
		
			
		$this->recordsImported++;
			
		}
    
    
    public function importTrucksCRM($importArray)
		{
		
		//array to tell us wich coluns of the csv file correspond to which attributes of the model
		$mapping = [
			'registration' => 0,
			'mobile' => 1,
			'description' => 2,
			'Special_Instruction' => 7,
			'Status' => 8,
			'Auger' => 9,
			'Blower' => 10,
  			'Tipper' => 11,
			];
			
			
		$truck = new trucks();
		
		//iterate through each of the mapping fields and assign that attirbute the value from the csv. Any 
		//unique mappings for an attribute are specfied using the if statement, finally if there are none matched then just map the field
		//straight across.
		foreach($mapping as $attribute => $csvColNum)
			{
			if($attribute == "Status")
				{
				$truck->Status = ($importArray[$csvColNum] == "Active" ? 1 : 0);
				}
			elseif($attribute == "Auger" || $attribute == "Blower" || $attribute == "Tipper")
				{
				$truck->$attribute = ($importArray[$csvColNum] == "No" ? 0 : 1);
				}
			else{
				$truck->$attribute = $importArray[$csvColNum];	
				}
			}
		$truck->CreatedBy = 1;
			
			
			
		if(strcmp($importArray[0], "Truck Registration") === 0){
			$this->progress .= "Header Field found skipping line\n";
			}
		elseif($truck->save())
			{
			$this->recordsImported++;	
			}
		else{
			foreach($truck->getErrors() as $errorField => $error)
				{
				$this->progress .= "error importing field ".$errorField." error: ".$error[0]."\n";
				}
			$this->recordsFailed++;	
			}
		}
		
		
		
	 public function importTrailersCRM($importArray)
		{
		
		//array to tell us wich coluns of the csv file correspond to which attributes of the model
		$mapping = [
			'Registration' => 0,
			'Description' => 1,
			'Max_Capacity' => 2,
			'NumBins' => 3,
			'Auger' => 4,
			'Blower' => 5,
  			'Tipper' => 6,
			'Status' => 7,
			];
			
			
		$truck = new trailers();
		
		//iterate through each of the mapping fields and assign that attirbute the value from the csv. Any 
		//unique mappings for an attribute are specfied using the if statement, finally if there are none matched then just map the field
		//straight across.
		foreach($mapping as $attribute => $csvColNum)
			{
			if($attribute == "Status")
				{
				$truck->Status = ($importArray[$csvColNum] == "Active" ? 1 : 0);
				}
			elseif($attribute == "Auger" || $attribute == "Blower" || $attribute == "Tipper")
				{
				$truck->$attribute = ($importArray[$csvColNum] == "No" ? 0 : 1);
				}
			else{
				$truck->$attribute = $importArray[$csvColNum];	
				}
			}
			
			
			
		if(strcmp($importArray[0], "Trailer Rego") === 0){
			$this->progress .= "Header Field found skipping line\n";
			}
		elseif($truck->save())
			{
			$this->recordsImported++;	
			}
		else{
			foreach($truck->getErrors() as $errorField => $error)
				{
				$this->progress .= "error importing field ".$errorField." error: ".$error[0]."\n";
				}
			$this->recordsFailed++;	
			}
		}
    
	
	 public function importTrailerBinsCRM($importArray)
		{
		
		//array to tell us wich coluns of the csv file correspond to which attributes of the model
		$mapping = [
			'trailer_id' => 0,
			'BinNo' => 1,
			'MaxCapacity' => 2,
			'Status' => 5,
			];
			
			
		$trailerBin = new TrailerBins();
		
		//iterate through each of the mapping fields and assign that attirbute the value from the csv. Any 
		//unique mappings for an attribute are specfied using the if statement, finally if there are none matched then just map the field
		//straight across.
		foreach($mapping as $attribute => $csvColNum)
			{
			if($attribute == "Status")
				{
				$trailerBin->Status = ($importArray[$csvColNum] == "Active" ? 1 : 0);
				}
			elseif($attribute == "trailer_id" )
				{
				$trailer = Trailers::find()->where(['Registration' => $importArray[$mapping['trailer_id']]])->one();
				if(isset($trailer->id))
					{
						$trailerBin->trailer_id = $trailer->id;
					}
				else{
					$this->progress .= "Unable to locate trailer that this bin belongs 2 BinNo: ".$trailerBin->BinNo."\n";
					}
				}
			else{
				$trailerBin->$attribute = $importArray[$csvColNum];	
				}
			}
			
			
			
		if(strcmp($importArray[0], "Trailer") === 0){
			$this->progress .= "Header Field found skipping line\n";
			}
		elseif($trailerBin->save())
			{
			$this->recordsImported++;	
			}
		else{
			foreach($trailerBin->getErrors() as $errorField => $error)
				{
				$this->progress .= "error importing field ".$errorField." error: ".$error[0]."\n";
				}
			$this->recordsFailed++;	
			}
		}
	
	
	
    function exceltoepoch($whackyexceltime) {
			// intify 
			$int_portion = (int)$whackyexceltime;	
			// get the decimals
			$dec_portion = $whackyexceltime - $int_portion;
			// $int portion is days since Jan 1, 1900.
			$epoch = new \DateTime('1900-01-01');
			// remove 2 seems to be the magic number of days to remove.   
			$epoch->add(new \DateInterval("P".($int_portion-2)."D"));
			// get the seconds that are left
			$sec = ceil(86400 * $dec_portion);
			// add the second to the epoch
			$epoch->add(new \DateInterval("PT".$sec."S"));
			$ret = $epoch->getTimestamp();
			unset($epoch);
			//echo date("D, d M Y H:i:s", $ret) ."\n\n";
			return $ret;
		}



	function importCRMUsers($importArray)
	{
		$mapping = [
			'username' => 9,
			'firstname' => 6,
			'surname' => 7,
			'email' => 9,
			];
			
			
		$user = new User();
			
		//iterate through each of the mapping fields and assign that attirbute the value from the csv. Any 
		//unique mappings for an attribute are specfied using the if statement, finally if there are none matched then just map the field
		//straight across.
		foreach($mapping as $attribute => $csvColNum)
			{
			if(!array_key_exists($csvColNum, $importArray))
				{
				$this->recordsFailed++;
				$this->progress .= "Error index to large for row of data. check the mapping array\n";
				}
			else{
				$user->$attribute = $importArray[$csvColNum];		
				}
			
			}
		$user->status = 1;
		$user->email_confirmed = 1;
		$user->created_at = time();
		$user->updated_at = time();
			
		if(strcmp($importArray[0], "Full Name") === 0){
			$this->progress .= "Header Field found skipping line\n";
			}
		elseif($user->save())
			{
			$this->recordsImported++;	
			}
		else{
			foreach($user->getErrors() as $errorField => $error)
				{
				$this->progress .= "error importing field ".$errorField." error: ".$error[0]."\n";
				}
			$this->recordsFailed++;	
			}	
			
	}
  

   
   
   function correctOwnerDetails($importArray)
   {
   
   		$mapping = [
			'AccountNumber' => 0,
			'currentOwner' => 1,
			'NewOwner' => 2,
			];
   	
   	
   		$client = Clients::findOne(['Account_Number' => $importArray[$mapping['AccountNumber']]]);
   		if($client == null)
   			{
			$this->progress .= "Failed to find Client with Accounts number: ".$importArray[$mapping['AccountNumber']]."\n";
			return;
			}
			
		$client->Owner_id = $importArray[$mapping['NewOwner']];
		$client->scenario  = 'bulkModify';
		if(!$client->save())
			{
			$this->progress .= "Failed to update Client: ".$client->Company_Name." with new owner id: ".$importArray[$mapping['NewOwner']]."\n";
			return;
			}
   		
   		$this->progress .= "Updated Client: ".$client->Company_Name." with new owner id: ".$importArray[$mapping['NewOwner']]."\n";
   		return;
   	
   } 
    
   
   
   function importIngredients($importArray, $product_id)
   {
   		$mapping = [
   			'product_ingredient_id' => 0,
   			'ingredient_percent' => 2,
   			];
   			
   		$product_ingredient = new ProductsIngredients();
   		$product_ingredient->product_id = $product_id;
   		$product_ingredient->created_on = date("Y-m-d");
   		$product_ingredient->ingredient_percent = $importArray[$mapping['ingredient_percent']];
   		
   		
   		$productObj = Product::find()
   						->where(['Product_ID' => $importArray[$mapping['product_ingredient_id']]])
   						->One();
   		
   	
   		if(strcmp($importArray[0], "Ingredient Code") === 0){
   			$this->progress .= "Header Field found skipping line\n";
   			return;
   			}
   		elseif(!$productObj)
   			{
			$this->progress .= "Unable to find Product with id: ".$importArray[$mapping['product_ingredient_id']]." Please check the id and try again\n";
			$this->recordsFailed++;	
			return;
			}
		elseif($productObj->Mix_Type != Product::MIXTYPE_BASE)
			{
			$this->progress .= "You cannot add a compound object as an ingredient product id: ".$importArray[$mapping['product_ingredient_id']]."\n";
			$this->recordsFailed++;	
			return;
			}
			
		$product_ingredient->product_ingredient_id = $productObj->id;
			
   		if(!$product_ingredient->save())
			{
			$this->progress .= "Failed to update Product Ingredient: ".$product_ingredient->id." for product id: ".$product_id."\n";
			foreach($product_ingredient->errors as $errorMessage)
				{
				$this->progress .= $errorMessage[0]."\n";	
			
				}
			$this->recordsFailed++;	
	
			}
		else{
			$this->progress .= "Creating new Product Ingredient for product id: ".$product_id."\n";
			$this->recordsImported++;
			return $product_ingredient->ingredient_percent;
			}
			
		return 0;
   } 
    
    
   
    
    
    
    
    
    
    
   }

