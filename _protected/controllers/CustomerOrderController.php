<?php

namespace app\controllers;

use Yii;
use app\models\customerOrders;
use app\models\customerOrdersSearch;
use app\models\Clients;
use app\models\CustomerOrdersIngredients;
use app\models\Product;
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
                    'delete' => ['post'],
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
        $searchModel = new customerOrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
    public function actionCreate()
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


		//Section for the eidtable content of the Form
		if (Yii::$app->request->post('hasEditable')) 
			{
			$ingredientID = Yii::$app->request->post('editableKey');
        	$model = CustomerOrdersIngredients::findOne($ingredientID);
        
        
			$out = Json::encode(['output'=>'', 'message'=>'']);
        	 
        	 
        	//get the array information from the POST vairable. in the post the value is seens as
        	//$_POST[CustomerOrdersIngredients][1][ingredient_percent] = XX
			$post = [];
	        $posted = current($_POST['CustomerOrdersIngredients']);
	       	$post['CustomerOrdersIngredients'] = $posted;
        	 
        	 if ($model->load($post)) 
        	 	{
        	 	$model->save();
        	 	$output = '';
        	 	
				$out = Json::encode(['output'=>$output, 'message'=>'']);
        	 	
        	 	
        	 	
        	 	}
        	 
			echo $out;
			return;
				
				
			}

        else if ($model->load(Yii::$app->request->post()) && $model->save()) 
        		{
        		//print_r(Yii::$app->request->post());
        		//print_r(Yii::$app->request->get());
        		
        		
        		//print_r($model->getErrors());
        		$get = Yii::$app->request->get();
        		if(isset($get['exit']) && $get['exit'] == 'false' )
        			{
					return $this->redirect(['update', 'id' => $model->id]);
					}
				else{
					return $this->redirect(['index']);
					}
            	//
        		} 
        else {
        	
        	
        	
        	
        	
        	$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=>null, 'submit'=> 'customer-order-form', 'confirm' => 'Save Current Order and Exit?'];
        	$actionItems[] = ['label'=>'Save', 'button' => 'save', 'overrideAction' =>'/customer-order/update?id='.$id.'&exit=false', 'url'=>null, 'submit'=> 'customer-order-form', 'confirm' => 'Save Current Order?'];
        	$actionItems[] = ['label'=>'Cancel', 'button' => 'cancel', 'url'=>'/customer-order/index', 'confirm' => 'Cancel Changes?'];
        	$actionItems[] = ['label'=>'Create Delivery', 'button' => 'truck', 'url'=>'/delivery/create?order_id='.$id, 'confirm' => 'Create Delivery?'];
        	
        	
        	$clientObjects = Clients::find()
        				->where('id != :id', ['id'=>Clients::DUMMY])
        				->select(['id', 'Company_Name'])
        				->all();
        	$clientList = ArrayHelper::map($clientObjects, 'id', 'Company_Name') ;
            return $this->render('update', [
                'model' => $model, 'clientList' => $clientList, 'actionItems' => $actionItems
            ]);
        }
    }

    /**
     * Deletes an existing customerOrders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
			
			
			$products = Product::find()
	        				->where(['status' => Product::ACTIVE])
	        				->where(['Product_Category' => $productType])
	        				->select(['id', 'Name'])
	        				->all();
	        $productList = ArrayHelper::map($products, 'id', 'Name') ;
			return $this->renderAjax("/customer-orders-ingredients/_orderAdd", ['model' => $orderIngredient, 'productList' => $productList]);
			}
		}
	
}
