<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products_ingredients".
 *
 * @property integer $id
 * @property string $created_on
 * @property integer $product_id
 * @property string $ingredient_percent
 * @property integer $modified_by
 * @property string $modified_on
 * @property integer $product_igredient_id
 */
class ProductsIngredients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_ingredients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_on', 'product_id', 'ingredient_percent', 'product_ingredient_id'], 'required'],
            [['created_on', 'modified_on'], 'safe'],
            [['product_id', 'modified_by', 'product_ingredient_id'], 'integer'],
            [['ingredient_percent'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_on' => 'Created On',
            'product_id' => 'Product ID',
            'ingredient_percent' => 'Ingredient Percent',
            'modified_by' => 'Modified By',
            'modified_on' => 'Modified On',
            'product_ingredient_id' => 'Product Ingredient ID',
        ];
    }
    
    
    public function getProduct()
    {
		 return $this->hasOne(Product::className(), ['id' => 'product_id' ]);
	}

    public function getIngredient()
    {
		 return $this->hasOne(Product::className(), ['id' => 'product_ingredient_id' ]);
	}


   public function generateIngedientExcelTemplate()
   {
   		$template = new \PHPExcel();
		$template->getProperties()
			->setCreator('Irwins Online Ordering')
			->setTitle('Product Ingedient Template')
			->setLastModifiedBy('Shamus Dougan')
			->setDescription('A Ingredient Template to import back into the application')
			->setSubject('Product Ingredients');
		$ws1 = $template->getSheet(0);
		$ws1->setTitle('Ingredient Template');
		$ws1->setCellValue('A1', 'Ingredient Code');
		$ws1->setCellValue('B1', 'Ingredient');
		$ws1->setCellValue('C1', 'Ingredient %');
	
		
		
		
		$ws1->getStyle('A1:C1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('A0A0A0');
		$ws1->getStyle('A1:C1')->applyFromArray(['font' => ['bold' => true]]);
		$ws1->getColumnDimension('A')->setAutoSize(true);
		$ws1->getColumnDimension('B')->setAutoSize(true);
		$ws1->getColumnDimension('C')->setAutoSize(true);
		
		
		$ws2 = $template->createSheet(1);
		$ws2->setTitle('Product Lookup Codes');
		$ws2->setCellValue('B1', 'Product Code');
		$ws2->setCellValue('A1', 'Product Name');
		$ws2->getStyle('A1:B1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('A0A0A0');
		$ws2->getStyle('A1:B1')->applyFromArray(['font' => ['bold' => true]]);
		$ws2->getColumnDimension('A')->setAutoSize(true);
		$ws2->getColumnDimension('B')->setAutoSize(true);
		
		
		$baseProducts = Product::getBaseProductList();
		$rowCount = 2; //Start the second row down
		foreach($baseProducts as $product)
			{
			$ws2->setCellValue('B'.$rowCount, $product->Product_ID);
			$ws2->setCellValue('A'.$rowCount, $product->Name);
			$rowCount++;
			}
	
	
		$template->setActiveSheetIndex(0);
	
		
		return $template;
   } 
   
   
   
   public function getDataFromExcel($filename, $product_id)
   {
   if(!file_exists($filename))
		{
		return "Unable to open Excel Document";
		}
			
			
	$objPHPExcel = \PHPExcel_IOFactory::load($filename);
	$sheetData = $objPHPExcel->getSheet(0)->toArray(null, false, false, true);
	
	//print_r($sheetData);
		
	//Check that the header row is correct
	$newKeysLookup = array_shift($sheetData);
	foreach($newKeysLookup as $index => $headerValue)
		{
		if($index == 'A')
			{
			if($headerValue != "Ingredient Code")
				{
				return "Invalid Execel File Structure, Missing Ingredient Code Column";		
				}
			}
		elseif($index == 'B')
			{
			if($headerValue != "Ingredient")
				{
				return "Invalid Execel File Structure, Missing Ingredient Name Column";	
				}
			}	
		elseif($index == 'C')
			{
			if($headerValue != "Ingredient %")
				{
				return "Invalid Execel File Structure, Missing Ingredient % Column";	
				}
			}	
		}
	
	
		$resultArray = [];
		$productCodeLookup = Product::getBaseProductCodeLookup();
		$sum = 0;
		$ingredients = [];
		foreach($sheetData as $rowIndex => $dataRow)
			{
			if(!array_key_exists(strval($dataRow['A']), $productCodeLookup))
				{
				return "Unable to find Product with Product Code: ".$dataRow['A'];
				}
			$productIngredientObj = new ProductsIngredients();
			$productIngredientObj->product_id = $product_id;
			$productIngredientObj->product_ingredient_id = $productCodeLookup[$dataRow['A']];
			$productIngredientObj->ingredient_percent = $dataRow['C'];
			$productIngredientObj->created_on = date("d M Y");
			if(!$productIngredientObj->save())
				{
				$saveErrors = $productIngredientObj->getErrors();
				$returnString = "Error on Row: ".($rowIndex+2)."<ul>";
				foreach($saveErrors as $fieldName => $errorList)
					{
					$returnString.= "<li>".$fieldName." error: ".$errorList[0]."</li>";
					}
				return $returnString."</ul>";
				}
			$sum += $productIngredientObj->ingredient_percent;
			$ingredients[] = $productIngredientObj;
			}
	
		//Check that the sum of the products doesn't equal 1, if it does then multiple by 100
		if($sum == 1)
			{
			foreach($ingredients as $ingredientObj)
				{
				$ingredientObj->ingredient_percent = $ingredientObj->ingredient_percent * 100;
				$ingredientObj->save();
				}
			}	
					
					
		return null;
	}
}

