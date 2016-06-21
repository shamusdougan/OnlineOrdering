<?php

namespace app\models;
use yii\data\ArrayDataProvider;

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
	
	
	
	public function getDataProviderFromExcel($filename)
		{
			
		//check that the file exists
		if(!file_exists($filename))
			{
			return "Unable to open Excel Document";
			}
			
			
		$objPHPExcel = \PHPExcel_IOFactory::load($filename);
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
		
		//Check that the header row is correct
		$newKeysLookup = array_shift($sheetData);
		foreach($newKeysLookup as $index => $headerValue)
			{
			if($index == 'A')
				{
				if($headerValue != "Product Code")
					{
					return "Invalid Execel File Structure, Missing Product Code Column";		
					}
				}
			elseif($index == 'B')
				{
				if($headerValue != "Product Name")
					{
					return "Invalid Execel File Structure, Missing Product Name Column";	
					}
				}	
			else{
				if(!strtotime($headerValue))
					{
					return "Invalid Excel File Structure, Date Column not correct";
					}
				}
			}
	
		$resultArray = [];
		foreach($sheetData as $rowIndex => $dataRow)
			{
			foreach($dataRow as $index => $dataCell)
				{
				$resultArray[$rowIndex][$newKeysLookup[$index]] = $dataCell;
				}
			}
		
		$dataProvider = new ArrayDataProvider([
			        'key'=>'Product Code',
			        'allModels' => $resultArray,
			        'pagination' => false,
					]); 
					
					
		return $dataProvider;
		}
	
	/**
	* function clear Pricing Data
	* Descirption: this will clear as prices for the given date.
	**
	*/
	public function bulkDeleteDate($dateInt)
		{
			 
		$priceData = ProductsPrices::getPriceDataOnDate($dateInt);
	 	foreach($priceData as $product_id => $priceObj)
			{
			$priceObj->delete();
			}
		}
	

	public function generatePricingExcelTemplate()
		{
			
		$template = new \PHPExcel();
		$template->getProperties()
			->setCreator('Irwins Online Ordering')
			->setTitle('Product Pricing Template')
			->setLastModifiedBy('Shamus Dougan')
			->setDescription('A Pricing Template to import back into the application')
			->setSubject('Product Prciing');
		$ws1 = $template->getSheet(0);
		$ws1->setTitle('Pricing Template');
		$ws1->setCellValue('A1', 'Product Code');
		$ws1->setCellValue('B1', 'Product Name');
		$ws1->setCellValue('C1', date("d M Y"));
		
		
		$ws1->getStyle('A1:C1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('A0A0A0');
		$ws1->getStyle('A1:C1')->applyFromArray(['font' => ['bold' => true]]);
		$ws1->getColumnDimension('A')->setAutoSize(true);
		$ws1->getColumnDimension('B')->setAutoSize(true);
		$ws1->getColumnDimension('C')->setAutoSize(true);
		
		$baseProducts = Product::getProductList();
		$rowCount = 2; //Start the second row down
		foreach($baseProducts as $product)
			{
			$ws1->setCellValue('A'.$rowCount, $product->Product_ID);
			$ws1->setCellValue('B'.$rowCount, $product->Name);
			$rowCount++;
			}
	
		return $template;
		}

	
}
