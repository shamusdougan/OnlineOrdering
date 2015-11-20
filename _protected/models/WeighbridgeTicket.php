<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "weighbridge_ticket".
 *
 * @property integer $id
 * @property integer $delivery_id
 * @property integer $truck_id
 * @property string $date
 * @property string $driver
 * @property double $gross
 * @property double $tare
 * @property double $net
 * @property string $Notes
 * @property double $Moisture
 * @property double $Protein
 * @property double $testWeight
 * @property double $screenings
 */
class WeighbridgeTicket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'weighbridge_ticket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_id', 'gross', 'tare', 'net', 'ticket_number', 'driver'], 'required'],
            [['delivery_id', 'truck_id', 'smo_number'], 'integer'],
            [['date', 'ticket_number'], 'safe'],
            [['gross', 'tare', 'net', 'Moisture', 'Protein', 'testWeight', 'screenings'], 'number'],
            [['driver'], 'string', 'max' => 200],
            [['Notes'], 'string', 'max' => 400]
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
            'truck_id' => 'Truck ID',
            'date' => 'Date',
            'driver' => 'Driver',
            'gross' => 'Gross',
            'tare' => 'Tare',
            'net' => 'Net',
            'Notes' => 'Notes',
            'Moisture' => 'Moisture',
            'Protein' => 'Protein',
            'testWeight' => 'Test Weight',
            'screenings' => 'Screenings',
            'smo_number' => "SMO Number",
        ];
    }
    
    
    
    public function generateTicketNumber()
    {
		$temp = WeighbridgeTicket::find()->orderBy(['ticket_number' => SORT_DESC])->one();
		if(isset($temp)){
			return "WB". str_pad(($temp->id)+1, 5, '0', STR_PAD_LEFT);
			}
		else{
			return "WB00001";
		}
	}
	
	
	
	public function getDelivery()
    	{
			return $this->hasOne(Delivery::className(), ['id' => 'delivery_id'] );
		}
		
	public function getTruck()
    	{
			return $this->hasOne(Trucks::className(), ['id' => 'truck_id'] );
		}
		
	
		
}
