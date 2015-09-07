<?php

namespace app\models;

use Yii;

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
            [['delivery_id', 'load_qty', 'trailer_bin_id'], 'required'],
            [['delivery_id', 'trailer_bin_id'], 'integer'],
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
            'trailer_bin_id' => 'Trailer Bin ID',
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
	
			
    
}
