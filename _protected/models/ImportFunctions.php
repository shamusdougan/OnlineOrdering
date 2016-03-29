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
   
    public function importCustomerOrdersCRM()
		{
			
		$headerRowColumns = 
			[
			'Order ID',
			'Customer',
			'Name',
			'Qty (Tonnes)',
			'Nearest Town',
			'Date Submitted',
			'Date Fulfilled',
			'Discount %',
			'Discount (p/T)',
			'Discount notation',
			'Discount type',
			'Order instructions',
			'Price (p/T)',
			'Price production (p/T)',
			'Price transport (p/T)',
			'Price Total (p/T)',
			'Storage Unit',
			];
		
		if(!file_exists($this->file))
			{
			$this->progress .= "Unable to open Excel Document\n";
			return;
			}
		
		//Parse the file as an Excel file
		$this->progress .= "importing records from ".$this->file."\n";
		try {
			$inputFileType = \PHPExcel_IOFactory::identify($this->file);
 			$objReader = \PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($this->file);
			}
		catch(Exception $e){
			$this->progress .= 'ERROR loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage."\n";
			}
			
		
		$sheet = $objPHPExcel->getSheet(0)->toArray(null, true, true, true);
		
		//$highestRow = $sheet->getHighestRow(); 
		//verify the structure of the file is correct and we have the importantant Column
		//Check that the header row is correct
		$headerRow = array_shift($sheet);
		
		//This section will create an array of indexs, this allows the export out of CRM to not be as rigid, we only care that the export has
		//the columns that we need to recreate the order in this application
		$columnIndexs = array();
		foreach($headerRowColumns as $headerColumn)
			{
			$colIndex = array_search($headerColumn, $headerRow, TRUE);
			if($colIndex === false)
				{
				$this->progress .= "unable to locate column: ".$headerColumn." in import file\n";
				return;
				}
			$columnIndexs[$headerColumn] = $colIndex;
			}
			
		
	
		//iterate through the sheet rows creating an order per row
		foreach($sheet as $rowNum => $rowArray)
			{
			$customerOrder = new CustomerOrders;
			$customer = Clients::find()->where(['Company_Name' => $rowArray[$columnIndexs['Customer']]])->one();	
			if(!$customer){
				$this->progress .= "WARNING: unable to locate customer record from name: ".$rowArray[$columnIndexs['Customer']]." for Order record: ".$rowArray[$columnIndexs['Order ID']]."\n";
				$this->recordsFailed++;
				return null;
				}
				
			$customerOrder->Customer_id = $customer->id;	
			$customerOrder->Order_ID = $rowArray[$columnIndexs['Order ID']];
			$customerOrder->Name = $rowArray[$columnIndexs['Name']];
			$customerOrder->Qty_Tonnes =  $rowArray[$columnIndexs['Qty (Tonnes)']];
			$customerOrder->Nearest_Town = $rowArray[$columnIndexs['Nearest Town']];
			$customerOrder->Date_Submitted  = $this->exceltoepoch($rowArray[$columnIndexs['Date Submitted']]);
			$customerOrder->Date_Fulfilled  = $this->exceltoepoch($rowArray[$columnIndexs['Date Fulfilled']]);
			
			
			
			$customerOrder->Mix_Type = $rowArray[$columnIndexs['Qty (Tonnes)']];
			}
		
		
		
		
		
		
		
			/*
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
		
		*/
		
		
		
		
		
			
		
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
    
    
   
   
   
   public function importCustomerOrders()
   {
   	//parse the excel file, if any thing is a little off then redisplay the file upload screen
		$basePath = Yii::getAlias('@runtime').'/csv/';
		$dataProvider = ProductsPrices::getDataProviderFromExcel($basePath.$filename);
		if(is_string(($dataProvider)))
			{
			Yii::$app->session->setFlash('error', $dataProvider);
			$this->redirect('/import-functions/import-price-sheet');
			}
		
		//Clear any existing Pricing for the given date
		$targetDate = strtotime($columnName);
		$productLookupList = Product::getBaseProductCodeLookup();
		ProductsPrices::bulkDeleteDate($targetDate);
		
		
		foreach($dataProvider->getModels() as $productPriceArray)
			{
			if(!array_key_exists($columnName, $productPriceArray) || !array_key_exists('Product Code', $productPriceArray))
				{
				Yii::$app->session->setFlash('error', "Unable to get specified column data from Excel File, missing Column: ".$columnName);
				$this->redirect('/import-functions/import-price-sheet');
				}
			if($productPriceArray[$columnName] != '')
				{
				$productPricingObj = new ProductsPrices();
				$productPricingObj->product_id = $productLookupList[$productPriceArray['Product Code']];
				$productPricingObj->date_valid_from = date("Y-m-d", $targetDate);
				$productPricingObj->price_pt = $productPriceArray[$columnName];
				if(!$productPricingObj->save())
					{
					print_r($productPricingObj->getErrors());
					}	
				}
			}		
		$this->redirect('/product/update-pricing');
		
		
   }
    
    
    
    
    
    
    
   }

