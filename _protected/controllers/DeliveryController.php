<?php

namespace app\controllers;

use Yii;
use app\models\Delivery;
use app\models\DeliveryLoad;
use app\models\DeliveryLoadBin;
use app\models\DeliveryLoadTrailer;
use app\models\DeliverySearch;
use app\models\CustomerOrders;
use app\models\Trucks;
use app\models\Trailers;
use app\models\TrailerBins;
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

        	//create the Delivery Name other attributes already loaded such as the delivery date
        	$model->Name = Delivery::generateName($model->id); 
        	$model->delivery_qty = 0;
        	$model->save();			//save so we cna access the object id
			

			//Record the trailers assigned for this delivery
		
	
        	

        	//Foreach truck in the delivery. if no truck was selected pass on the dummy variable
        	if(($loadOutArray = Yii::$app->request->post("truck_load")) === null)
        		{
        		$loadOutArray = array();
				}
				
			//Ok the load out array is kinda complex
        	foreach($loadOutArray as $truck_id => $trailer_array)
        		{
        		$deliveryLoad = new DeliveryLoad();
        		$deliveryLoad->delivery_id = $model->id;
        		$deliveryLoad->truck_id = $truck_id;
        		$deliveryLoad->delivery_on = $model->delivery_on;
        		if(!$deliveryLoad->save())
        			{
        			foreach($deliveryLoad->getErrors() as $message)
        				{
							echo $message[0]."<br>";
						}
        			die("failed to Create Delivery Load Record");
        			}
        		
        		$deliveryLoad->load_qty = 0;
        		
        		//allocate the selected trailers to the delivery load.
        		//The selected trailers array should look like trailers[truck_id][trailer_id]
        		if(($trailersSelected = Yii::$app->request->post("trailer")) === null)
					{
						$trailersSelected = array();
					}
					

				foreach($trailersSelected[$truck_id] as $trailer_id => $value)
					{
					$deliveryLoadTrailer = new DeliveryLoadTrailer();
	        		$deliveryLoadTrailer->delivery_load_id = $deliveryLoad->id;
	        		$deliveryLoadTrailer->trailer_id = $trailer_id;
					if(!$deliveryLoadTrailer->save())
	        			{
	        			foreach($deliveryLoadTrailer->getErrors() as $message)
	        				{
								echo $message[0]."<br>";
							}
	        			die("failed to Create Delivery Load Trailer Record");
	        			}	
					}
        		
        		
        		
	        	foreach($trailer_array as $trailer_id => $trailer_bins_array)
	        		{
	        		

	        		
	        		//Go through each bin loaded in the order
					foreach($trailer_bins_array as $trailerBin_id => $trailer_load_amount)
						{
						
						$deliveryLoadBin = new DeliveryLoadBin();
						$deliveryLoadBin->delivery_load_id = $deliveryLoad->id;
						$deliveryLoadBin->trailer_bin_id = $trailerBin_id;
						$deliveryLoadBin->bin_load = $trailer_load_amount[0];
						$deliveryLoad->load_qty += $trailer_load_amount[0];
						if(!$deliveryLoadBin->save())
		        			{
		        			foreach($deliveryLoad->getErrors() as $message)
		        				{
									echo $message[0]."<br>";
								}
		        			die("failed to Create Delivery Load Record");
		        			}
		        		$deliveryLoad->save();
						}
						
					$model->delivery_qty += $deliveryLoad->load_qty;
					}
				}
        	$model->save();
        	
        	//update the Customer Order as well
        	$model->customerOrder->setStatusDelivery($model->id);

      
            //Once save, either stay on the page or exit. Controlled via the actiob buttons
            $get = Yii::$app->request->get();
            if(isset($get['exit']) && $get['exit'] == 'false' )
	    			{
					return $this->redirect(['update', 'id' => $model->id]);
					}
				else{
					return $this->redirect(['index']);
					}
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
		$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'overrideAction' => '/delivery/create?exit=false', 'submit' => 'delivery-form', 'confirm' => 'Save Delivery?']; 
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
    
    
    
    
	//form has been submitted save the form accordingly
    if ($model->load(Yii::$app->request->post()) && $model->save()) 
    	{
        
		
		
    	
    	//remove the old loading data and create the new, even if it is the Same
    	$model->removeAllLoads();
    	$model->delivery_qty = 0;
    	
    	//this array contains all of the data about where the order has been loaded into.        		
    	$loadOutArray = Yii::$app->request->post("truck_load");
    	if($loadOutArray === null)
    		{
				$loadOutArray = array();
			}
    	
    	
    	foreach($loadOutArray as $truck_id => $trailer_array)
    		{
    		$deliveryLoad = new DeliveryLoad();
    		$deliveryLoad->delivery_id = $model->id;
    		$deliveryLoad->truck_id = $truck_id;
    		$deliveryLoad->delivery_on = $model->delivery_on;
    		if(!$deliveryLoad->save())
    			{
    			foreach($deliveryLoad->getErrors() as $message)
    				{
						echo $message[0]."<br>";
					}
    			die("failed to Create Delivery Load Record");
    			}
    		
    		$deliveryLoad->load_qty = 0;
    		
    		//allocate the selected trailers to the delivery load.
    		//The selected trailers array should look like trailers[truck_id][trailer_id]
    		if(($trailersSelected = Yii::$app->request->post("trailer")) === null)
				{
					$trailersSelected = array();
				}
				

			foreach($trailersSelected[$truck_id] as $trailer_id => $value)
				{
				$deliveryLoadTrailer = new DeliveryLoadTrailer();
        		$deliveryLoadTrailer->delivery_load_id = $deliveryLoad->id;
        		$deliveryLoadTrailer->trailer_id = $trailer_id;
				if(!$deliveryLoadTrailer->save())
        			{
        			foreach($deliveryLoadTrailer->getErrors() as $message)
        				{
							echo $message[0]."<br>";
						}
        			die("failed to Create Delivery Load Trailer Record");
        			}	
				}
    		
    		
    		
        	foreach($trailer_array as $trailer_id => $trailer_bins_array)
        		{
        		

        		
        		//Go through each bin loaded in the order
				foreach($trailer_bins_array as $trailerBin_id => $trailer_load_amount)
					{
					
					$deliveryLoadBin = new DeliveryLoadBin();
					$deliveryLoadBin->delivery_load_id = $deliveryLoad->id;
					$deliveryLoadBin->trailer_bin_id = $trailerBin_id;
					$deliveryLoadBin->bin_load = $trailer_load_amount[0];
					$deliveryLoad->load_qty += $trailer_load_amount[0];
					if(!$deliveryLoadBin->save())
	        			{
	        			foreach($deliveryLoad->getErrors() as $message)
	        				{
								echo $message[0]."<br>";
							}
	        			die("failed to Create Delivery Load Record");
	        			}
	        		$deliveryLoad->save();
					}
					
				$model->delivery_qty += $deliveryLoad->load_qty;
				}
			}
    	$model->save();
    	
    		
        		
        	
        	//Once save, either stay on the page or exit. Controlled via the actiob buttons
        	$get = Yii::$app->request->get();
            if(isset($get['exit']) && $get['exit'] == 'false' )
	    			{
					return $this->redirect(['update', 'id' => $model->id]);
					}
				else{
					return $this->redirect(['index']);
					}
            
   
    	} 
        
        
        
        
        
        
        
        
        
        
        
        
        
    
    else{
    	
    	$actionItems[] = ['label'=>'back', 'button' => 'back', 'url'=> 'index', 'confirm' => 'Exit with out saving?']; 
		$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'overrideAction' => '/delivery/update?id='.$model->id.'&exit=false', 'submit' => 'delivery-form', 'confirm' => 'Save Delivery?']; 
		$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=> null, 'submit' => 'delivery-form', 'confirm' => 'Save and Exit Delivery?']; 
		
		$submittedOrders = CustomerOrders::getSubmittedOrdersWithoutDelivery();
		$submittedOrderArray = ArrayHelper::map($submittedOrders, 'id', 'Name');
		
		//echo $model->delivery_on."<br>";
		$trucksAvailable = Trucks::getAvailable(strtotime($model->delivery_on));
		$usedTrailerBins = TrailerBins::getUsedBins(strtotime($model->delivery_on))	;
		
	
	
		return $this->render('update', [ 
			'model' => $model,
			'actionItems' => $actionItems,
			'submittedOrders' => $submittedOrderArray,
			'order' => $model->customerOrder,
			'truckList' => $trucksAvailable,
			'usedTrailerBins' => $usedTrailerBins,
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
        $model = $this->findModel($id);
        $model->removeAllLoads();
        $model->customerOrder->unsetStatusDelivery();
  		$model->delete();

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
	public function actionAjaxAddDeliveryLoad($truck_id, $requestedDate)
	{
		
	$truck = Trucks::findOne($truck_id);
	if($truck === null)
		{
		return "Unable to locate Required Truck";
		}
	else{
	
	
		//check to see if the truck already has a load, if so allocate the trailers already assigned, if not assign the default trailers.
		$requestedDate = strtotime($requestedDate);
	
		$selectedTrailers = $truck->isTruckAssigned($requestedDate);	

		//If the selected truck hasn't yet been assigned then grab the default trailers for that truck if available
		if(!$selectedTrailers)
			{
			$selectedTrailers = array();	
			foreach($truck->defaultTrailers as $defaultTrailer)
				{
				if(!$defaultTrailer->trailer->isAlreadyAssigned($requestedDate))
					{
					$selectedTrailers[] = $defaultTrailer->trailer;
					}
				}	
			}	
		
		
		
		
		
		
		
		//check to see if any of the trailerbins are already being used on the requested date
		$usedTrailerBins = TrailerBins::getUsedBins($requestedDate)	;
	

	
		return $this->renderPartial("/trucks/_allocation", [
								'truck' => $truck,
								'selectedTrailers' => $selectedTrailers,
								'delivery' => null,
								'usedTrailerBins' => $usedTrailerBins,
								]);
		}
    }
    
    
    public function actionAjaxUpdateDeliveryLoad($truck_id, $selected_trailers, $requestedDate)
    	{
    		
    		
    		$truck = Trucks::findOne($truck_id);
			if($truck === null)
				{
				return "Unable to locate Required Truck";
				}
    		$selectedTrailerObjects = array();
    		
    		$selected_trailers = json_decode($selected_trailers);
			foreach($selected_trailers as $trailer_id)
				{
				$selectedTrailerObjects[] = Trailers::find()->where(['id' => $trailer_id])->one();
				}


			//check to see if any of the trailerbins are already being used on the requested date
			$usedTrailerBins = TrailerBins::getUsedBins($requestedDate)	;
				
			return $this->renderPartial("/trucks/_allocationInner", [
								'truck' => $truck,
								'selectedTrailers' => $selectedTrailerObjects,
								'usedTrailerBins' => $usedTrailerBins,
								]);		
		}
    
    
    
    
    
    /**
	* 
	*  Function Select Trailers
	* Description: this action returns the display code to select a given trailer
	* 
	* 
	* @param undefined $truck_id
	* 
	* @return
	*/	
    public function actionAjaxSelectTrailers($requested_date, $selected_trailers, $truck_id, $all_trailers)
    	{
		$trailerList = Trailers::getAllActiveTrailers();
		$trailersUsed = Trailers::getTrailersUsed(strtotime($requested_date));
		$used_trailers = explode(",", $all_trailers);
		
		return $this->renderPartial("/trailers/_trailerList", [
			'trailerList' => $trailerList,
			'trailersUsed' => $trailersUsed,
			'selected_trailers' => explode(",", $selected_trailers),
			'truck_id' => $truck_id,
			'used_trailers' => $used_trailers,
			]);
			
		}
    
    
    
    
    
    
}
