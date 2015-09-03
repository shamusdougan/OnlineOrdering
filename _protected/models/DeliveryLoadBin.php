<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "delivery_load_bin".
 *
 * @property integer $id
 * @property integer $delivery_load_id
 * @property integer $trailer_bin_id
 */
class DeliveryLoadBin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'delivery_load_bin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_load_id', 'trailer_bin_id'], 'required'],
            [['delivery_load_id', 'trailer_bin_id'], 'integer']
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
            'trailer_bin_id' => 'Trailer Bin ID',
        ];
    }
    
    public function getTrailerBin()
    {
	return $this->hasOne(TrailerBins::className(), ['id' => 'trailer_bin_id'] );	
	}
    
    
}
