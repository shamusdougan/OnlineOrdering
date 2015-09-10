<?php

namespace app\models;

use Yii;
use app\models\Trailers;

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
}
