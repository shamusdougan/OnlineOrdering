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
            [['registration', 'CreatedBy', 'Status', 'Auger', 'Blower', 'Tipper'], 'required'],
            [['CreatedBy', 'defaultTrailer', 'Status', 'Auger', 'Blower', 'Tipper'], 'integer'],
            [['registration'], 'string', 'max' => 200],
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
            'defaultTrailer_id' => 'Default Trailer',
            'Special_Instruction' => 'Special Instruction',
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
    public function getAvailable($requestedDate)
    	{
		
	
		$deliveryLoadsOnDate = DeliveryLoad::find()
						->where(['delivery_on' => date("Y-m-d", $requestedDate )])
						->all();
		
		$trucks = Trucks::find()->where(['Status' => Trucks::STATUS_ACTIVE])->all();
		$trucksArray = ArrayHelper::map($trucks, 'id', 'registration') ;
		
		//iternate through the lists of Deliveries, collect an array of trucks used so far
		$usedTrucks = array();
		foreach($deliveryLoadsOnDate as $deliveryLoad)
			{
			$truckID = $deliveryLoad->truck_id;
			$usedTrucks[$truckID] = array();
			
			//for each delivery work go through and list the number of trailerbins being used
			//We should end up with an array looking like array([truck_id] -> array(trailer_id => number_of_bins_used))
			foreach($deliveryLoad->deliveryLoadBin as $deliveryLoadBin)
				{
				$trailerID = $deliveryLoadBin->trailerBin->trailer_id;
				if(array_key_exists($trailerID, $usedTrucks[$truckID]))
					{
					$usedTrucks[$truckID][$trailerID] += 1;
					}
				else{
					$usedTrucks[$truckID][$trailerID] = 1;
					}
				}
			}

		
		//Go through each of the trucks->trailers and check that if the number of trailer bins being used matches The
		// number of trailerbin available. If they dont match then with bins free the truck and trailers can have a delivery added to it.
		foreach($usedTrucks as $truckID => $trailersArray)
			{
			$trailersFull = true;
			foreach($trailersArray as $trailerID => $trailerBinCount)
				{
				if(Trailers::getTrailerBinCount($trailerID) != $trailerBinCount)
					{
					$trailersFull = false;
					}
				}
				
			if($trailersFull)
				{
				unset($trucksArray[$truckID]);
				}
			}
		
		return $trucksArray;
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
			
		}
    
    
}
