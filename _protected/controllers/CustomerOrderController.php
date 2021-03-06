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
use kartik\mpdf\Pdf;
use webvimark\modules\UserManagement\models\User;

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

		$userList = User::getUserListArray();	
		$customerList = Clients::getActiveClientListArray();
		
		
		

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'actionItems' => $actionItems,
            'userList' => $userList,
            'customerList' => $customerList,
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


	public function actionCreateCustomerOrder($customer_id)
	{
		$model = new customerOrders(['scenario' => 'createDummy']);
		$model->Customer_id = $customer_id;
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
		return $this->redirect(['update', 'id' => $model->id]);
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
					$model->submitOrder();
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
				if($model->validate())
					{
					$actionItems[] = ['label'=>'Save & Submit', 'button' => 'truck', 'url'=>null, 'overrideAction' =>'/customer-order/update?id='.$model->id.'&submitOrder=true', 'submit'=> 'customer-order-form', 'confirm' => 'Save Current Order and Submit?'];
					if(!$model->client->isOnCreditHold())
						{
						$actionItems[] = ['label'=>'Copy Order', 'button' => 'copy', 'url'=>'/customer-order/copy?id='.$model->id];		
						}
					$actionItems[] = ['label'=>'Print', 'button' => 'print', 'print_url'=>'customer-order/print?id='.$model->id.'&autoPrint=1'];	
					}
				$model->clearErrors();
				$readOnly = false;
				}
			else{
				$actionItems[] = ['label'=>'Back', 'button' => 'back', 'url'=>'/customer-order/index'];
				if(!$model->client->isOnCreditHold())
					{
					$actionItems[] = ['label'=>'Copy Order', 'button' => 'copy', 'url'=>'/customer-order/copy?id='.$model->id];		
					}
				$actionItems[] = ['label'=>'Print', 'button' => 'print', 'print_url'=>'/customer-order/print?id='.$model->id.'&autoPrint=1'];
				
			}
			
        	
        	
        	$clientObjects = Clients::find()
        				->where('id != :id', ['id'=>Clients::DUMMY])
        				->select(['id', 'Company_Name', 'Trading_as', 'Credit_Hold'])
        				->all();
        				
        	//generate two list the client list to display and the credit hold list
        	$clientList = array();
        	$creditHoldList = array();
        	foreach($clientObjects as $clientObject)
        		{
				$clientList[$clientObject->id] = $clientObject->Company_Name;
				if($clientObject->isOnCreditHold())
					{
					$clientList[$clientObject->id] .= " (Credit Hold)";
					$creditHoldList[$clientObject->id] = ['disabled' => true];
					}
				}
        	//$clientList = ArrayHelper::map($clientObjects, 'id', 'clientListName') ;
        	
        	
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
                'creditHoldList' => $creditHoldList,
                
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
		
		
		
        $searchModel = new customerOrdersSearch();
        $dataProvider = $searchModel->getActiveOrders(Yii::$app->request->queryParams);
        $dataProvider->setPagination(false);

		$actionItems[] = ['label'=>'New', 'button' => 'new', 'url'=> '/customer-order/create?redirectTo=update-production-active'];
		$actionItems[] = ['label'=>'Submit Orders', 'button' => 'truck', 'addClass' => 'submit_orders', 'url'=> null];
		
		$userListArray = User::getUserListArray();
		$customerList = Clients::getActiveClientListArray();
        return $this->render('production-active-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'actionItems' => $actionItems,
            'userListArray' => $userListArray,
            'customerList' => $customerList,
        ]);
    }


 public function actionAjaxSubmitOrder($selectedOrders)
	{
		
		$order_id_array = explode(",", $selectedOrders);
		foreach($order_id_array as $order_id)
			{
			if (($order = customerOrders::findOne($order_id)) !== null) 
				{
        		$order->submitOrder();
    			}
    		else {
        		throw new NotFoundHttpException('The requested customer Order does not exist orderID: '.$orderId);
    			}
			}
		
		return 0;
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
					$model->submitOrder();
					
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
		
		
        $searchModel = new customerOrdersSearch();
        $dataProvider = $searchModel->getSubmittedOrders(Yii::$app->request->queryParams);
 		$dataProvider->setPagination(false);
 		
 		
		$actionItems[] = ['label'=>'Unsubmit Order(s)', 'button' => 'reversetruck', 'addClass' => 'unsubmit_orders', 'url'=> null];
		$userListArray = User::getUserListArray();
		$customerList = Clients::getActiveClientListArray();

        return $this->render('production-submitted-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'actionItems' => $actionItems,
            'userListArray' => $userListArray,
            'customerList' => $customerList,
        ]);
    }


	public function actionAjaxUnsubmitOrder($selectedOrders)
	{
		
		$order_id_array = explode(",", $selectedOrders);
		foreach($order_id_array as $order_id)
			{
			if (($order = customerOrders::findOne($order_id)) !== null) 
				{
        		$order->unSubmitOrder();
    			}
    		else {
        		throw new NotFoundHttpException('The requested customer Order does not exist orderID: '.$orderId);
    			}
			}
		
		return 0;
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
					$model->Status = CustomerOrders::STATUS_INPRODUCTION;
					$model->save();
					return $this->redirect(['delivery/create', 'order_id' => $model->id]);
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
			$actionItems[] = ['label'=>'Copy Order', 'button' => 'copy', 'url'=>'/customer-order/copy?id='.$model->id];
			$actionItems[] = ['label'=>'Print', 'button' => 'print', 'print_url'=>'/customer-order/print?id='.$model->id.'&autoPrint=1'];
			$actionItems[] = ['label'=>'Save & Process', 'button' => 'truck', 'url'=>null, 'overrideAction' =>'/customer-order/update-production-submitted?id='.$model->id.'&processOrder=true', 'submit'=> 'customer-order-form', 'confirm' => 'Save Current Order and Produce?'];
				
        	
        	
        	$clientObjects = Clients::find()
        				->where('id != :id', ['id'=>Clients::DUMMY])
        				->select(['id', 'Company_Name', 'Credit_Hold'])
        				->all();
        	
        	
        	
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
        	
        	
        	//generate two list the client list to display and the credit hold list
        	$clientList = array();
        	$creditHoldList = array();
        	foreach($clientObjects as $clientObject)
        		{
				$clientList[$clientObject->id] = $clientObject->Company_Name;
	
				if($clientObject->isOnCreditHold())
					{
					$clientList[$clientObject->id] .= " (Credit Hold)";
					$creditHoldList[$clientObject->id] = ['disabled' => true];
					}
				}
        	
        	
            return $this->render('update', [
                'model' => $model, 
                'clientList' => $clientList, 
                'actionItems' => $actionItems, 
                'storageList' => $storageList,
                'creditHoldList' => $creditHoldList,
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
		        'Sales_Status'=>Lookup::item($model->Sales_Status, 'CLIENT_STATUS'),
		        'nearestTown'=>$model->Nearest_Town,
		        'id'=>$model->id,
		        'storage' => $storageList,
		        'Herd_Size' => $model->Herd_Size,
		        'Feed_Rate_Kg_Day' => $model->Feed_Rate_Kg_Day,
		        'Feed_QOH_Tonnes' => $model->getFeedQOH(),
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
				
			//we also want to look up the product price and add this to the ingredient
			$orderIngredient->updatePrice();
			
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
	        				->select(['id', 'Name', 'Product_Category'])
	        				->all();
	        				
	   
	        $productList = ArrayHelper::map($products, 'id', 'Name', 'productTypeString');
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
			
			//print_r($newOrder->attributes);
			
			return $this->redirect(['update', 'id' => $newOrder->id]);
			//return $this->render('copy');
			
			}
		}
		
		
		
	

  public function actionPrint($id)
	{
		
	$order = CustomerOrders::findOne($id);
	
	$content = $this->renderPartial("_print", [
			'order' => $order,

			
			]);
		
		
	$pdf = new Pdf([
		'content' => $content,  
		//'destination' => Pdf::DEST_FILE, 
		//'filename' => 'c:\temp\test.pdf',
		'format' => Pdf::FORMAT_A4, 
 		'destination' => Pdf::DEST_BROWSER, 
		'options' => ['title' => 'Customer Order'],

		'methods' => 
			[
			
            'SetFooter'=>['{PAGENO}'],

			//"SetJS" => "'this.print();'",
			]
    	]);

	
 	return $pdf->render(); 

	}


	public function actionTest()
	{
		
		$order = CustomerOrders::findOne('78733');
		$order->emailOrder();
		
	}

	
}
