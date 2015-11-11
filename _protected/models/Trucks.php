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
            'max_trailers' => 'Max Trailers2',
            'Status' => 'Status',
            'Auger' => 'Auger',
            'Blower' => 'Blower',
            'Tipper' => 'Tipper',
        ];
    }
    
    
    public function getDefaultTrailers()
    	{
			return $this->hasMany(TrucksDefaultTrailers::className(), ['truck_id' => 'id'] );
		}
    
   
    public function getDefaultTrailersList()
    	{
 
 			$returnArray = [];
			foreach($this->defaultTrailers as $defaultTrailer)
				{
				$returnArray[] = $defaultTrailer->trailer->Registration;
				}
				
			return implode($returnArray, ",");
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
    
    
    
    /**
	* 
	* 
	* @return
	*/
	public function removeDefaultTrailers()
	{
	
	foreach($this->defaultTrailers as $defaultTrailer)
		{
		$defaultTrailer->delete();
		}

	return Trucks::findOne($this->id);
	}


	public function listDefaultTrailers()
	{
		$trailerList = [];
		foreach($this->defaultTrailers as $defaultTrailer)
		{
		$trailerList[] = $defaultTrailer->trailer_id;
		}
		
		return $trailerList;
	}    
    
}
