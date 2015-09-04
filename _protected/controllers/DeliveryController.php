<?php

namespace app\controllers;

use Yii;
use app\models\Delivery;
use app\models\DeliverySearch;
use app\models\CustomerOrders;
use app\models\Trucks;
use app\models\Trailers;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * DeliveryController implements the CRUD actions for Delivery model.
 */
class DeliveryController extends Controller
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

	    $this->view->params['menuItem'] = 'delivery';

	    return true; // or false to not run the action
	}



















    /**
     * Lists all Delivery models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DeliverySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $actionItems[] = ['label'=>'New', 'button' => 'new', 'url'=> '/delivery/create'];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'actionItems' => $actionItems,
        ]);
    }

    /**
     * Displays a single Delivery model.
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
     * Creates a new Delivery model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Delivery();


		//form has been submitted save the form accordingly
        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        	{
            return $this->redirect(['index']);
        	} 
       
       	//If the order has been seleted already, clicked the link from within the order
       	$order = new CustomerOrders();
       	if(($order_id = Yii::$app->request->get("order_id")) != null)
	       	{
	       
	       	//check that the order is a real order, if not throw an error
	       	 if (($order = customerOrders::findOne($order_id)) !== null) 
	       	 	{
	       	 		
	       	 	//if the order alread has a delivery created use that in the form
	       	 	if($order->hasDelivery())
	       	 		{
	       	 		$model = $order->delivery;
					}
					
				//prepopulate the field in the model
				else{
					$model->order_id = $order_id;
					}
       			} 
       		else{
            	throw new NotFoundHttpException('The requested page does not exist.');
        		}
			}

			
		$actionItems[] = ['label'=>'back', 'button' => 'back', 'url'=> 'index', 'confirm' => 'Exit with out saving?']; 
		$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'override' => '/delivery/update?id'.$model->id.'&exit=false', 'submit' => 'delivery-form', 'confirm' => 'Save Delivery?']; 
		$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=> null, 'submit' => 'delivery-form', 'confirm' => 'Save and Exit Delivery?']; 
		
		$submittedOrders = CustomerOrders::getSubmittedOrdersWithoutDelivery();
		$submittedOrderArray = ArrayHelper::map($submittedOrders, 'id', 'Name') ;
		
		
		
		return $this->render('create', [ 
			'model' => $model,
			'actionItems' => $actionItems,
			'submittedOrders' => $submittedOrderArray,
			'order' => $order
			]);
	}
	
       	
       	
       

    /**
     * Updates an existing Delivery model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Delivery model.
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
     * Finds the Delivery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Delivery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Delivery::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    /**
	* Function ajax-order-details
	* @Description: return the order details given the order id in ajax
	*/
     public function actionAjaxOrderDetails($id)
    {
    	if($id != null){
			$order =  CustomerOrders::findOne(['id'=>$id]);
			
	    	return \yii\helpers\Json::encode([
	    		'orderID' => $order->Order_ID,
		        'customer'=>$order->client->Company_Name,
		        'owner'=>$order->createdByUser->fullname,
		        'deliveryDate'=>date("D d-M-Y", strtotime($order->Requested_Delivery_by)),
		        'storage'=>$order->storage->Description,
		        'instructions'=>$order->Order_instructions,
		        'orderQTY'=>$order->Qty_Tonnes,
		        
		    ]);
		    }
		else{
			return True;
		}

	}
    
    
    /**
	* 
	* 	Function ajax-available-trucks
	* 	Descriptions: returns a list of available trucks based on the given date string
	* 
	* 
	*/
    public function actionAjaxAvailableTrucks()
	    {
	    $out = [];
		if (isset($_POST['depdrop_parents'])) 
			{	
			$requestedDate = strtotime($_POST['depdrop_parents'][0]);
			if($requestedDate)
				{
				$trucksAvailable = Trucks::getAvailable($requestedDate);
				
				foreach($trucksAvailable as $truckID => $truckRego){
					$out[] = array('id' => $truckID, 'name' => $truckRego);
					}
				
				
				echo Json::encode(['output'=>$out ]);	
				}	
			else{
				return False;
				}
			}
		}
		
	/**
	* 
	*  Function add Truck
	* Description: this action returns the truck display entries
	* 
	* 
	* @param undefined $truck_id
	* 
	* @return
	*/	
	public function actionAjaxAddTruck($truck_id, $requestedDate)
	{
		
	$truck = Trucks::findOne($truck_id);
	if($truck === null)
		{
		return "Unable to locate Required Truck";
		}
	else{
	
	
		$requestedDate = strtotime($requestedDate);
		$trailerList = Trailers::getAvailable($requestedDate);
	
		return $this->renderPartial("/trucks/_allocation", [
								'truck' => $truck,
								'trailerList' => $trailerList,
								]);
		}
    }
}
