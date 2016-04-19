<?php

namespace app\models;
use webvimark\modules\UserManagement\models\User;
use yii\helpers\ArrayHelper;

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
			'Status Reason',
			'Price Total',
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
				$this->progress .= "NO records imported\n";
				return;
				}
			$columnIndexs[$headerColumn] = $colIndex;
			}
			
		
	
		//iterate through the sheet rows creating an order per row
		foreach($sheet as $rowNum => $rowArray)
			{
			
			
			//check for any existing orders to overwrite
			
			$customerOrder = CustomerOrders::findByOrderOrderID($rowArray[$columnIndexs['Order ID']]);
			if($customerOrder)
				{
				$this->progress .= "Found Duplicate Order ID, removing existing order\n";
				$customerOrder->delete();
				}
			
			$customerOrder = new CustomerOrders();
			
			$customerName = preg_replace('/\s+/', ' ', $rowArray[$columnIndexs['Customer']]);
			$customer = Clients::find()->where(['Company_Name' => $customerName])->one();	
			if(!$customer){
				$this->progress .= "WARNING: unable to locate customer record from name: ".$rowArray[$columnIndexs['Customer']]." for Order record: ".$rowArray[$columnIndexs['Order ID']]."\n";
				$this->recordsFailed++;
				break;
				}
				
			$customerOrder->Customer_id = $customer->id;	
			$customerOrder->Order_ID = $rowArray[$columnIndexs['Order ID']];
			$customerOrder->Name = $rowArray[$columnIndexs['Name']];
			$customerOrder->Qty_Tonnes =  $rowArray[$columnIndexs['Qty (Tonnes)']];
			$customerOrder->Nearest_Town = $rowArray[$columnIndexs['Nearest Town']];
			
		
			
			
			$fulfilledDate = $rowArray[$columnIndexs['Date Fulfilled']]; 
			if($fulfilledDate == "" || $fulfilledDate == null)
				{
				$customerOrder->Date_Fulfilled = date("Y-m-d", mktime(0,0,0,1,1,2012));
				}
			else{
				$customerOrder->Date_Fulfilled = date("Y-m-d" ,\PHPExcel_Shared_Date::ExcelToPHP($fulfilledDate ));

				}	
				
			$submittedDate = $rowArray[$columnIndexs['Date Submitted']];
			if($submittedDate == "" || $submittedDate == null)
				{
				$customerOrder->Date_Submitted = $customerOrder->Date_Fulfilled;
				}
			else{
				$customerOrder->Date_Submitted = date("Y-m-d", \PHPExcel_Shared_Date::ExcelToPHP($submittedDate ));
				}
			
			$customerOrder->Created_On = $customerOrder->Date_Submitted;
			$customerOrder->Requested_Delivery_by  = $customerOrder->Date_Fulfilled;
			$customerOrder->Order_instructions = $rowArray[$columnIndexs['Order instructions']];
			$customerOrder->verify_notes = 1;
			$customerOrder->Status = CustomerOrders::STATUS_COMPLETED;

			
			//Process the Name to get the mix type
			$orderName = $rowArray[$columnIndexs['Name']];
			if(stripos($orderName, "Custom"))
				{
				$customerOrder->Mix_Type = CustomerOrders::CUSTOM;
				}
			elseif(stripos($orderName, "Mix"))
				{
				$customerOrder->Mix_Type = CustomerOrders::MIX;
				}
			elseif(stripos($orderName, "Commodity"))
				{
				$customerOrder->Mix_Type = CustomerOrders::COMMODITY;
				}
			elseif(stripos($orderName, "Pellet"))
				{
				$customerOrder->Mix_Type = CustomerOrders::PELLET;
				}
			else{
				$customerOrder->Mix_Type = CustomerOrders::CUSTOM;
				}
			
			//Find the Storage unit for the Customer
			$storageID = $customer->findStorageByName($rowArray[$columnIndexs['Storage Unit']]);
			if(is_string($storageID))
				{
				$this->progress .= "OrderID: ".$customerOrder->Order_ID." -> ".$storageID."\n";
				
				$description = $rowArray[$columnIndexs['Storage Unit']];
				if($description == "")
					{
					$description = "Unknown";
					}
				//create the storage Unit
				$storageUnit = new Storage();
				$storageUnit->Description = $description;
				$storageUnit->company_id = $customer->id;
				$storageUnit->Capacity = 0;
				$storageUnit->Status = Storage::STATUS_ACTIVE ;
				if(!$storageUnit->save())
					{
					$this->progress .= "Unable to create storage unit for customer\n";
					foreach($storageUnit->getErrors() as $fieldname => $error)
						{
						$this->progress .= $fieldname.": ".$error[0]."\n";
						}		
					}
				$storageID = $storageUnit->id;
				$this->progress .= "Created new storage Unit id: ".$storageID." for Client: ".$customer->Company_Name."\n";
				}
			$customerOrder->Storage_Unit = $storageID;
			
			
			//Discounting information
			$customerOrder->Price_pT_Base_override = $rowArray[$columnIndexs['Price (p/T)']];
			$customerOrder->Price_production_pT = (int)$rowArray[$columnIndexs['Price production (p/T)']];
			$customerOrder->Price_transport_pT = (int)$rowArray[$columnIndexs['Price transport (p/T)']];
			$customerOrder->Price_Sub_Total = $customerOrder->Price_pT_Base_override + $customerOrder->Price_production_pT + $customerOrder->Price_transport_pT;
			$customerOrder->Created_By = 1;
			
			
			$customerOrder->Discount_Percent = $rowArray[$columnIndexs['Discount (p/T)']];
			if($customerOrder->Discount_Percent == "" || $customerOrder->Discount_Percent == 0)
				{
				$customerOrder->Discount_type = CustomerOrders::DISCOUNT_NONE;
				$customerOrder->Discount_pT = 0;
				}
			else{
				$customerOrder->Discount_pT = (int)$rowArray[$columnIndexs['Discount (p/T)']];
				$discountType = $rowArray[$columnIndexs['Discount type']];
				if($discountType )
				if(stripos($discountType, "Contract"))
					{
					$customerOrder->Discount_type  = CustomerOrders::DISCOUNT_CONTRACT;
					}
				elseif(stripos($discountType, "Group"))
					{
					$customerOrder->Discount_type  = CustomerOrders::DISCOUNT_GROUP;
					}
				elseif(stripos($discountType, "INFERIOR"))
					{
					$customerOrder->Discount_type  = CustomerOrders::DISCOUNT_INFERIOR;
					}
				elseif(stripos($discountType, "MATCHING"))
					{
					$customerOrder->Discount_type  = CustomerOrders::DISCOUNT_MATCHING;
					}
				elseif(stripos($discountType, "VOLUME"))
					{
					$customerOrder->Discount_type  = CustomerOrders::DISCOUNT_VOLUME;
					}
				else{
					$customerOrder->Discount_type  = CustomerOrders::DISCOUNT_OTHER;
					}
				$customerOrder->Discount_Percent = $rowArray[$columnIndexs['Discount (p/T)']];
				$customerOrder->Discount_notation = $rowArray[$columnIndexs['Discount notation']];
				}
			
			
			$customerOrder->Price_Total = $rowArray[$columnIndexs['Price Total']];
			
		
			
			if(!$customerOrder->Save())
				{
				$this->progress .= "Failed to Save Customer Order for client Name: ".$customerOrder->Name."\n ";
				
				foreach($customerOrder->getErrors() as $fieldname => $error)
					{
					$this->progress .= $fieldname.": ".$error[0]."\n";
					}	
				$this->recordsFailed++;
				}
			else{
				$this->recordsImported++;
				}
			
			
			}
		
		}
		
		
	public function importCustomerOrdersBC($client)
		{
			
		
		
		$columnMappings = 
			[
			'Order_ID' => 'orderNo',
			'Customer_id' => '',
			'Name',
			'Requested_Delivery_by',
			'Storage_Unit',
			'Order_instructions',
			'verify_notes',
			'Qty_Tonnes',
			'Product_Category',
			'Price_pT_Base_override',
			'Price_pT_Base',
			'Price_production_pT',
			'Price_transport_pT',
			'Price_Sub_Total',
			'Price_Total',
			
			
			'Discount_type',
			'Discount_pT',
			'Discount_Percent',
			'Discount_notation',
			
			'Nearest_Town',
			'Date_Fulfilled',
			'Date_Submitted',
			'Created_By',
			'Status',
			
			];


		//	array ( "Blue Cow id", "name", "onlineordering_id")
		$orderPersonID =
			[
			1 => ['Stephen', 2],
			4 => ['Jesse', 2],
			9 => ['Robin ', 30],
			12 => ['trevor', 28],
			14 => ['Madeleine', 19],
			15 => ['Katrina', 2],
			16 => ['Kylie', 2],
			21 => ['Andrew', 2],
			23 => ['Vicky', 29],
			32 => ['Sally', 2],
			25 => ['Jake', 13],
			28 => ['Kristy', 2],
			29 => ['Peter', 24],
			30 => ['Mark', 2],
			31 => ['Bryan', 5],
			33 => ['Adam', 2],
			34 => ['Tim', 2],
			36 => ['Molly', 23],
			37 => ['Heath', 11],
			38 => ['Shane', 26],
			40 => ['Georgina', 10],
			];
		


		$orderComponents = 
			[
			1 =>[ 
				[27, 'Economix', 3002],
				[28,'Irmix', 3000],
				[29,'Premium Mix', 3003],
				[30,'Sustain Mix', 3004],
				[31,'Super Mix', 3005],
				[32,'Beef Feedlot Mix', 3006],
				[34,'20% Calf Starter Meal', 3010],
				[35,'18% Calf Rearer Meal', 3012],
				[36,'Lead Feed Meal', 3013],
				[37,'Unimix', 3001],
				[38,'Production', 1002],
				[39,'Performance', 1003],
				[40,'Premium', 1004],
				[41,'Premium Plus', 1005],
				[48,'3 Way Mix', 0],
				[49,'Calf Starter Pellet', 1006],
				[50,'Calf Rearer Pellet', 0],
				[52,'Leed Feed pellet', 00],
				[53,'Irwin Blend', 3015],
				[54,'20% Calf Beginner Meal', 3010],
				[56,'Oaten Hay', 0],
				[57,'Autumn Special Mix', 0 ],
				[58,'Palm Blend Mix', 3016],
				[59,'Summer Special', 0],
				[60,'Grain Free Pellet', 1013],
				[61,'ACE Farms Mix', 0],
				[62,'Lamb Pellet', 0],
				[66,'Summer Pellet', 1011],
				[65,'Energy Plus Pellets', 0],
				],
			2 => [
				[1,'Wheat', 2001],
				[2,'Barley', 2002],
				[3,'Stock Pellet', 0],
				[4,'Lupins', 2006],
				[5,'Peas', 2008],
				[6,'Canola Meal', 2009],
				[7,'Maize', 2005],
				[8,'PKE', 2013],
				[9,'Biscuit Meal', 2016],
				[11,'Lucerne Chaff', 0],
				[12,'Pea 2nds', 0],
				[13,'Pea Pollards', 2023],
				[14,'Malt Combings', 2015],
				[17,'Oat Bran', 2012],
				[26,'Limestone', 2024],
				[27,'Bentonite', 2025],
				[29,'Choc Malt', 2014],
				[30,'Sorghum', 2004],
				[32,'Sugar', 2039],
				[33,'Oats', 0],
				[34,'barley 2nds', 2017],
				[35,'Cold Pressed Canola Meal', 0],
				[36,'DDG', 2018],
				[37,'Mill Run', 2019],
				[38,'Irwin Blend', 2040],
				[39,'Triticale', 2003],
				[40,'Oaten Hay Milker', 0],
				[41,'Vetch Hay', 2033],
				[42,'Grass Hay',2030],
				[43,'Lucerne Hay', 0],
				[44,'Cotton Seed Meal', 2010],
				[45,'Almond Meal', 2027],
				[46,'Copra Meal', 2011],
				[52,'Veg Oil', 0],
				[48,'Hominie', 2028],
				[49,'Energy Blend', 0],
				[50,'Almond Hulls', 2029],
				[51,'Grape Meal', 2034],
				[53,'Freight', 0],
				[55,'Oaten Hay Feeder', 0],
				[57,'N/F Calciprill DEB596', 0],
				],
			4 => [
				[3,'Availa4 100 (10%)', 4004],
				[4,'Availa4&Cr 100 (10%)', 4004],
				[5,'AvailaCu 100 (10%)', 4001],
				[6,'AvailaZn 100 (10%)', 4003],
				[8,'BIO MOS', 4013],
				[9,'DCP', 4018],
				[10,'Bioplex High five', 0],
				[11,'Biotin', 4014],
				[12,'Bloat Guard', 0],
				[14,'Bloat Oil', 0],
				[15,'Veg Oil', 4034],
				[16,'AL8 Causmag', 4017],
				[17,'Copper Sulphate', 0],
				[19,'Diamond V XPC', 4019],
				[20,'Dolomite', 4020],
				[21,'Epsom Salts', 4022],
				[22,'Eskalin 20 (2%)', 4023],
				[23,'Eskalin 500 (50%)', 0],
				[25,'Mycosorb', 4029],
				[26,'Niacin', 0],
				[27,'Rumensin 100 (10%) Cow', 4109],
				[29,'Salt', 4031],
				[30,'Sel-Plex 2 (0.2%)', 4032],
				[31,'Sodium Bicarb', 4010],
				[32,'Tylan 50 (5%)', 4033],
				[33,'Zinc Oxide', 4036],
				[35,'Irwins Mineral Premix DEB383', 4107],
				[37,'Sugar', 4040],
				[38,'DFM Powder (Yeast)', 4041],
				[39,'Fire Up', 4043],
				[40,'Megalac', 4026],
				[41,'N/F Hi Milker ', 4050],
				[42,'N/F Performer DEB010', 4052],
				[43,'N/F TM2MT DEB013', 4054],
				[44,'N/F Performer+Availa4', 0],
				[45,'N/F Bicarb250 DEB005', 4056],
				[46,'N/F Anionic DEB099', 4057],
				[47,'Best fed Leed Feed', 0],
				[48,'Best Fed Leed Feed Plus', 0],
				[49,'Best Fed First Base', 0],
				[50,'Best Fed Base', 0 ],
				[51,'Best Fed Base Plus', 0 ],
				[54,'Go Cow Tylan', 0],
				[55,'Healthy Herd', 4042],
				[56,'Glo Cow', 4059],
				[57,'Rumensin 100 (10%) Calves', 4109],
				[58,'N/F Performer  Availa4& Cr', 0],
				[61,'Molasses', 0],
				[62,'N/F  ZINC 70  & TM2MT', 0],
				[63,'Get Set Cow', 4061],
				[64,'Soy Chlor', 4077],
				[65,'N/F  TM2M ', 4053],
				[66,'Bloat Shield', 0],
				[67,'Action Yeast', 0],
				[68,'Vitamin E', 0],
				[69,'Notman Pellet', 0],
				[70,'Vitamin B', 4035],
				[71,'Best Fed Finish', 0],
				[72,'Bovatec', 4016],
				[73,'MintrexB',  4027],
				[74,'N/F Summer HiZinc DEB029', 4049],
				[75,'N/F Performer&Biotin DEB018', 4055],
				[76,'Acid Buff', 4000],
				[77,'Elitox', 4021],
				[78,'Eco Go Cow', 4060],
				[79,'5STAR MINERAL PELLET CRC', 0],
				[80,'Absorb 5', 0],
				[81,' 230', 4066],
				[82,'Molasses Sweetener Combo', 4028],
				[83,'Dairy 220 Plus', 4044],
				[84,'N/F Zinc DEB045', 4047],
				[85,'Dairy Max 300', 4071],
				[86,'Dairytech 50 Pellet', 0],
				[87,'Bloat Control E50', 4015],
				[88,'N/F Summer', 4048],
				[89,'AL4 Causmag', 0],
				[90,'A/MAX Yeast', 4068],
				[91,'Ammonium Sulfate', 4064],
				[92,'Protein Plus', 4070],
				[93,'Dairy PreLac 300', 4046],
				[94,'Dairy 200', 0],
				[95,'Rumen Calm - Dairy Tech', 4073],
				[96,'Rumicare-Aus Pac', 4074],
				[97,'Optimin Lacto Max 5', 4079],
				[98,'OmyaCarb 50', 4080],
				[99,'Action Powder', 4084],
				[100,'N/F TM2 Monensin + Magnesium DEB011', 0],
				[101,'N/F Fusion Pellet', 4086],
				[102,'Magnesium Chloride', 4087],
				[104,'Levucell SC10 ME Titan', 4104],
				[105,'Orego Stim', 4105],
				[106,'N/F TM2+MON+MAG+LEVUCEL DEB130', 0],
				[107,'Udder Mate 25 + Se Pellets', 4103],
				[108,'N/F Ellinbank 250 DEBW007', 4091],
				[109, 'unknown Additive', 0],
				[110,'N/F Omnigen DEB111', 4094],
				[111,'Urea', 4089],
				[112,'N/F TM2ME-DEB1504', 0],
				[113,'Ammonium Chloride', 0],
				[114,'Gypsum', 4098],
				[115,'Dairy Prelac 400 + Vicomb', 4078],
				[116,'Pellet Binder', 0],
				[117,'Pharma-lead Close up Premix + Bovatec', 4106],
				[118,'BioPro BPM 125P', 0]
				],
			];			
			
		try{
			$file = fopen("BCclientsOnline.csv","r");	
			}
		catch(Exception $e){
			$this->progress .= 'ERROR loading file "BCclientsOnline.csv": '.$e->getMessage."\n";
			}
		$clientTranslation = array();
		while(! feof($file))
		  {
		  $clientArray = fgetcsv($file);
		  $clientTranslation[$clientArray[2]] = $clientArray;
		  }
		fclose($file);
		$this->progress .= "Starting the import process from the Bluecow Ordering System\n";
		
		
		if(!array_key_exists($client->id, $clientTranslation))
			{
			$this->progress .= "Unable to find the client: ".$client->Company_Name." in the Blue Cow ordering system\n";
			return;
			}
		
	
	
		
		//Get the records for the client from the Blue cow, have set a starting arbituay point		
		$startingDate = "2015-06-01";
		$bcOrders = bc_Ordermaster::find()
						->where("orderDate > '".$startingDate."' And peopleID = ".$clientTranslation[$client->id][0]  )
						->all();
		$this->progress .= count($bcOrders)." Order(s) Found from ".$startingDate."\n";
		
		//Reindex the array for the components becase I hard coded the array and not really keen on recoding the array again :(
		$newOrderComponents = array();
		foreach($orderComponents as $orderType => $componentArray)
			{
			foreach($componentArray as $component)	
				{
				$newOrderComponents[$orderType][$component[0]] = $component;
				}
			}
		
		//For each order fetched, translate into the current system
		foreach($bcOrders as $bcOrder)
			{
			
				
					
			
			$this->progress .= "Translateing order from the ".$bcOrder->orderDate."\n";
			
			$customerOrder = CustomerOrders::find()->where("Order_ID = 'B".$bcOrder->orderNo."'")->one();
			if(!$customerOrder)
				{
				$this->progress .= "Creating a new online ordering order\n";
				$customerOrder = new CustomerOrders();		
				}
			
			
			$customerOrder->Name = "BC".$bcOrder->orderNo;
			$customerOrder->Order_ID = "B".$bcOrder->orderNo;
			
			$customerOrder->Created_On = $bcOrder->orderDate;
			$customerOrder->Customer_id = $client->id;
			$customerOrder->Requested_Delivery_by = $bcOrder->reqDate;
			$customerOrder->Storage_Unit = 0;
			$customerOrder->Order_instructions = $bcOrder->deliveryInstructions;
			$customerOrder->verify_notes = true;
			$customerOrder->Qty_Tonnes = $bcOrder->orderQty;
			$customerOrder->Product_Category = CustomerOrders::CUSTOM;
			$customerOrder->Price_pT_Base_override = $bcOrder->salePrice;
			$customerOrder->Price_pT_Base = 0;
			$customerOrder->Price_production_pT = 0;
			$customerOrder->Price_transport_pT = $bcOrder->deliveryPrice;
			$customerOrder->Discount_type = customerOrders::DISCOUNT_OTHER;
			$customerOrder->Discount_pT = $bcOrder->discount;
			$customerOrder->Discount_notation = $bcOrder->discountReason;
			$customerOrder->Date_Fulfilled = $bcOrder->reqDate;
			$customerOrder->Created_By = $orderPersonID[$bcOrder->orderPersonID][1];
			$customerOrder->Status = CustomerOrders::STATUS_COMPLETED;
			if(!$customerOrder->save())
				{
				$this->outputErrors($customerOrder);
				}				

			//Remove any of the existing ingredients from the database
			$customerOrder->deleteIngredients();
			
			//Recreate each of the ingredients
			foreach($bcOrder->orderlines as $orderLine)
				{
		
				$orderIngredient = new CustomerOrdersIngredients();
				$orderIngredient->created_on = $bcOrder->orderDate;
				
				if($orderLine->orderType == 0)
					{
					$orderLine->orderType = 1;
					}
				elseif($orderLine->orderType == 3)
					{
					continue;
					}
				
			
				//if the product doesn't exist
				if(!array_key_exists($orderLine->componentID, $newOrderComponents[$orderLine->orderType]))
					{

					continue;
					}
				
				$productID = $newOrderComponents[$orderLine->orderType][$orderLine->componentID][2];
				
				//for the case where there is no equivilent product
				if($productID == 0)
					{
					$customerOrder->Order_instructions = "Unknown Product: ".$newOrderComponents[$orderLine->orderType][$orderLine->componentID][1]."\n".$customerOrder->Order_instructions;
					$customerOrder->save();
					continue;
					}
				
				$product = Product::find()->Where('Product_ID = '.$productID)->one();
				if(!$product)
					{
					$this->progress .= "Unable to locate product from orderType: ".$orderLine->orderType." and ComponentID: ".$orderLine->componentID."\n";
					return;
					}
				
				$orderIngredient->ingredient_id = $product->id;
				$orderIngredient->ingredient_percent = $orderLine->orderPercent;
				$orderIngredient->order_id = $customerOrder->id;
				if(!$orderIngredient->save())
					{
					$this->outputErrors($orderIngredient);	
					}
				
				}

			$refreshedOrder = CustomerOrders::findOne($customerOrder->id);
			$refreshedOrder->save();



				
				
				
			


			}
	
		
		
		}
		
		
		
		
	public function importCustomerOrdersIngredientsCRM()
		{
			
		$headerRowColumns = 
			[
			'Order ID (Order) (Customer Order)',
			'Product ID (Ingredient) (Product)',
			'Ingredient %',
			];	
		
		if(!file_exists($this->file))
			{
			$this->progress .= "Unable to open Excel Document\n";
			return;
			}
		
		//Parse the file as an Excel file
		/*
		try {
			$inputFileType = \PHPExcel_IOFactory::identify($this->file);
 			$objReader = \PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($this->file);
			}
		catch(Exception $e){
			$this->progress .= 'ERROR loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage."\n";
			}
		
		$sheet = $objPHPExcel->getSheet(0)->toArray(null, true, true, true);	
		*/
		
		
		try{
			$fp=fopen($this->file, 'r');
			}
		catch(Exception $e){
			$this->progress .= 'ERROR loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage."\n";
			return;
			}
		
		while(! feof($fp))
		   {
		   $sheet[] = fgetcsv($fp);
		   }

		
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
		
		//Iterate through each of the records and create the ingredients for the record
		$modifiedCustomerOrders = array();
		
		foreach($sheet as $rowNum => $rowArray)
			{
			$customerOrder = CustomerOrders::findByOrderOrderID( $rowArray[$columnIndexs['Order ID (Order) (Customer Order)']]);
			if(!$customerOrder)
				{
				$this->progress .= "WARNING: unable to locate customer order from name: ".$rowArray[$columnIndexs['Order ID (Order) (Customer Order)']]."\n";
				$this->recordsFailed++;
				continue;
				}
			
			//Check to see if we have modified this customer order before, if not wipe all the existing ingredients
			if(!array_key_exists($customerOrder->id, $modifiedCustomerOrders))
				{
				$this->progress .= "Removing any existing ingredients\n";
				$customerOrder->deleteIngredients();
				$modifiedCustomerOrders[$customerOrder->id] = $customerOrder;
				}

			
			
			//Create the new order ingredient			
			$ingredient = new CustomerOrdersIngredients();
			$product = Product::getProductByProductCode($rowArray[$columnIndexs['Product ID (Ingredient) (Product)']]);
			if(!$product)
				{
				$this->progress .=  "ERROR unable to locate product by code, given code is: ".$rowArray[$columnIndexs['Product ID (Ingredient) (Product)']]."\n";
				return null;
				}
			
			
			$ingredient->ingredient_id =  $product->id;
			$ingredient->ingredient_percent =  $rowArray[$columnIndexs['Ingredient %']];
			$ingredient->order_id = $customerOrder->id;
			$ingredient->created_on = $customerOrder->Created_On;
			if(!$ingredient->save())
				{
				$this->outputErrors($ingredient);
				}
			else{
				$this->recordsImported++;
				}
			}
			
			
		//Check that the ingredients are correctly added and the order is consistant
		$this->progress .= "\nChecking the modified orders are correct\n";
		foreach($modifiedCustomerOrders as $customerOrder)
			{
			$freshCustomerOrder = CustomerOrders::findOne($customerOrder->id);
			if(!$freshCustomerOrder->checkIngredientsTotal())
				{
				$this->progress .= "Cusomter Order ID: ".$freshCustomerOrder->Order_ID." Failed ingredient sum check, returned total was: ".$freshCustomerOrder->getIngredientsTotal()."\n";
				}
			}
			
			
			
		
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
    
   public function outputErrors($model)
   {
   	$this->progress .= "Unable to Save Object\n";
	foreach($model->getErrors() as $fieldname => $error)
		{
		$this->progress .= "   ".$fieldname.": ".$error[0]."\n";
		}	
   } 
    
    

	public function assignOrdersToOwners()
	{
		
		
	$clientList = $clientObjects = Clients::find()
    				->where('id != :id', ['id'=>Clients::DUMMY])
    				->select(['id', 'Company_Name', 'Owner_id'])
    				->all();
    $clientList = ArrayHelper::map($clientObjects, 'id', 'Owner_id') ;
	$customerOrders = CustomerOrders::find()->select(['Created_By', 'Customer_id'])->all();
	 
	 $recordCount = 0;
	 foreach($customerOrders as $customerOrder)
	 	{
	 	
		$customerOrder->Created_By = $clientList[$customerOrder->Customer_id];
		$customerOrder->scenario = 'setOwner';
		if(!$customerOrder->save())
			{
			$this->outputErrors($customerOrder);
			}
		
		
		
		$recordCount++;
		}
	 
	$this->progress .= $recordCount." Record(s) modifed\n";		
	}


	public function renameAllOrders()
	{
		
	}
    
    
    
}

