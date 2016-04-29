<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "trucks".
 *
 * @property integer $id
 * @property string $registration
 * @property string $description
 * @property integer $CreatedBy
 * @property integer $defaultTrailer
 * @property string $SpecialInstruction
 * @property integer $Status
 * @property integer $Auger
 * @property integer $Blower
 * @property integer $Tipper
 * @property integer $max_trailers
 */
class Trucks extends \yii\db\ActiveRecord
{
    
    
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 1;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trucks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['registration', 'Status'], 'required'],
            [['CreatedBy', 'Status', 'Auger', 'Blower', 'Tipper', 'max_trailers'], 'integer'],
            [['registration', 'mobile'], 'string', 'max' => 200],
            [['description', 'Special_Instruction'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'registration' => 'Registration',
            'description' => 'Description',
            'CreatedBy' => 'Created By',
            'max_trailers' => 'Max Trailers',
            'Status' => 'Status',
            'Auger' => 'Auger',
            'Blower' => 'Blower',
            'Tipper' => 'Tipper',
        ];
    }
    
    
    
    
  
    /**
	* 
	* 
	* DEscription: this function reutrns a list of trucks that are available on given date
	* 
	* Truck availability Rules
	* 
	* Get full list of the trucks and a full list of deliveries for that day
	* Go through the list of deliveries
	* 		if the given truck has been assigned to a delivery
	* 			if it has then check - if it has a trailer that has bins free -> Allow
	* 			if it doesn't have any free bins remove it from the array
	*		if it hasn't been assigned then allow 
	* @return
	*/
    public function getTrucksUsageArray($requestedDate)
    	{
		
	
		$deliveryLoadsOnDate = DeliveryLoad::find()
						->where(['delivery_on' => date("Y-m-d", $requestedDate )])
						->all();
		
		
	
		
		//create the basic truck array assuming every truck is on delivery run 1
		$truckUsageArray = array();
		foreach($deliveryLoadsOnDate as $deliveryLoad)
			{
			if(array_key_exists($deliveryLoad->delivery_run_num, $truckUsageArray) && array_key_exists($deliveryLoad->truck_id, $truckUsageArray[$deliveryLoad->delivery_run_num]))
				{
				$truckUsageArray[$deliveryLoad->delivery_run_num][$deliveryLoad->truck_id] -= $deliveryLoad->load_qty;
				}
			else
				{
				$truckUsageArray[$deliveryLoad->delivery_run_num][$deliveryLoad->truck_id] = ($deliveryLoad->getTrailerCapacity() - $deliveryLoad->getLoadVolume());

				}
			}
		
		
		return $truckUsageArray;
		}
    
    
    
    
    
    
    public function getActive()
    {
		return Trucks::find()->where(['Status' => Trucks::STATUS_ACTIVE])->all();
	}
    
    public function getActiveList()
    {
		$truckList = ArrayHelper::map(Trucks::find()->where(['Status' => Trucks::STATUS_ACTIVE])->all(), 'id', 'registration');
		
		return array(0 => 'None') + $truckList;
		
		
	}
    
    /**
	* 
	* Function: isTruckAssigned($requestedDate)
	* Description: checks to see if the truck has been assigned on the requested date. If it has then return an array of the trailers assigned for that date
	* 
	* 
	* @return
	*/
    function  isTruckAssigned($requestedDate)
    	{
		
		$deliveryLoads = DeliveryLoad::find()
						->where(['delivery_load.delivery_on' => date("Y-m-d", $requestedDate ), 'truck_id' => $this->id])
						->all();
	
	
		
		
		$assigned = false;
		$trailersAssignedArray = array();
		
		foreach($deliveryLoads as $deliveryLoad)
			{
			if($this->id == $deliveryLoad->truck_id)
				{
				$assigned = true;
				foreach($deliveryLoad->deliveryLoadTrailer as $deliveryLoadTrailer)
					{
					$trailersAssignedArray[$deliveryLoad->delivery_run_num][$deliveryLoadTrailer->trailer->id] = $deliveryLoadTrailer->trailer;
					}
				}
			}
			
		if($assigned)
			{
			return $trailersAssignedArray;
			}
		return false;
						
						
	}
    
    /**
	* 
	* Function isUsedAlready
	* 
	* Descriptuion: checks to see if the current truck has already been assigned, if so returns the delivery load Id of the first time it has been assigned
	* 
	* @param undefined $requestedDate
	* @param undefined $deliveryrun_id
	* 
	* @return
	*/
    public function isUsedAlready($requestedDate, $deliveryrun_id)
    	{
		$deliveryLoads = DeliveryLoad::find()
						->where(['delivery_load.delivery_on' => date("Y-m-d", $requestedDate ), 'truck_id' => $this->id])
						->all();	
					
	
				
		foreach($deliveryLoads as $deliveryLoad)
			{
				
			
			if($this->id == $deliveryLoad->truck_id && $deliveryrun_id == $deliveryLoad->delivery_run_num)
				{
				
				return $deliveryLoad->id;
				}
			}
		
		return false;
		}
    
    
    
   


    
    
    
    public function getFilterList()
    {
		$trucks = Trucks::find()->where(['Status' => Trucks::STATUS_ACTIVE])->all();
		$filterList =  ArrayHelper::map($trucks, 'id', 'registration');
		return $filterList;
		
	}
	
	
	public function getTrucksUsed($requestedDate)
	{
		
		
		$deliveryLoads = DeliveryLoad::find()
					->where(['delivery_on' => $requestedDate])
					->all();		
		$trucksUsedArray = array();	
		foreach($deliveryLoads as $deliveryLoad)
			{
			$trucksUsedArray[$deliveryLoad->truck_run_num][$deliveryLoad->truck_id] = $deliveryLoad->truck_id;
			}
			
		
		return $trucksUsedArray;
	}



	/**
	* 
	* @param undefined $truck_id
	* @param undefined $trailer1_id
	* @param undefined $trailer2_id
	* 
	* This function returns a list of errors if there are any problems with the combination of the load out
	*/
	public function checkTruckLoad($truck_id, $trailer1_id, $trailer2_id=null, $load_total)
	{
	$errors = array();
	
	$truck = Trucks::findOne($truck_id);
	$trailer1 = Trailers::findOne($trailer1_id);
	$trailer2 = Trailers::findOne($trailer2_id);
	
	//First check to see of the Truck has more trailers than it can handle
	if(isset($trailer2) && $truck->max_trailers == 1)
		{
		$errors[] = "Truck: ".$truck->registration." can only move a maximum of ".$truck->max_trailers." trailer.";
		}
	
	
	
	//Check to see the types are compatable
	if($trailer1->Auger && $trailer1->Blower)
		{
		if(!($truck->Auger || $truck->Blower))
			{
			$errors[] = "Trailer ".$trailer1->Registration." requires a truck with Auger or Blower.";
			}
		}
	else{
		if($trailer1->Auger)
			{
			if(!($truck->Auger))
				{
				$errors[] = "Trailer ".$trailer1->Registration." requires a truck with Auger.";
				}
			}
		if($trailer1->Blower)
			{
			if(!$truck->Blower)
				{
				$errors[] = "Trailer ".$trailer1->Registration." requires a truck with a Blower.";
				}
			}
		}
	
	if($trailer1->Tipper)
		{
		if(!$truck->Tipper)
			{
			$errors[] = "Trailer ".$trailer1->Registration." requires a truck with a Tipper.";
			}
		}	
		
		
		
		
		
			
	if(isset($trailer2))
		{
		if($trailer2->Auger && $trailer2->Blower)
			{
			if(!($truck->Auger || $truck->Blower))
				{
				$errors[] = "Trailer ".$trailer2->Registration." requires a truck with Auger or Blower.";
				}
			}
		else{
			if($trailer2->Auger)
				{
				if(!($truck->Auger))
					{
					$errors[] = "Trailer ".$trailer2->Registration." requires a truck with Auger.";
					}
				}
			if($trailer2->Blower)
				{
				if(!$truck->Blower)
					{
					$errors[] = "Trailer ".$trailer2->Registration." requires a truck with a Blower.";
					}
				}
			}
		
		if($trailer2->Tipper)
			{
			if(!$truck->Tipper)
				{
				$errors[] = "Trailer ".$trailer2->Registration." requires a truck with a Tipper.";
				}
			}	
		}
	
	return $errors;
	}



	public function getTruckTypeString()
	{
		$returnString = '';
		if($this->Auger)
			{
			$returnString .= "Aug ";
			}
		if($this->Tipper)
			{
			$returnString .= "Tip ";
			}
		if($this->Blower)
			{
			$returnString .= "blo ";
			}
					
		return $returnString;
		
	}


	
}
