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
		$attributesRows = [
			'Order_ID' => 0,
			'Customer_id' => 1,
			'Name' => 2,
			'Mix_Type' => 3,
			'Qty_Tonnes' => 4,
			'Nearest_Town' => 5,
			'Date_Fulfilled' => 6,
			'Date_Fulfilled',
  			'Date_Submitted',
  			'Status_Reason',
  			'Anticipated_Sales',
  			'Billing_company',
  			'Billing_type',
  			'Created_By',
  			'Created_On',
  			'Delivery_created',
  			'Discount_',
  			'Discount_pT',
  			'Discount_pT_Base',
  			'Discount_notation',
  			'Discount_type',
  			'Feed_Days_Remaining',
  			'Feed_QOH_Tonnes',
  			'Feed_Rate_Kg_Day',
  			'Feed_Type',
  			'Herd_Size',
  			'Load_Due',
  			'Modified_By',
  			'Modified_On',
  			'Order_instructions',
  			'Order_notification',
  			'Owner',
  			'Price_pT',
  			'Price_pT_Base',
  			'Price_Production',
  			'Price_Production_Base',
  			'Price_production_pT',
  			'Price_production_pT_Base',
  			'Price_Sub_Total',
  			'Price_Sub_Total_Base',
  			'Price_Total',
  			'Price_Total_Base',
  			'Price_Total_pT',
  			'Price_Total_pT_Base',
  			'Price_Transport',
  			'Price_Transport_Base',
  			'Price_transport_pT',
  			'Price_transport_pT_Base',
  			'Process',
  			'Process_Stage',
  			'Product_Category',
  			'Product_Name',
  			'Requested_Delivery_by',
  			'Second_Customer',
  			'Second_customer_Order_percent',
  			'Ship_To',
  			'Status',
  			'Storage_Unit',
  			'Submitted_Status',
  			'Submitted_Status_Description'
		];
		
		
		
		
		//$customerOrder = new CustomerOrders;
		//$customerOrder->Order_ID = $importArray[2];
		
		
		//$this->progress .= $importArray[2]."\n";
		$customer = Clients::find()->where(['Company_Name' => $importArray[$attributesRows['Customer_id']]])->one();
		if(!$customer){
			$this->progress .= "WARNING: unable to locate customer record from name: ".$importArray[$attributesRows['Customer_id']]." for Order record: ".$importArray[$attributesRows['Order_ID']]."\n";
			$this->recordsFailed++;
			return null;
		}
		//$this->progress .= "import record for customer id ".$customer->id."\n";
		//$this->progress .= $customer->id."\n";
		
		
		
		
		
		
		
			
		$this->recordsImported++;
			
		}
    
    
    
    
    
    
    
    
    
    
   }
