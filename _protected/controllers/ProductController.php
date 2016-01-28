<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\ProductSearch;
use app\models\ProductsPrices;
use app\models\ProductsIngredients;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

	public function beforeAction($action)
	{
	    if (!parent::beforeAction($action)) {
	        return false;
	    }

	    $this->view->params['menuItem'] = 'product';

	    return true; // or false to not run the action
	}







    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
 		
 		 
		$actionItems[] = ['label'=>'New', 'button' => 'new', 'url'=> '/product/create'];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'actionItems' => $actionItems,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        	{
     
     
     
            $get = Yii::$app->request->get();
            if(isset($get['exit']) && $get['exit'] == 'false' )
	    			{
					return $this->redirect(['update', 'id' => $model->id]);
					}
				else{
					return $this->redirect(['index']);
					}
        	} 
        else {
        
        	$actionItems[] = ['label'=>'Back', 'button' => 'back', 'url'=>'/product/index', 'confirm' => 'Cancel Changes?'];
			$actionItems[] = ['label'=>'Save', 'button' => 'save', 'overrideAction' =>'/product/create?&exit=false', 'url'=>null, 'submit'=> 'product-form', 'confirm' => 'Save Current Product?'];
			$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=>null, 'submit'=> 'product-form', 'confirm' => 'Save Current Product and Exit?'];
		
			$model->Mix_Type = Product::MIXTYPE_BASE;
			$model->price_pT = 0;
        
            return $this->render('create', [
                'model' => $model,
                'lockProductCode' => false,
                'actionItems' => $actionItems,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           
           
           $get = Yii::$app->request->get();
            if(isset($get['exit']) && $get['exit'] == 'false' )
	    			{
					return $this->redirect(['update', 'id' => $model->id]);
					}
				else{
					return $this->redirect(['index']);
					}
        	} 
        else {
        	
        	
        	
        	$actionItems[] = ['label'=>'Back', 'button' => 'back', 'url'=>'/product/index', 'confirm' => 'Cancel Changes?'];
			$actionItems[] = ['label'=>'Save', 'button' => 'save', 'overrideAction' =>'/product/update?id='.$model->id.'&exit=false', 'url'=>null, 'submit'=> 'product-form', 'confirm' => 'Save Current Product?'];
			$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=>null, 'submit'=> 'product-form', 'confirm' => 'Save Current Product and Exit?'];
		
      		$model->getCurrentPrice();
      		
        	
            return $this->render('update', [
                'model' => $model,
                'actionItems' => $actionItems,
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	
    	//first check to see if the productg is used in another mic/PELLET
    	$product =  $this->findModel($id);
    	if($product->isUsed())
    		{
    		$results = $product->getProductsUsedIn();
    		$errorText = "<ul>";
    		foreach($results as $product_ingredient)
    			{
				$errorText .= "<li>".$product_ingredient->product->Name.": ".Html::a('View', ['update', 'id' => $product_ingredient->product_id])."</li>";
				}
				
				
			Yii::$app->getSession()->setFlash('error', 'Cant Delete this product it is being used in an ingredient, please remove as an ingredient in the below products before deleting:'.$errorText);
			}
		else{
			Yii::$app->getSession()->setFlash('error', $product->Name.' deleted');
			$product->delete();
		}
    	
       

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    public function actionAjaxAddPrice($product_id)
    {
		$model = new ProductsPrices();
		
		
		if ($model->load(Yii::$app->request->post()) && $model->save()) 
			{
			return true;


			}
		else{	 
		 	$model->product_id = $product_id;
		 
			return $this->renderAjax('/products-pricing/_add', [
	                'model' => $model,
	                
	            ]);
		}
	}
    
    
    
	public function actionAjaxUpdatePrice($id)
    {
		$model = ProductsPrices::findOne($id);
		
		
		if ($model->load(Yii::$app->request->post()) && $model->save()) 
			{
			return true;


			}
		else{	 
			return $this->renderAjax('/products-pricing/_add', [
	                'model' => $model,
	                
	            ]);
		}
	}
  
	public function actionAjaxDeletePrice($id)
    {
		$model = ProductsPrices::findOne($id);
		$model->delete();
	}







	public function actionAjaxAddIngredient($product_id, $ingredient_sum)
	{
		$model = new ProductsIngredients();
		
		
		if ($model->load(Yii::$app->request->post()) && $model->save()) 
			{
			return true;


			}
		else{	 
		 	$model->product_id = $product_id;
		 	$model->created_on = date("Y-m-d");
		 	$max_percent = (100 - $ingredient_sum);
		 	$model->ingredient_percent = $max_percent;
		 
		 	$baseProducts = Product::find()
	        				->where(['status' => Product::ACTIVE])
	        				//->where(['Mix_Type' => Product::MIXTYPE_BASE])
	        				->select(['id', 'Name', 'Product_Category'])
	        				->all();
		 	$productList = ArrayHelper::map($baseProducts, 'id', 'Name');

	
			return $this->renderAjax('/products-ingredients/_add', [
	                'model' => $model,
	                'productList' => $productList,
	                'max_percent' => $max_percent,
	            ]); 
		}
	}

	public function actionAjaxUpdateIngredient($id, $ingredient_sum)
	{
		$model = ProductsIngredients::findOne($id);
		
		
		if ($model->load(Yii::$app->request->post()) && $model->save()) 
			{
			return true;


			}
		else{	 
		
			$max_percent = ((100 - $ingredient_sum) + $model->ingredient_percent);
			$baseProducts = Product::find()
	        				->where(['status' => Product::ACTIVE])
	        				->where(['Mix_Type' => Product::MIXTYPE_BASE])
	        				->select(['id', 'Name', 'Product_Category'])
	        				->all();
		 	$productList = ArrayHelper::map($baseProducts, 'id', 'Name');
		
		
			return $this->renderAjax('/products-ingredients/_add', [
	                'model' => $model,
	                'productList' => $productList,
	                'max_percent' => $max_percent,
	            ]);
		}
	}



	public function actionAjaxDeleteIngredient($id)
	{
		$model = ProductsIngredients::findOne($id);
		$model->delete();
	}

	public function actionAjaxGetPrice($product_id)
	{
		$product = Product::FindOne($product_id);
		$product->getCurrentPrice();
		return $product->price_pT;
	}
	
	
	
	public function actionAjaxImportIngredients($product_id)
	{
		
		$product = Product::findOne($product_id);
		$file = UploadedFile::getInstanceByName('importFile');		
	
		return $this->renderAjax('/products-ingredients/_import',
				[
				'file' => $file,
				]);
	}
	
	
	
	public function actionUpdatePricing()
	{
		
	$basePricingMatrix = Product::getBaseProductsPrices();	//return the pricing matrix
	$populatedPricingMatrix = Product::autoFillPricingMatrix($basePricingMatrix);
	
	$codefilter = Yii::$app->request->getQueryParam('filtercode', '');
	$namefilter = Yii::$app->request->getQueryParam('filtername', '');
	$dataProvider = Product::convertPricingToDataProvider($populatedPricingMatrix, $namefilter, $codefilter);
	$dataProvider->pagination = false;
	
	
	$actionItems[] = ['label'=>'New', 'button' => 'new', 'url'=> '/product/add-bulk-pricing'];
	$actionItems[] = ['label'=>'Import Excel', 'button' => 'copy', 'url'=>Url::to(['import-functions/import-price-sheet', 'id' => '8'])];
	$filterModel = ['proudct_id' => null, 'product_name' => $namefilter, 'product_code' => $codefilter];
	
	
	
	return $this->render('updatePricing',
							[
							'dataProvider' => $dataProvider,
							'basePricingMatrix' => $basePricingMatrix,
							'actionItems' => $actionItems,
							'basePricingMatrix' => $basePricingMatrix,
							'filterModel' => $filterModel,
							]);
		
	}
	
	
	public function actionAddBulkPricing($useDateInt = null)
	{
		  
		
		$priceModel = new ProductsPrices();
		$errorDisplay = [];

        if ($post = Yii::$app->request->post() ) {
           
         
           //print_r($post);
           //verify the inputs for each price is correct if any fail then return an error
           $errorArray = [];
           $dateFrom = date("Y-m-d", strtotime($post['price_date']));
           $priceLists = [];
           foreach($post['price'] as $product_id => $price)
				{
					
				//if the price has been set to 0 then dont bother to store thge data object
				if(isset($price) && $price != null && $price != '0' )
					{
						
				
					if($post['update'][$product_id] != null && $post['update'][$product_id] != "")
						{
						$model = ProductsPrices::findOne($post['update'][$product_id]);
						}
					else{
						$model = new ProductsPrices();						
						$model->product_id = $product_id;
						}

					$model->date_valid_from = $dateFrom;
					$model->price_pt = $price;
					
					if(!$model->validate())
						{
						
						$errorArray[$product_id] = $model->errors;
						}
					else{
						$priceLists[] = $model;
						}
					}
				}
			
			//If all the models passed the model validation rules
			if(count($errorArray) === 0){
				//echo "Saving all the pricing models";
				
				foreach($priceLists as $priceEntry)
					{
					$priceEntry->save();
					}
					
				return $this->redirect(Url::to(['product/update-pricing']));
				}
				
			//Collate the model errors and format for display
			else{
				
				$errorDisplay = [];
				foreach($errorArray as $product_id => $errors)
					{
					$product = Product::findOne($product_id);
					$errorDisplay[$product_id] = $product->Name.": Invalid Number";
					}
				}
				
       
         	} 
  
        	
        	
        	$dataProvider = Product::getBulkAddDataProvider($post, $useDateInt);
        	$actionItems[] = ['label'=>'Back', 'button' => 'back', 'url'=>Url::to(['product/update-pricing'])];
			$actionItems[] = ['label'=>'Save Pricing', 'button' => 'save', 'url'=>null, 'submit'=> 'bulk-pricing-form', 'confirm' => 'Add Prices to all products?'];
			
			
			$priceDate = time();			
			if(isset($useDateInt))
				{
				$priceDate = $useDateInt;
				}
      		//reload the post information if there was an error
      
      		
        	
            return $this->render('_addPricing', [
                'actionItems' => $actionItems,
                'priceDate' => $priceDate,
                'dataProvider' => $dataProvider,
                'errorArray' => $errorDisplay,
            ]);
        
		
	
		
	}
	
	
	public function actionCopyPriceSheet($priceDateInt)
	{
		
		$priceModel = new ProductsPrices();
		$errorDisplay = [];

        if ($post = Yii::$app->request->post() ) {
          
           //verify the inputs for each price is correct if any fail then return an error
           $errorArray = [];
           $dateFrom = date("Y-m-d", strtotime($post['price_date']));
           $priceLists = [];
           foreach($post['price'] as $product_id => $price)
				{
					
				//if the price has been set to 0 then dont bother to store thge data object
				if(isset($price) && $price != null && $price != '0' )
					{
						
				
					if($post['update'][$product_id] != null && $post['update'][$product_id] != "")
						{
						$model = ProductsPrices::findOne($post['update'][$product_id]);
						}
					else{
						$model = new ProductsPrices();						
						$model->product_id = $product_id;
						}

					$model->date_valid_from = $dateFrom;
					$model->price_pt = $price;
					
					if(!$model->validate())
						{
						
						$errorArray[$product_id] = $model->errors;
						}
					else{
						$priceLists[] = $model;
						}
					}
				}
			
			//If all the models passed the model validation rules
			if(count($errorArray) === 0){
				echo "Saving all the pricing models";
				
				foreach($priceLists as $priceEntry)
					{
					$priceEntry->save();
					}
					
				return $this->redirect(Url::to(['product/update-pricing']));
				}
				
			//Collate the model errors and format for display
			else{
				
				$errorDisplay = [];
				foreach($errorArray as $product_id => $errors)
					{
					$product = Product::findOne($product_id);
					$errorDisplay[$product_id] = $product->Name.": Invalid Number";
					}
				}
				
       
         	}
         
         //If the form hasn't been submitted pre populate the form withthe required DataColumn
         else{
		 	
		 	 $priceData = ProductsPrices::getPriceDataOnDate($priceDateInt);
		 	 foreach($priceData as $product_id => $priceObj)
		 	 	{
				$post['price'][$product_id] = $priceObj->price_pt;
				}
		 	
		 } 
  
        	
        	
    	$dataProvider = Product::getBulkAddDataProvider($post, $priceDateInt);
    	$actionItems[] = ['label'=>'Back', 'button' => 'back', 'url'=>Url::to(['product/update-pricing'])];
		$actionItems[] = ['label'=>'Save Pricing', 'button' => 'save', 'url'=>null, 'submit'=> 'bulk-pricing-form', 'confirm' => 'Add Prices to all products?'];

		
		
		$priceDate = time();			
    	
        return $this->render('_addPricing', [
            'actionItems' => $actionItems,
            'priceDate' => $priceDate,
            'dataProvider' => $dataProvider,
            'errorArray' => $errorDisplay,
        ]);

	}
	
	
	
	public function actionBulkDelete($priceDateInt)
	{
	
	
		ProductsPrices::bulkDeleteDate($priceDateInt);
		
		return $this->redirect(Url::to(['product/update-pricing']));
	}
	
	
	public function actionImportExceldata($filename, $columnName)
	{
						
						
		//parse the excel file, if any thing is a little off then redisplay the file upload screen
		$basePath = Yii::getAlias('@runtime').'/csv/';
		$dataProvider = ProductsPrices::getDataProviderFromExcel($basePath.$filename);
		if(is_string(($dataProvider)))
			{
			Yii::$app->session->setFlash('error', $dataProvider);
			$this->redirect('/import-functions/import-price-sheet');
			}
		
		//Clear any existing Pricing for the given date
		$targetDate = strtotime($columnName);
		$productLookupList = Product::getBaseProductCodeLookup();
		ProductsPrices::bulkDeleteDate($targetDate);
		
		
		foreach($dataProvider->getModels() as $productPriceArray)
			{
			if(!array_key_exists($columnName, $productPriceArray) || !array_key_exists('Product Code', $productPriceArray))
				{
				Yii::$app->session->setFlash('error', "Unable to get specified column data from Excel File, missing Column: ".$columnName);
				$this->redirect('/import-functions/import-price-sheet');
				}
			if($productPriceArray[$columnName] != '')
				{
				$productPricingObj = new ProductsPrices();
				$productPricingObj->product_id = $productLookupList[$productPriceArray['Product Code']];
				$productPricingObj->date_valid_from = date("Y-m-d", $targetDate);
				$productPricingObj->price_pt = $productPriceArray[$columnName];
				if(!$productPricingObj->save())
					{
					print_r($productPricingObj->getErrors());
					}	
				}
			}		
		$this->redirect('/product/update-pricing');
		
		
	}
	
	
}
