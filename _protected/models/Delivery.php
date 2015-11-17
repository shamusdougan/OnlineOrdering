<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "delivery".
 *
 * @property integer $id
 * @property string $weigh_bridge_ticket
 * @property string $weighed_by
 * @property double $delivery_qty
 * @property string $delivery_on
 * @property string $delivery_completed_on
 */
class Delivery extends \yii\db\ActiveRecord
{
	
	const STATUS_INPROGRESS = 1;
	const STATUS_LOADED = 2;
	const STATUS_COMPLETED = 3;
	const MAX_BATCH_SIZE = 5;
	
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'delivery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_qty', 'order_id'], 'number'],
            [['delivery_on'], 'required'],
            [['delivery_on', 'delivery_completed_on', 'status'], 'safe'],
            [['weigh_bridge_ticket', 'weighed_by'], 'string', 'max' => 100],
            [['num_batches'], 'batchCheck'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'weigh_bridge_ticket' => 'Weigh Bridge Ticket',
            'weighed_by' => 'Weighed By',
            'delivery_qty' => 'Delivery Qty',
            'delivery_on' => 'Delivery Date',
            'delivery_completed_on' => 'Delivery Completed On',
            'num_batches' => 'Number of batches',
        ];
    }
    
  	public function batchCheck($attribute, $params)
  		{
  			
  			
  			if($this->num_batches <= 0)
  				{
				$this->addError($attribute,'You must have a least 1 Batch');
				return;
				}
			
  			$order_size = $this->customerOrder->Qty_Tonnes;
  			$batch_size = $order_size / $this->num_batches;
  			if($batch_size > Delivery::MAX_BATCH_SIZE)
  				{
				$this->addError($attribute,'The Batch Size must be less than '.Delivery::MAX_BATCH_SIZE.'T');
				}
  			//$number_of_batches = ceil($order_size / $maximum_batch_size);

		}
    

	public function getBatchSize()
		{
			$order_size = $this->customerOrder->Qty_Tonnes;		
			if($this->num_batches == 0)
				{
				$this->num_batches	= ceil($order_size / Delivery::MAX_BATCH_SIZE);
				$this->save();
				}
			
  			return number_format($order_size / $this->num_batches, 3)." T";
		}
    
    
    public function getCustomerOrder()
    	{
			return $this->hasOne(CustomerOrders::className(), ['id' => 'order_id'] );
		}
		
	
	public function getDeliveryLoad()	
		{
			return $this->hasMany(DeliveryLoad::className(), ['delivery_id' => 'id'] );
		}
	
	public function getTruck()
		{
			return $this->hasOne(Trucks::className(), ['id' => 'truck_id']);
		}

	public function getWeighbridgeTicket()
		{
			return $this->hasOne(WeighbridgeTicket::className(), ['delivery_id' => 'id']);
		}

	public function calculateBatchSize($order_qty)
		{
			$maximumBatchSize = 5; 
			
			return ceil($order_qty / $maximumBatchSize);
		}

		
	public function getBinLoad($trailerBin_id)
		{
			foreach($this->deliveryLoad as $deliveryLoad)
				{
					foreach($deliveryLoad->deliveryLoadBin as $deliveryLoadBin)
						{
						if($trailerBin_id == $deliveryLoadBin->trailer_bin_id)
							{
								return $deliveryLoadBin->bin_load;
							}
						}
				}
			
			return 0;
			
			
		}
	
	
	public function removeAllLoads()
	{
		
		
		foreach($this->deliveryLoad as $deliveryLoad)
    		{
			$deliveryLoad->removeAllLoads();
			$deliveryLoad->delete();
			
			}
	

		
	}
	/**
	* 
	* @param undefined $trailer_id
	* 
	* @return
	*/	
	public function removeLoadFromTrailer($trailer_id)
	{
		foreach($this->deliveryLoad as $deliveryLoad)
			{
			foreach($deliveryLoad->deliveryLoadBin as $deliveryLoadBin)	
				{
				if($deliveryLoadBin->trailerBin->trailer_id == $trailer_id)
					{
					$deliveryLoadBin->delete();
					}		
				}
			}
	}
		
		
	public function generateName($index)
	{
		return "DEL".str_pad($index, 5, "0", STR_PAD_LEFT);
	}
	
	public function getPhpDeliveryOnDate()
	{
		return strtotime($this->delivery_on);
	}
	
	/**
	* Recalculates the qty allocated in the delivery. Goes through and calculates the overall qty from each of the DeliveryLoads
	* 
	* @return
	*/
	public function updateDeliveryQty()
	{
	$this->delivery_qty = 0;
	
	echo "updating delivery Load <br>";
		
	foreach($this->deliveryLoad as $deliveryLoad)
		{
		$deliveryLoad->updateLoadQty();
		echo "Delivery Load: ".$deliveryLoad->id." = ".$deliveryLoad->load_qty."<br>";
		
		$this->delivery_qty += $deliveryLoad->load_qty;
		}
	
	$this->save();
	
	}
	
	/**
	* 
	* 
	* @returns an array of trailer id that have been used in this delivery so far
	*/
	public function getTrailersUsedArrayString()
	{
		$trailers = array();
		foreach($this->deliveryLoad as $deliveryLoad)
			{
			foreach($deliveryLoad->deliveryLoadTrailer as $deliveryLoadTrailer)
				{
				$trailers[] = $deliveryLoadTrailer->trailer_id;
				}
			}
		
		return implode(",", $trailers);
		
	}
	
	/**
	* getUnloaded Deliveries
	* 
	* @return a list of deliveies that havent yet been loaded
	*/
	public function getUnloadedDeliveries()
	{
		$deliveries = Delivery::find()
							->where(['status' => Delivery::STATUS_INPROGRESS])
							->all();
							
		return $deliveries;
	}
	
	
	
	
	public function setStatusInprogress()
	{
		$this->status = Delivery::STATUS_INPROGRESS;
		$this->save();
	}
	
	public function setStatusLoaded()
	{
		$this->status = Delivery::STATUS_LOADED;
		$this->save();
	}
	
	
	public  function setStatusCompleted()
	{
		$this->status = Delivey::STATUS_COMPLETED;
		$this->save();
	}
	
}
