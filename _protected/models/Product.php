<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property string $Name
 * @property integer $Product_ID
 * @property string $Description
 * @property integer $Status
 * @property string $cp
 * @property integer $Decimals_Supported
 * @property integer $Default_Unit
 * @property string $Feed_notes
 * @property string $List_Price_pT_Base
 * @property string $me
 * @property string $Mix_Margin
 * @property string $Mix_Margin_Base
 * @property integer $Mix_Type
 * @property string $ndf
 * @property integer $Product_Category
 * @property string $Retail_Price_t
 */
class Product extends \yii\db\ActiveRecord
{
	
	const ACTIVE = 1;
	const INACTIVE = 2;
	
	const COMMODITY = 3;
	const MIX = 2;
	const PELLET = 1;	
	const ADDITIVE = 4;
	
	const MIXTYPE_BASE = 1;
	const MIXTYPE_COMPOSITE = 2;
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name', 'Product_ID', 'Status', 'Default_Unit', 'price_pT'], 'required'],
            [['Product_ID', 'Status', 'Decimals_Supported', 'Default_Unit', 'Mix_Type', 'Product_Category'], 'integer'],
            [['cp', 'me', 'Mix_Margin', 'Mix_Margin_Base', 'ndf', 'price_pT'], 'number'],
            [['Name'], 'string', 'max' => 100],
            [['Description', 'Feed_notes'], 'string', 'max' => 200],
            [['Product_ID'], 'unique'],
            [['Mix_Percentage_Total'], 'number', 'min' => 100, 'max' => 100, 'when' => function($model)
            	{
				return $model->Mix_Type == Product::MIXTYPE_COMPOSITE;
				},
				'whenClient' => "function (attribute, value) {
					return $('#Mix_Percentage_Total').val() == ".Product::MIXTYPE_COMPOSITE.";
					}",
				'message' => 'Ingredients Must Equal 100%'
            
            
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Name' => 'Name',
            'Product_ID' => 'Product  ID',
            'Description' => 'Description',
            'Status' => 'Status',
            'cp' => 'Cp',
            'Decimals_Supported' => 'Decimals  Supported',
            'Default_Unit' => 'Default  Unit',
            'Feed_notes' => 'Feed Notes',
            'me' => 'Me',
            'Mix_Margin' => 'Mix  Margin',
            'Mix_Margin_Base' => 'Mix  Margin  Base',
            'Mix_Type' => 'Mix  Type',
            'ndf' => 'Ndf',
            'Product_Category' => 'Product  Category',
            'price_pT' => 'Price Per Ton',
        ];
    }
    
    
    	
	public function getPricings()
	{
		return $this->hasMany(ProductsPrices::className(), ['product_id' => 'id' ]);
	}

    public function getIngredients()
	{
		return $this->hasMany(ProductsIngredients::className(), ['product_id' => 'id' ]);
	}

    
    
    public function getProductTypeString()
    {
		return Lookup::item($this->Product_Category, 'PRODUCT_CATEGORY');
	}
	
	
	public function getActiveProducts()
	{
		return Product::find()->where(['Status' => Product::ACTIVE]);
	}

	public function getCurrentPrice($priceDate = null, $recurseCheck = false)
	{
		if($priceDate == null)
			{
			$priceDate = time();
			}
		
		
		//If its a base proudct type just grab the relevant price data from the pricing table
		if($this->Mix_Type == Product::MIXTYPE_BASE)
		{
			$result = ProductsPrices::find()
						->where(['product_id' => $this->id])
						->andWhere('`date_valid_from` <= :date_val', [':date_val' => date("Y-m-d", $priceDate)])
						->orderBy(['date_valid_from' => SORT_DESC])
						->one();
								
			if($result){
				$this->price_pT = $result->price_pt;
				}
			else{
				$this->price_pT = 0;	
			}
		}
		elseif($recurseCheck == false && $this->Mix_Type == Product::MIXTYPE_COMPOSITE)
			{
				
			$sum = 0;
			foreach($this->ingredients as $productIngredient)
				{
				$percent = $productIngredient->ingredient_percent;
				$productIngredient->ingredient->getCurrentPrice($priceDate, true);
				$price = $productIngredient->ingredient->price_pT;
				$sum += ($price * ($percent/100));
				}
				
			$this->price_pT = $sum;
				
			}
		else{
			die("Recursive situation found in calculating proudct pricing");
		}
		
		
		
	}
	
	
}
