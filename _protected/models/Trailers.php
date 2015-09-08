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
	* 
	* 
	* DEscription: this function reutrns a list of Trailers being used on that date 
	* 
	* @return a list of trailers that are being used on that day. The array returned looks like
	* 
	* array( trailer_id => [deliveries => "DELZZZZ, DELXXSD", remaining_space => 5T])
	*/
    public function getTrailerUsed($requestedDate)
    	{
		
	
		$deliveryLoads = DeliveryLoad::find()
						->where(['delivery_on' => date("Y-m-d", $requestedDate )])
						->all();
		
		$trailers = Trailers::find()->where(['Status' => Trailers::STATUS_ACTIVE])->all();
		$trailersArray = ArrayHelper::map($trailers, 'id', 'Registration') ;
		
		//iternate through the lists of Deliveries, and remove trailers if they are in the delivery
		foreach($deliveryLoads as $deliveryLoad)
			{
			if(array_key_exists($delivery->trailer_id, $trailersArray))
				{
				//check to see if the trailer has any room left, if not remove the trailer from list
				if(!$deliveryLoad->hasAdditionalCapacity())
					{
					unset($trailersArray[$delivery->trailer_id]);	
					}		
				}
			
			
			}
		
		return $trailersArray;
		}
    
    
    
      /**
	* 
	* 
	* DEscription: this function reutrns a bool if the trailer is avilable on the given date
	* 
	* @return bool
	*/
    public function checkAvailable($trailer, $requestedDate)
    	{
    		
    	
    	//if the default trailer has not been specified then return false
    	if($trailer === null)
    		{
			return False;
			}
    		
    	
		$deliveryLoads = DeliveryLoad::find()
						->where(['delivery_on' => date("Y-m-d", $requestedDate ), 'trailer_id' => $trailer->id])
						->all();	
		$isAvailable = true;	
		foreach($deliveryLoads as $deliveryLoad)
			{
			if(!$deliveryLoad->hasAdditionalCapacity())
				{
				$isAvailable = false;
				}	
			}
			
		return $isAvailable;
		}
    
    
    
    
}
