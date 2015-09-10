<?php

namespace app\models;

use Yii;
use app\models\DeliveryLoadBin;

/**
 * This is the model class for table "delivery_load".
 *
 * @property integer $id
 * @property integer $delivery_id
 * @property double $load_qty
 * @property integer $trailer_bin_id
 * @property string $delivery_on
 * @property string $delivery_completed_on
 */
class DeliveryLoad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'delivery_load';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_id'], 'required'],
            [['delivery_id', ], 'integer'],
            [['load_qty'], 'number'],
            [['delivery_on', 'delivery_completed_on'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'delivery_id' => 'Delivery ID',
            'load_qty' => 'Load Qty',
            'delivery_on' => 'Delivery On',
            'delivery_completed_on' => 'Delivery Completed On',
        ];
    }
    
    
    public function getDelivery()
    {
		return $this->hasOne(Delivery::className(), ['id' => 'delivery_id'] );
	}
	
	public function getDeliveryLoadBin()
	{
		return $this->hasMany(DeliveryLoadBin::className(), ['delivery_load_id' => 'id'] );
	}
	
	public function getTruck()
	{
		return $this->hasOne(Trucks::className(), ['id' => 'truck_id'] );
	}
	
	
	/**
	* 
	* 
	* checkTruckCapacity()
	* 
	* This takes the truckObject and check to see if there is space on the truck for more room
	* 
	* Iterates through the deliveryLoads and checks if the load has the truck, and if it does then check the trailers to see if there is room
	* 
	* @return
	*/
	public function hasAdditionalCapacity()
		{
		if($this->trailer ===null)
			{
			die("checking capacity on deliveryload that has no trailer attached to it");
			}
		$availableBins = $this->trailer->NumBins;
		$usedBins = count($delivery->deliveryLoadBin);
		if($availableBins > $usedBins)
			{
			return true;
			}
		else{
			return false;
			}
		}
	
		
	/**
	* 
	* Function get load total
	* 
	* description: return the load carried in this delivery as a float
	*/	
	public function getLoadTotal()
	{
		$total = 0;
		foreach($this->deliveryLoadBin as $bin)
			{
			$total += $bin->bin_load;
			}
			
		return $total;
	}
	
	
	public function getLoadTrailerArray()
	{
		
		$trailerArray = array();
		foreach($this->deliveryLoadBin as $loadBin)
			{
			$trailerArray[$loadBin->trailerBin->trailer->id] = $loadBin->trailerBin->trailer;
			}
		
		return $trailerArray;
	}
	
    
}
