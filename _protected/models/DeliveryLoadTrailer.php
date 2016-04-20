<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "delivery_load_trailer".
 *
 * @property integer $id
 * @property integer $delivery_load_id
 * @property integer $trailer_id
 */
class DeliveryLoadTrailer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'delivery_load_trailer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_load_id', 'trailer_id'], 'required'],
            [['delivery_load_id', 'trailer_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'delivery_load_id' => 'Delivery Load ID',
            'trailer_id' => 'Trailer ID',
        ];
    }
    
    public function getDeliveryLoad()
    {
		return $this->hasOne(DeliveryLoad::className(), ['id' => 'delivery_load_id'] );	
	}
	
	 public function getTrailer()
    {
		return $this->hasOne(Trailers::className(), ['id' => 'trailer_id'] );	
	}
	
	public function getDeliveryLoadBins()
	{
		return $this->hasMany(DeliveryLoadBin::className(), ['delivery_load_trailer_id' => 'id'] );
	}
	
	
	
	
	
	
	public function getBinsUsed()
		{
		return count($this->deliveryLoadBins);
		}
		
	public function getTonsUsed()
		{
		$tonsUsed = 0;
		foreach($this->deliveryLoadBins as $deliveryLoadBin)
			{
			$tonsUsed += $deliveryLoadBin->trailerBin->maxCapacity;
			}
			
		return $tonsUsed;
		}
    
}
