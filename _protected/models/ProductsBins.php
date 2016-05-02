<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products_bins".
 *
 * @property integer $id
 * @property integer $location_id
 * @property string $name
 * @property integer $order
 * @property integer $bin_type
 */
class ProductsBins extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_bins';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location_id', 'name', 'order', 'bin_type'], 'required'],
            [['location_id', 'order', 'bin_type', 'bin_id', 'capacity'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 450],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'location_id' => 'Bin Location',
            'name' => 'Name',
            'order' => 'Order',
            'bin_type' => 'Bin Type',
            'bin_id' => 'Bin Identifier',
            'capacity' => 'Bin Capacity',
        ];
    }
    
    
    public function getLocationString()
    {
		return Lookup::item($this->location_id, "BIN_LOCATION");
	}
    
    public function getProductsBinsList()
    {
		$productsBins = ProductsBins::find()->orderBy("order ASC")->all();
		$productsBinsArray = array();
		foreach($productsBins as $productBin)
			{
			$productsBinsArray[$productBin->getLocationString()][$productBin->id] = $productBin->name.($productBin->description != "" ? " (".substr($productBin->description, 0, 15).")" : "");
			}	
			
		return $productsBinsArray;
	}
}
