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
            [['Max_Capacity', 'NumBins', 'Auger', 'Blower', 'Tipper', 'Status'], 'integer'],
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
public function isAlreadyAssigned($requestedDate)
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
	* array( trailer_id => [deliveries => "DELZZZZ, DELXXSD", used_space => 5T])
	*/
    public function getTrailersUsed($requestedDate)
    	{
		
	
		$deliveryLoads = DeliveryLoad::find()
						->where(['delivery_on' => date("Y-m-d", $requestedDate )])
						->all();
		
		$deliverySummary = array();
		
		//iterate through each delivery and collect the info as required
		foreach($deliveryLoads as $deliveryLoad)
			{
			if(array_key_exists($deliveryLoad->trailer_id))
				{
				$deliverySummary[$deliveryLoad->trailer_id]['deliveries'] .=  ", ".$deliveryLoad->delivery->Name;
				$deliverySummary[$deliveryLoad->trailer_id]['used_space'] += $deliveryLoad->getLoadTotal();
				}
			else{
				$deliverySummary[$deliveryLoad->trailer_id]['deliveries'] = $deliveryLoad->delivery->Name;
				$deliverySummary[$deliveryLoad->trailer_id]['used_space'] = $deliveryLoad->getLoadTotal();
				}
			}
		
		
		return $deliverySummary;
		}
}
