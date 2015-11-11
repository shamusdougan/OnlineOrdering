<?php

namespace app\controllers;

use Yii;
use app\models\customerOrders;
use app\models\customerOrdersSearch;
use app\models\Clients;
use app\models\CustomerOrdersIngredients;
use app\models\Product;
use app\models\Storage;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\Lookup;
use yii\helpers\Json;

/**
 * CustomerOrderController implements the CRUD actions for customerOrders model.
 */
class CustomerOrderController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post', 'get'],
                    'customerdetails' => ['get', 'post']
                ],
            ],
        ];
    }




	public function beforeAction($action)
	{
	    if (!parent::beforeAction($action)) {
	        return false;
	    }

	    $this->view->params['menuItem'] = 'customer-order';

	    return true; // or false to not run the action
	}




    /**
     * Lists all customerOrders models.
     * @return mixed
     */
    public function actionIndex()
    {
		$this->view->params['menuItem'] = 'customer-order-sales';
        $searchModel = new customerOrdersSearch();
        $dataProvider = $searchModel->getAllOrders(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['Created_On'=>SORT_DESC]]);

		$actionItems[] = ['label'=>'New', 'button' => 'new', 'url'=> '/customer-order/create'];
		

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'actionItems' => $actionItems,
        ]);
    }


 






    /**
     * Displays a single customerOrders model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new customerOrders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($redirectTo = 'update')
    {
        $model = new customerOrders(['scenario' => 'createDummy']);
		$model->Customer_id = customerOrders::PLACEHOLDERID;
    	$model->Name = "XXXXX";
    	$model->Created_On = Date('Y-m-d');
    	$model->Created_By = Yii::$app->user->identity->id;
    	$model->Status = customerOrders::STATUS_ACTIVE;
    	if(!$model->save())
    		{
    		die("unable to create new order");
        	}
		$model->Order_ID = $model->getOrderNumber();
		$model->save();
		return $this->redirect([$redirectTo, 'id' => $model->id]);
        

        

    }

    /**
     * Updates an existing customerOrders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        		{
        		$get = Yii::$app->request->get();
        		if(isset($get['submitOrder']) && $get['submitOrder'] == true)
        			{
					$model->Status = CustomerOrders::STATUS_SUBMITTED;
					$model->save();
					}
        		   		
	    		if(isset($get['exit']) && $get['exit'] == 'false' )
	    			{
					return $this->redirect(['update', 'id' => $model->id]);
					}
				else{
					return $this->redirect(['index']);
					}
        		} 
        else {   	
        	
 			$readOnly = true;
 			
			if($model->isActive()){
				$actionItems[] = ['label'=>'Back', 'button' => 'back', 'url'=>'/customer-order/index', 'confirm' => 'Cancel Changes?'];
				$actionItems[] = ['label'=>'Save', 'button' => 'save', 'overrideAction' =>'/customer-order/update?id='.$model->id.'&exit=false', 'url'=>null, 'submit'=> 'customer-order-form', 'confirm' => 'Save Current Order?'];
				$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=>null, 'submit'=> 'customer-order-form', 'confirm' => 'Save Current Order and Exit?'];
				$actionItems[] = ['label'=>'Save & Submit', 'button' => 'truck', 'url'=>null, 'overrideAction' =>'/customer-order/update?id='.$model->id.'&submitOrder=true', 'submit'=> 'customer-order-form', 'confirm' => 'Save Current Order and Submit?'];
				$actionItems[] = ['label'=>'Copy Order', 'button' => 'copy', 'url'=>'/customer-order/copy?id='.$model->id];
				$readOnly = false;
				}
			else{
				$actionItems[] = ['label'=>'Back', 'button' => 'back', 'url'=>'/customer-order/index'];
				$actionItems[] = ['label'=>'Copy Order', 'button' => 'copy', 'url'=>'/customer-order/copy?id='.$model->id];
			}
			
        	
        	
        	$clientObjects = Clients::find()
        				->where('id != :id', ['id'=>Clients::DUMMY])
        				->select(['id', 'Company_Name', 'Trading_as'])
        				->all();
        	$clientList = ArrayHelper::map($clientObjects, 'id', 'clientListName') ;
        	
        	
        	//generate the list of storage option available, this will be over written by ajax if the client changes
        	if(!$model->isDummyClient())
        		{
				$storageList = 	ArrayHelper::map($model->client->storage, 'id', 'Description');
				
				if(array_key_exists($model->Storage_Unit, $storageList))
					{
						
						unset($storageList[$model->Storage_Unit]);
						$storageList[$model->Storage_Unit] = $model->storage->Description;
						$storageList = array_reverse($storageList, true);
					}
				}
			else{
				$storageList = 	array();
				}
        	
            return $this->render('update', [
                'model' => $model, 
                'clientList' => $clientList, 
                'actionItems' => $actionItems, 
                'storageList' => $storageList,
                'readOnly' => $readOnly,
                
            ]);
        }
    }


 /**
 * 
 * 			Controller Action for the the Production List pages
 * 
 * 
 * 
 * 			Need to have this seperate for the sumission process to come back to the correct list
 * 
 * 
 * 
 * 
 * 
 **/
 
 /**
     * Lists all customerOrders models.
     * @return mixed
     */
    public function actionProductionActiveList()
    {
		$this->view->params['menuItem'] = 'customer-order-production-active';
		
		
		//if an order has been selected and the "Submit orders" button is pressed
		$checkArray = Yii::$app->request->post('selection'); 
		if($checkArray)
			{
			foreach($checkArray as $orderId)
				{
				if (($order = customerOrders::findOne($orderId)) !== null) 
					{
            		$order->submitOrder();
        			}
        		else {
            		throw new NotFoundHttpException('The requested customer Order does not exist orderID: '.$orderId);
        			}
				}
			}
		
		 
		
		
		
        $searchModel = new customerOrdersSearch();
        $dataProvider = $searchModel->getActiveOrders(Yii::$app->request->queryParams);

		$actionItems[] = ['label'=>'New', 'button' => 'new', 'url'=> '/customer-order/create?redirectTo=update-production-active'];
		$actionItems[] = ['label'=>'Submit Orders', 'button' => 'truck', 'submit' => 'customer-order-active-list-form', 'url'=> null];
		

        return $this->render('production-active-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'actionItems' => $actionItems,
        ]);
    }


 
 
 
	 /**
     * Updates an existing customerOrders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdateProductionActive($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        		{
        		$get = Yii::$app->request->get();
        		if(isset($get['submitOrder']) && $get['submitOrder'] == true)
        			{
					$model->Status = CustomerOrders::STATUS_SUBMITTED;
					$model->save();
					}
        		   		
	    		if(isset($get['exit']) && $get['exit'] == 'false' )
	    			{
					return $this->redirect(['update-production-active', 'id' => $model->id]);
					}
				else{
					return $this->redirect(['production-active-list']);
					}
        		} 
        else {   	
        	$actionItems[] = ['label'=>'Back', 'button' => 'back', 'url'=>'/customer-order/production-active-list', 'confirm' => 'Cancel Changes?'];
        	$actionItems[] = ['label'=>'Save', 'button' => 'save', 'overrideAction' =>'/customer-order/update-production-active?id='.$model->id.'&exit=false', 'url'=>null, 'submit'=> 'customer-order-form', 'confirm' => 'Save Current Order?'];
			$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'overrideAction' =>'/customer-order/update-production-active?id='.$model->id, 'url'=>null, 'submit'=> 'customer-order-form', 'confirm' => 'Save Current Order and Exit?'];
			$actionItems[] = ['label'=>'Save & Submit', 'button' => 'truck', 'url'=>null, 'overrideAction' =>'/customer-order/update-production-active?id='.$model->id.'&submitOrder=true', 'submit'=> 'customer-order-form', 'confirm' => 'Save Current Order and Submit?'];
				
        	
        	
        	$clientObjects = Clients::find()
        				->where('id != :id', ['id'=>Clients::DUMMY])
        				->select(['id', 'Company_Name'])
        				->all();
        	$clientList = ArrayHelper::map($clientObjects, 'id', 'Company_Name') ;
        	
        	
        	//generate the list of storage option available, this will be over written by ajax if the client changes
        	if(!$model->isDummyClient())
        		{
				$storageList = 	ArrayHelper::map($model->client->storage, 'id', 'Description');
				
				if(array_key_exists($model->Storage_Unit, $storageList))
					{
						
						unset($storageList[$model->Storage_Unit]);
						$storageList[$model->Storage_Unit] = $model->storage->Description;
						$storageList = array_reverse($storageList, true);
					}
				}
			else{
				$storageList = 	array();
				}
        	
            return $this->render('update', [
                'model' => $model, 'clientList' => $clientList, 'actionItems' => $actionItems, 'storageList' => $storageList
            ]);
        }
    }







/**
 * 
 * 			Controller Action for the the Production List pages
 * 
 * 
 * 
 * 			Need to have this seperate for the sumission process to come back to the correct list
 * 
 * 
 * 
 * 
 * 
 **/
 
 
	public function actionProductionSubmittedList()
    {
		$this->view->params['menuItem'] = 'customer-order-production-submitted';
		
		//if an order has been selected and the "Submit orders" button is pressed
		$checkArray = Yii::$app->request->post('selection'); 
		if($checkArray)
			{
			foreach($checkArray as $orderId)
				{
				if (($order = customerOrders::findOne($orderId)) !== null) 
					{
            		$order->unSubmitOrder();
        			}
        		else {
            		throw new NotFoundHttpException('The requested customer Order does not exist orderID: '.$orderId);
        			}
				}
			}
		
		
        $searchModel = new customerOrdersSearch();
        $dataProvider = $searchModel->getSubmittedOrders(Yii::$app->request->queryParams);

		$actionItems[] = ['label'=>'Unsubmit Order(s)', 'button' => 'reversetruck', 'submit' => 'customer-order-submitted-list-form', 'url'=> null];
		


        return $this->render('production-submitted-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'actionItems' => $actionItems,
        ]);
    }

 
  /**
     * Updates an existing customerOrders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdateProductionSubmitted($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        		{
        		$get = Yii::$app->request->get();
        		if(isset($get['processOrder']) && $get['processOrder'] == true)
        			{
					$model->Status = CustomerOrders::STATUS_PROCESSING;
					$model->save();
					}
        		   		
	    		if(isset($get['exit']) && $get['exit'] == 'false' )
	    			{
					return $this->redirect(['update-production-submitted', 'id' => $model->id]);
					}
				else{
					return $this->redirect(['production-submitted-list']);
					}
        		} 
        else {   	
        	$actionItems[] = ['label'=>'Back', 'button' => 'back', 'url'=>'/customer-order/production-submitted-list', 'confirm' => 'Exit with out Saving?'];
        	$actionItems[] = ['label'=>'Save', 'button' => 'save', 'overrideAction' =>'/customer-order/update-production-submitted?id='.$model->id.'&exit=false', 'url'=>null, 'submit'=> 'customer-order-form', 'confirm' => 'Save Current Order?'];
			$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=>null, 'overrideAction' =>'/customer-order/update-production-submitted?id='.$model->id, 'submit'=> 'customer-order-form', 'confirm' => 'Save Current Order and Exit?'];
			$actionItems[] = ['label'=>'Save & Process', 'button' => 'truck', 'url'=>null, 'overrideAction' =>'/customer-order/update-production-submitted?id='.$model->id.'&processOrder=true', 'submit'=> 'customer-order-form', 'confirm' => 'Save Current Order and Produce?'];
				
        	
        	
        	$clientObjects = Clients::find()
        				->where('id != :id', ['id'=>Clients::DUMMY])
        				->select(['id', 'Company_Name'])
        				->all();
        	$clientList = ArrayHelper::map($clientObjects, 'id', 'Company_Name') ;
        	
        	
        	//generate the list of storage option available, this will be over written by ajax if the client changes
        	if(!$model->isDummyClient())
        		{
				$storageList = 	ArrayHelper::map($model->client->storage, 'id', 'Description');
				
				if(array_key_exists($model->Storage_Unit, $storageList))
					{
						
						unset($storageList[$model->Storage_Unit]);
						$storageList[$model->Storage_Unit] = $model->storage->Description;
						$storageList = array_reverse($storageList, true);
					}
				}
			else{
				$storageList = 	array();
				}
        	
            return $this->render('update', [
                'model' => $model, 'clientList' => $clientList, 'actionItems' => $actionItems, 'storageList' => $storageList
            ]);
        }
    }




    /**
     * Deletes an existing customerOrders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id, $redirectTo = 'index')
    {
        $this->findModel($id)->delete();

        return $this->redirect([$redirectTo]);
    }

    /**
     * Finds the customerOrders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return customerOrders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = customerOrders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    
    public function actionAjaxCompanyDetails($id)
    {
    	if($id != Clients::DUMMY && $id != null){
			$model=  \app\models\Clients::findOne(['id'=>$id]);
			$storageList = ArrayHelper::map($model->storage, 'id', 'Description');
	    	return \yii\helpers\Json::encode([
	    		'contact' => $model->owner->fullname,
		        'address'=>$model->Address_1,
		        'phone'=>$model->Main_Phone,
		        'status'=>Lookup::item($model->Status, 'CLIENT_STATUS'),
		        'nearestTown'=>$model->Nearest_Town,
		        'id'=>$model->id,
		        'storage' => $storageList
		    ]);
		    }
		else{
			return True;
		}

	}
	
	public function actionAjaxStorageDetails()
	{
			
		$out = [];
		if (isset($_POST['depdrop_parents'])) 
			{
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$clientID = $parents[0];
				
				
				$client =  Clients::findOne(['id'=>$clientID]);
				if($client)
					{
					foreach($client->storage as $storage)
						{
						$out[] = array('id' => $storage->id, 'name' => $storage->Description);
						}
					if(count($client->storage))
						{
						echo Json::encode(['output'=>$out, 'selected'=>$client->storage[0]->id]);		
						}
					else{
						echo Json::encode(['output'=>$out ]);		
						}
					}
				else{
					echo Json::encode(['output'=>$out]);
				}
				
				
				
				
				
				// the getSubCatList function will query the database based on the
				// cat_id and return an array like below:
				// [
				//    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
				//    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
				// ]
			
				return;
			}
		}
	}
	
	
	public function actionAjaxAddIngredient($id, $order_id, $productType, $total){
		
		
		//check to see if the form has been submitted
		$orderIngredient = new CustomerOrdersIngredients();
		
		
		
		//Form has been submitted process accordingly
		if ($orderIngredient->load(Yii::$app->request->post()))
			{
			if($orderIngredient->save()) 
				{
				return print_r($orderIngredient);
				}
				
				
			//form was submitted but failed to save correctly, resend the form through to be rendered
			else{
				return print_r($orderIngredient->getErrors());
				}
			}
		
		
		//Form being rendered for the first time
		else
			{
				
					
				
				
			if($id == "new"){
				$orderIngredient = new CustomerOrdersIngredients();
				$orderIngredient->order_id = $order_id;
				$orderIngredient->created_on = Date('Y-m-d');
				$orderIngredient->ingredient_percent = 100-$total;
				}	
			else{
				$orderIngredient = CustomerOrdersIngredients::findOne($id);
				}
			
			
			
			
			
			if(Lookup::item($productType, 'ORDER_CATEGORY') == "Commodity")
				{
				$productTypes = [3];
				}
			elseif(Lookup::item($productType, 'ORDER_CATEGORY') == "Mix")
				{
				$productTypes = [2];
				}
			elseif(Lookup::item($productType, 'ORDER_CATEGORY') == "Pellet")
				{
				$productTypes = [1];
				}
			elseif(Lookup::item($productType, 'ORDER_CATEGORY') == "Additive")
				{
				$productTypes = [4];
				}
			elseif(Lookup::item($productType, 'ORDER_CATEGORY') == "Custom")
				{
				$productTypes = [4,3,2,1];
				}
			elseif(Lookup::item($productType, 'ORDER_CATEGORY') == "Pellet - Custom")
				{
				$productTypes = [1,4];
				}
			
			
			
			$products = Product::find()
	        				->where(['status' => Product::ACTIVE])
	        				->where(['Product_Category' => $productTypes])
	        				->select(['id', 'Name', 'Mix_Type'])
	        				->all();
	        				
	   
	        $productList = ArrayHelper::map($products, 'id', 'Name') ;
			return $this->renderAjax("/customer-orders-ingredients/_orderAdd", ['model' => $orderIngredient, 'productList' => $productList]);
			}
		}
	



	public function actionAjaxUpdateIngredient($id)
		{
	
		$orderIngredient = CustomerOrdersIngredients::findOne($id);
		if ($orderIngredient->load(Yii::$app->request->post()))
			{
			if($orderIngredient->save()) 
				{
				return print_r($orderIngredient);
				}
			//form was submitted but failed to save correctly, resend the form through to be rendered
			else{
				return print_r($orderIngredient->getErrors());
				}
			}
		
		if (($model = customerOrdersIngredients::findOne($id)) == null) 
			{
            return "Ingredient not found, id given: ".$id."<br>";
        	}
		else{
			$products = [$model->ingredient_id => $model->product->Name];
			
			
			
			return $this->renderAjax("/customer-orders-ingredients/_orderUpdate", ['model' => $model, 'productList' => $products]);
			}
		}
	
	
	public function actionAjaxGetStorageDeliveryInstructions($storage_id)
		{
			
			if($storage_id != "")
				{
				$storage = Storage::findOne($storage_id);
				return $storage->Delivery_Instructions;		
				}
			return "";
		}

	public function actionAjaxCopy($id)
		{
		$order = CustomerOrders::findOne($id);
		if($order == null)
			{
			return false;
			}
		else{
			$newOrder = $order->copy();
			
			
			
			}
		}

	public function actionCopy($id)
		{
		$order = CustomerOrders::findOne($id);
		if($order == null)
			{
			return false;
			}
		else{
			$newOrder = $order->copy();
			
			return $this->redirect(['update', 'id' => $newOrder->id]);
			
			
			}
		}

	
}
