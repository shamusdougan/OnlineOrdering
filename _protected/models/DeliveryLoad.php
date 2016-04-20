<?php

namespace app\models;

use Yii;
use app\models\DeliveryLoadBin;
use app\models\DeliveryLoadTrailer;

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
            [['load_qty', 'delivery_load_trailer1', 'delivery_load_trailer2'], 'number'],
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
	
	
	
	public function getTruck()
	{
		return $this->hasOne(Trucks::className(), ['id' => 'delivery_load_truck_id'] );
	}
	
	public function getDeliveryLoadTrailer1()
	{
		return $this->hasOne(DeliveryLoadTrailer::className(), ['id' => 'delivery_load_trailer1_id'] );
	}
	
	public function getDeliveryLoadTrailer2()
	{
		return $this->hasOne(DeliveryLoadTrailer::className(), ['id' => 'delivery_load_trailer2_id'] );
	}
	
	
	
	
	/**
	* 
	* Function getTrailerCapacity
	* @return
	*/	
	public function getTrailerCapacity()
	{
		$trailerCapacity = 0;
		if(isset($this->deliveryLoadTrailer1))
			{
			$trailerCapacity = $deliveryLoadTrailer1->trailer->Max_Capacity;
			}
		if(isset($this->deliveryLoadTrailer2))
			{
			$trailerCapacity += $deliveryLoadTrailer1->trailer->Max_Capacity;
			}
			
		return $trailerCapacity;
	}
		
		
		
	/**
	* 
	* Function get load total
	* 
	* description: return the load carried in this delivery as a float
	*/	
	public function updateLoadQty()
	{
		$this->load_qty = 0;
		foreach($this->deliveryLoadBin as $bin)
			{
			$this->load_qty += $bin->bin_load;
			}
			
		$this->save();
	}
	
	
	
	public function getLoadVolume()
	{
		$loadVolume = 0;
		foreach($this->deliveryLoadBin as $bin)
			{
			$loadVolume += $bin->trailerBin->MaxCapacity;
			}
		
		return $loadVolume;
	}
	
	public function getLoadTrailerArray()
	{
		
		$trailerArray = array();
		foreach($this->deliveryLoadTrailer as $loadTrailer)
			{
			$trailerArray[$loadTrailer->id] = $loadTrailer->trailer;
			}
		
		return $trailerArray;
	}
	
	public function removeAllLoads()
	{
		foreach($this->deliveryLoadBin as $deliveryLoadBin)	
			{
			$deliveryLoadBin->delete();
			}
		foreach($this->deliveryLoadTrailer as $deliveryLoadTrailer)
			{
			$deliveryLoadTrailer->delete();
			}
	}
    
    
    /**
	* 
	* @param undefined $trailer_id
	* 
	* @description: removes any trailers from the load that match the given trailer id. return false if there is an error
	*/
    public function removeTrailer($trailer_id)
    {
		
		//look through the list of trailer assigned to this delivery, if there are any matches then remove the deliveryLoadTrailer
		foreach($this->deliveryLoadTrailer as $deliveryLoadTrailer)
		{
			if($deliveryLoadTrailer->trailer_id == $trailer_id)
			{
			//Check first that there arnt any assigned bins to this trailer on that date, if there are return false
			foreach($this->deliveryLoadBin as $deliveryLoadBin)
				{
				if($deliveryLoadBin->trailerBin->trailer_id == $trailer_id)
					{
					return false;
					}
				}
			$deliveryLoadTrailer->delete()	;
			}
		}
		return true;		
		
		
			
		
	
	}
    
    
    
    public function getTrailerID($trailerIndex)
    {
		if(array_key_exists($trailerIndex, $this->deliveryLoadTrailer))
			{
			return $this->deliveryLoadTrailer[$trailerIndex]->trailer_id;
			}
		return null;
	}
    
    
    public function getTrailerObject($trailerIndex)
    {
    	
 		if(array_key_exists($trailerIndex, $this->deliveryLoadTrailer))
			{
			return $this->deliveryLoadTrailer[$trailerIndex]->trailer;
			}
		return null;
	}
    
    /**
	* 
	* @param undefined $requestedDate
	* 
	* @return the list of delivery loads on the specified date
	*/
    public function getAllDeliveryLoadsOn($requestedDate)
    {
		$deliveryLoads = DeliveryLoad::find()
			->where(['delivery_on' => date("Y-m-d", $requestedDate )])
			->all();
		
		return $deliveryLoads;
	}
    
    
    public function getTruckBinsString()
    	{
    		
    		$returnString = "";
			foreach($this->deliveryLoadBin as $deliveryLoadBinObject)
				{
				$returnString .= $deliveryLoadBinObject->trailerBin->BinNo." ";
				}
				
			return $returnString;
		}
   
    
}
