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
    public function getTrailersUsed($requestedDate)
    	{
		
	
		$deliveryLoads = DeliveryLoad::find()
						->where(['delivery_on' => $requestedDate ])
						->all();
		
		$usedTrailerList = array();
		
		//iterate through each delivery and collect the info as required
		foreach($deliveryLoads as $deliveryLoad)
			{
			if(isset($deliveryLoad->trailer1_id))
				{
				$usedTrailerList[$deliveryLoad->trailer1_run_num][$deliveryLoad->trailer1_id] = 
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
	
	
	
		
}
