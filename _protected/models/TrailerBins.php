<?php

namespace app\models;

use Yii;
use app\models\Trailers;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "trailer_bins".
 *
 * @property integer $id
 * @property integer $trailer_id
 * @property string $BinNo
 * @property double $MaxCapacity
 * @property integer $Status
 */
class TrailerBins extends \yii\db\ActiveRecord
{
	
	
	const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trailer_bins';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trailer_id', 'BinNo', 'MaxCapacity', 'Status'], 'required'],
            [['trailer_id', 'Status'], 'integer'],
            [['MaxCapacity'], 'number'],
            [['BinNo'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trailer_id' => 'Trailer ID',
            'BinNo' => 'Bin No',
            'MaxCapacity' => 'Max Capacity',
            'Status' => 'Status',
        ];
    }
    
    public function getTrailer()
    {
		return $this->hasOne(Trailers::className(), ['id' => 'trailer_id'] );	
	}
	
	
	
	
	
	public function getUsedBins($requestedDate, $excludeOrderId = null)
		{
			
		
		$deliveryLoadBins = DeliveryLoadBin::find()
								->innerJoinWith('deliveryLoad', false)
								->where(['delivery_load.delivery_on' => date("Y-m-d", $requestedDate )])
								->all();
				
		//echo $usedTrailerBins->createCommand()->getRawSql();
		$usedTrailerBins = array();
		foreach($deliveryLoadBins as $deliveryLoadBin)
			{
			$usedTrailerBins[$deliveryLoadBin->trailer_bin_id] = $deliveryLoadBin;
			}
			
	

			
		return $usedTrailerBins;
		}
	
}
