<?php

namespace app\models;

use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;


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
            [['Name', 'Product_ID', 'Status', 'price_pT'], 'required'],
            [['Product_ID', 'Status', 'Decimals_Supported', 'Mix_Type', 'Product_Category'], 'integer'],
            [['cp', 'me', 'Mix_Margin', 'Mix_Margin_Base', 'ndf', 'price_pT'], 'number'],
            [['Name'], 'string', 'max' => 100],
            [['Description', 'Feed_notes'], 'string', 'max' => 200],
            [['Product_ID'], 'unique'],
            [['Mix_Percentage_Total'], 'number', 'min' => 100, 'max' => 100, 'when' => function($model)
            	{
				return ($model->Mix_Type == Product::MIXTYPE_COMPOSITE) && ($model->id != null);
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
		
		return $this->price_pT;
		
	}
	
	
	public function clearIngredients()
	{
		foreach($this->ingredients as $product_ingredient)
			{
			$product_ingredient->delete();
			}
	}
	
	
	public function getBaseProductList()
		{
		return Product::find()
							->where(['Status' => Product::ACTIVE, 'Mix_Type' => Product::MIXTYPE_BASE])
							->all();
		}
	
	
	public function getBaseProductListLookup()
	{
		$baseProductList = Product::getBaseProductList();
		return ArrayHelper::map($baseProductList, 'id', 'Name');
	}
	
	public function getBaseProductCodeLookup()
	{
		$baseProductList = Product::getBaseProductList();
		return ArrayHelper::map($baseProductList, 'Product_ID', 'id');
	}
	
	
	
	//Returns a product pricing matrix of the following FORMAT_DATE
	
	//array(
	//	['dateInt'] => array(['product_id' => 'price', 'product_id2' => 'price2'] )
	//	['dateInt'] => array(['product_id' => 'price', 'product_id2' => 'price2'] )
	//	)
	public function getBaseProductsPrices()
		{
			
		$baseProducts = Product::getBaseProductList();
		
		$PastDataMonths = 6;			
		$prices = ProductsPrices::getPriceData(time(), $PastDataMonths);
		
		
		//get the pricing data
		$pricingMatrix = array();
		foreach($prices as $itemPrice)
			{
			$phpDate = strtotime($itemPrice->date_valid_from);
			if(array_key_exists($phpDate, $pricingMatrix))
				{
				$pricingMatrix[$phpDate][$itemPrice->product_id] = $itemPrice->price_pt;
				}
			else{
				$pricingMatrix[$phpDate] = array();
				$pricingMatrix[$phpDate][$itemPrice->product_id] = $itemPrice->price_pt;
				}
			}
			
		ksort($pricingMatrix);
		return $pricingMatrix;
		}
	
	
	public function autoFillPricingMatrix($pricingMatrix)
		{

		ksort($pricingMatrix);
		reset($pricingMatrix);
		$baseProducts = Product::getBaseProductList();
		
		//we now need to back fill the relevant data for each of the base items
		//If the earlest array isn't fully populated from the pricing data, then go through each unpriced item and get the price at that date.
		$startingDate = key($pricingMatrix);
		
		//If the pricing matrix is empty
		if($startingDate == null)
			{
			$startingDate = time();
			$pricingMatrix[$startingDate] = array();
			}
		
		
		foreach($baseProducts as $productObj)
			{
			
			if(!array_key_exists($productObj->id, $pricingMatrix[$startingDate]))
				{
				$pricingMatrix[$startingDate][$productObj->id] = $productObj->getCurrentPrice($startingDate);
				}
			}

		
		//go through the remaining array, if an entry isn't populated then get the previous price/date entries value
		$previousDate = $startingDate;
		foreach($pricingMatrix as $priceDate => $priceObjArray)
			{
			foreach($baseProducts as $productObj)
				{
				if(!array_key_exists($productObj->id, $priceObjArray))
					{
					$pricingMatrix[$priceDate][$productObj->id] = $pricingMatrix[$previousDate][$productObj->id];
					}
				}
			$previousDate = $priceDate;
			}
	
		return $pricingMatrix;
		}
		
	/*
	Returns the array of arrays like the following
	array(product_id, Date1, Date2, Date3, ....)
	*/
	public function convertPricingToDataProvider($pricingMatrix, $productNameFilter = null, $productCodeFilter = null)
		{
		//tranform the pricing matrix into a yii DataProvider result to be displayed in a datagrid
		$resultSet = [];
		$baseProducts = Product::getBaseProductList();
		foreach($baseProducts as $productObj)
			{
				
			$useValue = true;
			if($productNameFilter && stripos($productObj->Name, $productNameFilter) === false)
				{
				$useValue = false;
				}
			if($productCodeFilter && stripos($productObj->Product_ID, $productCodeFilter) === false)
				{
				$useValue = false;	
				}
				
			if($useValue)
				{
				$newArray = ["product_id" => $productObj->id, "product_name" => $productObj->Name, "product_code" => $productObj->Product_ID];
				foreach($pricingMatrix as $priceDate => $priceObjArray)
					{
					$newArray[$priceDate] = $priceObjArray[$productObj->id];
					}
					
				$resultSet[] = $newArray;		
				}
			
			}
			
			
		$dataProvider = new ArrayDataProvider([
	        'key'=>'product_id',
	        'allModels' => $resultSet,
	        'sort' => [
	            'attributes' => ['product_code', 'product_name'],
	        	],
	        'pagination' => [
        		'pageSize' => 20,
    			],
			]); 
			
			
		return $dataProvider;
		}
	
	
	
	public function getBulkAddDataProvider($post = null, $useDateInt= null)
	{
		$baseProducts = Product::getBaseProductList();
		
		$resultSet = [];
		
		if($post == null && $useDateInt != null)
			{
			$priceList = ProductsPrices::getPriceDataOnDate($useDateInt);
		
		
			foreach($baseProducts as $productObj)
				{
				if(array_key_exists($productObj->id, $priceList))
					{
					$resultSet[] = $priceList[$productObj->id];
					}
				else{
					$productPricing = new productsPrices();
					$productPricing->product_id = $productObj->id;
					$productPricing->price_pt = 0;
					
					$resultSet[] = $productPricing;
					}
				}
			
			
			
			}
		else{
			
		
			foreach($baseProducts as $productObj)
				{
				$productPricing = new productsPrices();
				$productPricing->product_id = $productObj->id;
				
				if(array_key_exists('price', $post) && array_key_exists($productObj->id, $post['price']))
					{
					$productPricing->price_pt = $post['price'][$productObj->id];
					}
			
				
				$resultSet[] = $productPricing;
				
				}
			}	
			
			
			
			
			
			
			
			
			
		$dataProvider = new ArrayDataProvider([
	        'key'=>'product_id',
	        'allModels' => $resultSet,
	
	        'pagination' => false,
			]); 
		return $dataProvider;
		
	}
	
	/**
	* function us Used()
	* Description: this function will check to see if a given product is current being used as an igredient in another product
	* return: true/false
	* 
	* @return
	*/
	public function isUsed()
		{
			
		//$sql = "SELECT COUNT(*) FROM ".Product::tablename();
		$count = (new \yii\db\Query())
   			->from(ProductsIngredients::tablename())
   			->where(['product_ingredient_id' => $this->id])
    		->count();
		
		if($count > 0)
			{
			return true; 
			}
		return false;
		}
		
	
	
	public function getProductsUsedIn()
		{
			
		return ProductsIngredients::findAll(['product_ingredient_id' => $this->id]);
	
			
			
			
		} 
}
