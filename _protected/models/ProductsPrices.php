<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products_prices".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $date_valid_from
 * @property double $price_pt
 */
class ProductsPrices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_prices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'date_valid_from', 'price_pt'], 'required'],
            [['product_id'], 'integer'],
            [['date_valid_from'], 'safe'],
            [['price_pt'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'date_valid_from' => 'Date Valid From',
            'price_pt' => 'Price Pt',
        ];
    }
    
    
    
     public function getProduct()
    {
		 return $this->hasOne(Product::className(), ['id' => 'product_id' ]);
	}
	
	
	
	public function getPriceData($startingDate, $pastMonthInt)
	{
		if($pastMonthInt != null)
			{
			$dateFrom = mktime(0,0,0,date("m", $startingDate) - $pastMonthInt, date("d", $startingDate), date("Y", $startingDate));
			}
		
		$priceData = ProductsPrices::find()
						->where(['and', 'date_valid_from >=\''.date("Y-m-d", $dateFrom).'\'', 'date_valid_from <=\''.date("Y-m-d", $startingDate).'\''])
						->all();
		
		return $priceData;			
	}
	
	public function getPriceDataOnDate($phpDateInt)
	{
		
		
		$priceData = ProductsPrices::find()
						->where('date_valid_from =\''.date("Y-m-d", $phpDateInt).'\'')
						->all();
		//Index according to product ID
		$returnArray = [];
		foreach($priceData as $priceObject)
			{
			$returnArray[$priceObject->product_id] = $priceObject;
			}
		
						
		
		return $returnArray;			
		
		
			
		
	}
	
}
