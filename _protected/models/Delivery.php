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
            [['delivery_qty'], 'number'],
            [['delivery_on', 'delivery_completed_on'], 'safe'],
            [['weigh_bridge_ticket', 'weighed_by'], 'string', 'max' => 100]
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
        ];
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
			return $this->hasOne(Trucks::className(), ['id', 'truck_id']);
		}
		
}
