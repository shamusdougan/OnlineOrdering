<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "delivery_load_truck".
 *
 * @property integer $id
 * @property integer $delivery_load_id
 * @property integer $truck_id
 * @property integer $delivery_run_num
 */
class DeliveryLoadTruck extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'delivery_load_truck';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_load_id', 'truck_id', 'delivery_run_num'], 'required'],
            [['delivery_load_id', 'truck_id', 'delivery_run_num'], 'integer'],
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
            'truck_id' => 'Truck ID',
            'delivery_run_num' => 'Delivery Run Num',
        ];
    }
    
    
     public function getTruck()
    {
		return $this->hasOne(Trucks::className(), ['id' => 'trcuk_id'] );	
	}
    
}
