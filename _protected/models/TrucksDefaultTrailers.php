<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trucks_default_trailers".
 *
 * @property integer $id
 * @property integer $truck_id
 * @property integer $trailer_id
 */
class TrucksDefaultTrailers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trucks_default_trailers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['truck_id', 'trailer_id'], 'required'],
            [['truck_id', 'trailer_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'truck_id' => 'Truck ID',
            'trailer_id' => 'Trailer ID',
        ];
    }
    
    
     public function getTrailer()
    	{
			return $this->hasOne(Trailers::className(), ['id' => 'trailer_id'] );
		}
    
}
