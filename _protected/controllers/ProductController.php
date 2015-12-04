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
        $this->findModel($id)->delete();

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

}
