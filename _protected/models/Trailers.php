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
	* DEscription: this function reutrns a list of trucks that are available on given date
	* 
	* @return
	*/
    public function getAvailable($requestedDate)
    	{
		
	
		$deliveryLoad = DeliveryLoad::find()
						->where(['delivery_on' => date("Y-m-d", $requestedDate )])
						->all();
		
		$trailers = Trailers::find()->where(['Status' => Trailers::STATUS_ACTIVE])->all();
		$trailersArray = ArrayHelper::map($trailers, 'id', 'Registration') ;
		
		//iternate through the lists of Deliveries, and remove trailers if they are in the delivery
		foreach($deliveryLoad as $deliveryLoad)
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
    
    
    
    
    
    
}
