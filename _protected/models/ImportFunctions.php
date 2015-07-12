<?php

namespace app\models;

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



		
  

    
    
    
    
    
   }
