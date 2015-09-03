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
            'defaultTrailer' => 'Default Trailer',
            'Special_Instruction' => 'Special Instruction',
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
	* @return
	*/
    public function getAvailable($requestedDate)
    	{
		
	
		$deliveries = DeliveryLoad::find()
						->where(['delivery_on' => date("Y-m-d", $requestedDate )])
						->all();
		
		$trucks = Trucks::find()->where(['Status' => Trucks::STATUS_ACTIVE])->all();
		$trucksArray = ArrayHelper::map($trucks, 'id', 'registration') ;
		
		//iternate through the lists of Deliveries, and remove trucks if they are in the delivery
		foreach($deliveries as $delivery)
			{
			if(array_key_exists($delivery->truck_id, $trucksArray))
				{
				unset($trucksArray[$delivery->tuck_id]);		
				}
			
			
			}
		
		return $trucksArray;
		}
    
    
    
}
