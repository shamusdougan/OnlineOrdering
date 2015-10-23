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
            [['delivery_id', 'truck_id', 'date', 'driver', 'gross', 'tare', 'net', 'Notes', 'Moisture', 'Protein', 'testWeight', 'screenings'], 'required'],
            [['delivery_id', 'truck_id'], 'integer'],
            [['date'], 'safe'],
            [['gross', 'tare', 'net', 'Moisture', 'Protein', 'testWeight', 'screenings'], 'number'],
            [['driver'], 'string', 'max' => 200],
            [['Notes'], 'string', 'max' => 500]
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
        ];
    }
}
