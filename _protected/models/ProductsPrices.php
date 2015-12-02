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
}
