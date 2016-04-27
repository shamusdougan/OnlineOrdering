<?php

namespace app\models;

use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "trailers".
 *
 * @property integer $id
 * @property string $Registration
 * @property string $Description
 * @property integer $Max_Capacity
 * @property integer $NumBins
 * @property integer $Auger
 * @property integer $Blower
 * @property integer $Tipper
 * @property integer $Status
 */
class Trailers extends \yii\db\ActiveRecord
{
    
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trailers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Registration', 'Description', 'Max_Capacity', 'NumBins', 'Auger', 'Blower', 'Tipper', 'Status'], 'required'],
            [['Max_Capacity', 'NumBins', 'Auger', 'Blower', 'Tipper', 'Status'], 'integer', 'message' => "Value must be a Number"],
            [['Registration', 'Description'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Registration' => 'Registration',
            'Description' => 'Description',
            'Max_Capacity' => 'Max  Capacity',
            'NumBins' => 'Num Bins',
            'Auger' => 'Auger',
            'Blower' => 'Blower',
            'Tipper' => 'Tipper',
            'Status' => 'Status',
        ];
    }
    
    /**
	* Relationships
	* 
	* 
	*/
    public function getTrailerBins()
    {
		return $this->hasMany(TrailerBins::className(), ['trailer_id' => 'id'] );
	}
    
   	/**
	   * Function: hasAllocatedBins
	   * Description: returns trye/false depnding if any of the bins on this trailer have been used for anything.
	   * 
	   * 
	   * @return
	   */
    public function hasAllocatedBins($requestedDate)
    {
		
	}
    
    
    
    
    /**
	* Function getAll Activetrailers
	* Derscription: returns a list of all the active trailer objects
	* 
	* @return
	*/
    public function getAllActiveTrailers()
    	{
		$trailerList = Trailers::find()
						->where(['Status' => Trailers::STATUS_ACTIVE])
						->all();
						
		return $trailerList;
		}
    
    
   /**
   * 
   * Function getTrailerBinCount
   * 
   **
   */
public function getTrailerBinCount($trailerID)
   	{
	$trailer = Trailers::findOne($trailerID);
	return $trailer->NumBins;
	}
    
    /**
	* 
	* Function isAlreadyAssigned($requestedDate)
	* Description: is will return the booleen if this trailer has already been assigned to a truck on that day.
	* @return
	*/
public function isAlreadyAssigned($requestedDate, $delivery_run_num)
    {
		$usedTrailerList = DeliveryLoadTrailer::find()
						->innerJoinWith('deliveryLoad', false)
						->where(['delivery_load.delivery_on' => date("Y-m-d", $requestedDate )])
						->all();
	
	
	
		
		$assigned = false;
		foreach($usedTrailerList as $usedTrailer)
			{
			if($this->id == $usedTrailer->id)
				{
				$assigned = true;
				}
			}
		return $assigned;
	}
    
  /**
	* 
	* 
	* DEscription: this function reutrns a list of Trailers being used on that date 
	* 
	* @return a list of trailers that are being used on that day. The array returned looks like
	* 
	* //this wil return an array [Delivery_run_num][trailer_id] => ['binsUsed' => X, 'tonsUsed' => Y]
	*/
    public function getTrailersUsed($requestedDate, $delivery_load_id)
    	{
		
	
		$deliveryLoadsBins = DeliveryLoadBin::find()
						->joinWith('deliveryLoad')
						->where(['delivery_on' => $requestedDate ])
						->all();
		
		$usedTrailerList = array();
		
		
		// output array [Delivery_run_num][trailer_id] => ['binsUsed' => X, 'tonsUsed' => Y, 'truck_id' => XX, 'other_trailer_slot' => TT]
		//iterate through each delivery and collect the info as required
		foreach($deliveryLoadsBins as $deliveryLoadBin)
			{
				
			//ckip the record if it is from the same delivery load
			if($delivery_load_id == $deliveryLoadBin->delivery_load_id)
				{
				continue;
				}
			$trailer_id = $deliveryLoadBin->trailerBin->trailer_id;
			$trailer_slot = ($deliveryLoadBin->deliveryLoad->trailer1_id == $trailer_id ? 1 : 2);
			$trailer_run_num = ($trailer_slot == 1 ? $deliveryLoadBin->deliveryLoad->trailer1_run_num : $deliveryLoadBin->deliveryLoad->trailer2_run_num);
			
			if(array_key_exists($trailer_run_num, $usedTrailerList) && array_key_exists($trailer_id, $usedTrailerList[$trailer_run_num]))
				{
				$usedTrailerList[$trailer_run_num][$trailer_id]['binsUsed'] += 1;
				$usedTrailerList[$trailer_run_num][$trailer_id]['tonsUsed'] += $deliveryLoadBin->bin_load;
				}
			else{
				$usedTrailerList[$trailer_run_num][$trailer_id]['binsUsed'] = 1;
				$usedTrailerList[$trailer_run_num][$trailer_id]['tonsUsed'] = $deliveryLoadBin->bin_load;
				$usedTrailerList[$trailer_run_num][$trailer_id]['truck_id'] = $deliveryLoadBin->deliveryLoad->truck_id;
				
				if($trailer_slot == 1)
					{
					$otherTrailer = $deliveryLoadBin->deliveryLoad->trailer2_id;
					$otherTrailer_run_num = $deliveryLoadBin->deliveryLoad->trailer2_run_num;
					}
				else{
					$otherTrailer = $deliveryLoadBin->deliveryLoad->trailer1_id;
					$otherTrailer_run_num = $deliveryLoadBin->deliveryLoad->trailer1_run_num;
					}
				$usedTrailerList[$trailer_run_num][$trailer_id]['other_trailer_slot'] = $otherTrailer;
				
				
				
				//also need to account for 0 bins used trailer bins
				if(!(array_key_exists($otherTrailer_run_num, $usedTrailerList) && array_key_exists($otherTrailer, $usedTrailerList[$otherTrailer_run_num])) )
					{
					$usedTrailerList[$otherTrailer_run_num][$otherTrailer]['binsUsed'] = 0;
					$usedTrailerList[$otherTrailer_run_num][$otherTrailer]['tonsUsed'] = 0;
					$usedTrailerList[$otherTrailer_run_num][$otherTrailer]['truck_id'] = $deliveryLoadBin->deliveryLoad->truck_id;	
					$usedTrailerList[$otherTrailer_run_num][$otherTrailer]['other_trailer_slot'] = $trailer_id;
					}
				
				}
			}
		
		
		return $usedTrailerList;
		}
		
		
	public function getUsedBinsOtherLoads($delivery_run_num, $requestedDate, $delivery_load_id)
		{
		$deliveryLoads = DeliveryLoad::find()
						->where(['delivery_on' => date("Y-m-d", $requestedDate) ])
						->andWhere(['delivery_run_num' => $delivery_run_num])
						->all();
		
		$usedTrailerBinList = array();
	
		
		//iterate through each delivery and collect the info as required
		foreach($deliveryLoads as $deliveryLoad)
			{
			//exclude the given delivery load id
			if($deliveryLoad->id != $delivery_load_id)
				{
				foreach($deliveryLoad->deliveryLoadBin as $deliveryLoadBinObject)
					{
					$usedTrailerBinList[$deliveryLoadBinObject->trailer_bin_id] = $deliveryLoadBinObject->bin_load;
					}	
				}
			}
		
		
		return $usedTrailerBinList;			
			
			
			
			
		}
	
	
	public function getDeliveryLoadBins($delivery_load_id)
		{
			$deliveryLoad = DeliveryLoad::findOne($delivery_load_id);
			
			$usedBinsArray = array();
			if($deliveryLoad != null)
				{
				foreach($deliveryLoad->deliveryLoadBin as $deliveryLoadBinObject)
					{
					$usedBinsArray[$deliveryLoadBinObject->trailer_bin_id] = $deliveryLoadBinObject->bin_load;
					}	
				}
		
				
				
			return $usedBinsArray;
		}
	
	/**
	* 
	* This function returns a list of trailer bins that have been used on this trailer, excluding any bins that have been used in the current delivery load
	* 
	* @return
	*/
	public function getUsedBins($trailer_id, $trailer_run_num, $requested_date, $delivery_id)
		{
			$usedBins = array();
			
			//first check for all loads where the trailer is used in trailer slot 1
			$deliveryLoads = DeliveryLoad::find()
						->where(['delivery_on' => $requested_date, 'trailer1_id' => $trailer_id, 'trailer1_run_num' => $trailer_run_num])
						->all();

			if(count($deliveryLoads) > 0)
				{
				foreach($deliveryLoads as $deliveryLoad)
					{
					//only care about bins from other orders not the current order
					if($delivery_id != $deliveryLoad->id)
						{
						//go through each of the attached trailer bins as add them to the array
						foreach($deliveryLoad->bins as $trailerLoadBin)
							{
							$usedBins[$trailerLoadBin->trailer_bin_id] = $trailerLoadBin->bin_load;
							}
						}
					}
				}
			
			//Check all the loads where the trailer is used in trailer slot 2
			$deliveryLoads = DeliveryLoad::find()
						->where(['delivery_on' => $requested_date, 'trailer2_id' => $trailer_id, 'trailer2_run_num' => $trailer_run_num])
						->all();
			if(count($deliveryLoads) > 0)
				{
				foreach($deliveryLoads as $deliveryLoad)
					{
					//only care about bins from other orders not the current order
					if($delivery_id != $deliveryLoad->id)
						{
						//go through each of the attached trailer bins as add them to the array
						foreach($deliveryLoad->bins as $trailerLoadBin)
							{
							$usedBins[$trailerLoadBin->trailer_bin_id] = $trailerLoadBin->bin_load;
							}
						}
					}
				}
			
			
			return $usedBins;
		}
	
	
	
	
	public function getDefaultTruckId($requestedDate, $delivery_run_num)
	{
	$trucks = DeliveryLoad::find()->where(['truck_id' => $this->default_truck_id, 'truck_run_num' => $delivery_run_num, 'delivery_on' => $requestedDate]);
	if(count($trucks) === 0)
		{
		return $this->default_truck_id;
		}
	return null;
	}
		
}
