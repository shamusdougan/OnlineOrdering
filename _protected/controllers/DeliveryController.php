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
    public function actionCreate($order_id = null)
    {
        $model = new Delivery();


		//form has been submitted save the form accordingly
        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        	{
        	//create the Delivery Name other attributes already loaded such as the delivery date
        	$model->Name = Delivery::generateName($model->id); 
        	$model->status = Delivery::STATUS_INPROGRESS;
        	$model->delivery_qty = 0;
        	$model->save();			//save so we cna access the object id
		
			if(($deliveryLoadArray = Yii::$app->request->post("deliveryLoad")) !== null)
				{
					
				//Create the Basic Delivery Load Object
				foreach($deliveryLoadArray as $deliveryLoad)	
					{
						
					//Create the Delivery Load Object and 
					$deliveryLoadObject = new DeliveryLoad();
					$deliveryLoadObject->delivery_id = $model->id;
					$deliveryLoadObject->truck_id = $deliveryLoad['truck_id'];
					$deliveryLoadObject->delivery_run_num = $deliveryLoad['delivery_run_num'];
					$deliveryLoadObject->delivery_on = $model->delivery_on;
					$deliveryLoadObject->save();
					
					//Create the deliveryLoad Trailer objects
					if(array_key_exists('trailers', $deliveryLoad))
						{
						foreach($deliveryLoad['trailers'] as $trailer_id)
							{
							$deliveryLoadTrailerObject = new DeliveryLoadTrailer();
							$deliveryLoadTrailerObject->delivery_load_id = $deliveryLoadObject->id;
							$deliveryLoadTrailerObject->trailer_id = $trailer_id;
							$deliveryLoadTrailerObject->save();
							}		
						}
					
					
					//create the deliveryLoadBinObjects
					if(array_key_exists('truck_load', $deliveryLoad))
						{
						foreach($deliveryLoad['truck_load'] as $trailer_id => $trailerBins)
							{
							foreach($trailerBins as $trailerbin_id => $binLoad)
								{
								$deliveryLoadBin = new DeliveryLoadBin();
								$deliveryLoadBin->bin_load = $binLoad[0];
								$deliveryLoadBin->trailer_bin_id = $trailerbin_id;
								$deliveryLoadBin->delivery_load_id = $deliveryLoadObject->id;
								$deliveryLoadBin->save();
								}	
							}
						}
					}
					
				//update the delivery details based on the deliveryLoad.bin just created
				$model->updateDeliveryQty();
        		$model->save();
				}
			
	
			
        	
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
       
       
       
       	/**
		   * 
		   * New delivery processing
		   * 
		   */
       	//get the customer order information
        if (($order = customerOrders::findOne($order_id)) !== null) 
       	 	{
       	 		
       	 	//if the order alreadY has a delivery created use that in the form
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
        	throw new NotFoundHttpException('The requested customer order cannot be found.');
    		}
       
			

			
		$actionItems[] = ['label'=>'back', 'button' => 'back', 'url'=> 'index', 'confirm' => 'Exit with out saving?']; 
		$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'overrideAction' => '/delivery/create?exit=false', 'submit' => 'delivery-form', 'confirm' => 'Save Delivery?']; 
		$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=> null, 'submit' => 'delivery-form', 'confirm' => 'Save and Exit Delivery?']; 
	
		
		return $this->render('create', [ 
			'model' => $model,
			'actionItems' => $actionItems,
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
    	$model = Delivery::findOne($model->id);
    	

    	//this array contains all of the data about where the order has been loaded into.        		
    	 if ($model->load(Yii::$app->request->post()) && $model->save()) 
        	{
        	//create the Delivery Name other attributes already loaded such as the delivery date
        	$model->delivery_qty = 0;
        	$model->save();			//save so we cna access the object id
		
			if(($deliveryLoadArray = Yii::$app->request->post("deliveryLoad")) !== null)
				{
					
				//Create the Basic Delivery Load Object
				foreach($deliveryLoadArray as $deliveryLoad)	
					{
						
					//Create the Delivery Load Object and 
					$deliveryLoadObject = new DeliveryLoad();
					$deliveryLoadObject->delivery_id = $model->id;
					$deliveryLoadObject->truck_id = $deliveryLoad['truck_id'];
					$deliveryLoadObject->delivery_on = $model->delivery_on;
					$deliveryLoadObject->save();
					
					//Create the deliveryLoad Trailer objects
					if(array_key_exists('trailers', $deliveryLoad))
						{
						foreach($deliveryLoad['trailers'] as $trailer_id)
							{
							$deliveryLoadTrailerObject = new DeliveryLoadTrailer();
							$deliveryLoadTrailerObject->delivery_load_id = $deliveryLoadObject->id;
							$deliveryLoadTrailerObject->trailer_id = $trailer_id;
							$deliveryLoadTrailerObject->save();
							}		
						}
					
					
					//create the deliveryLoadBinObjects
					if(array_key_exists('truck_load', $deliveryLoad))
						{
						foreach($deliveryLoad['truck_load'] as $trailer_id => $trailerBins)
							{
							foreach($trailerBins as $trailerbin_id => $binLoad)
								{
								$deliveryLoadBin = new DeliveryLoadBin();
								$deliveryLoadBin->bin_load = $binLoad[0];
								$deliveryLoadBin->trailer_bin_id = $trailerbin_id;
								$deliveryLoadBin->delivery_load_id = $deliveryLoadObject->id;
								$deliveryLoadBin->save();
								}	
							}
						}
					}
					
				//update the delivery details based on the deliveryLoad.bin just created
				$model->updateDeliveryQty();
        		$model->save();
				}
    		}
    	
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
		$trucksAvailable = Trucks::getTrucksUsageArray(strtotime($model->delivery_on));
		$usedTrailerBins = TrailerBins::getUsedBins(strtotime($model->delivery_on))	;
		
	
	
		return $this->render('update', [ 
			'model' => $model,
			'actionItems' => $actionItems,
			'order' => $model->customerOrder,
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
    public function actionAjaxAvailableTrucks($requestedDate)
	    {
	    
	    
	    $truckList = Trucks::getTrucksUsageArray(strtotime($requestedDate));
	    
	    
		//print_r($truckList);	
		
		
		    
		
	    
	    
	    
	    
	    
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
	public function actionAjaxAddDeliveryLoad($deliveryCount)
	{
		return $this->renderPartial("/delivery-load/_form", [
								'deliveryLoad' => new DeliveryLoad(),
								'deliveryCount' => $deliveryCount,
								]);
		
    }
    
    
    public function actionAjaxUpdateDeliveryLoad($truck_id, $selected_trailers, $requestedDate)
    	{
    		
    		$requestedDate = strtotime($requestedDate);
    		$truck = Trucks::findOne($truck_id);
			if($truck === null)
				{
				return "Unable to locate Required Truck";
				}
    		$selectedTrailerObjects = array();
    		
    		$selected_trailers = json_decode($selected_trailers);
			foreach($selected_trailers as $trailer_id)
				{
				$selectedTrailerObjects[] = Trailers::findOne($trailer_id);
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
	* @param undefined $truck_id
	* @param undefined $selected_trailers
	* @param undefined $requestedDate
	* 
	* @return
	*/
     public function actionAjaxRemoveTrailer($truck_id, $trailer_id, $delivery_id)
    	{
    		
    		$delivery = Delivery::findOne($delivery_id);
    		$truck = Trucks::findOne($truck_id);
			if($truck === null)
				{
				return "Unable to locate Required Truck";
				}
    		$selectedTrailerObjects = array();
    		
    		
    		//remove the trailer bins from this order first 
    		$delivery->removeLoadFromTrailer($trailer_id);
    		
    		
    		//need to check to make sure that no other dleiveries have bin on this trailer/tuck,
    		$deliveryLoads = DeliveryLoad::getAllDeliveryLoadsOn($delivery->getPhpDeliveryOnDate());
    		foreach($deliveryLoads as $deliveryLoad)
    			{
				$result = $deliveryLoad->removeTrailer($trailer_id);
				if(!$result)
					{
					die("unable to delete trailer found a load attached to it");
					}
				}

			//check to see if any of the trailerbins are already being used on the requested date
			$usedTrailerBins = TrailerBins::getUsedBins($delivery->getPhpDeliveryOnDate())	;
				
			return $this->renderPartial("/trucks/_allocationInner", [
								'truck' => $truck,
								'selectedTrailers' => $selectedTrailerObjects,
								'usedTrailerBins' => $usedTrailerBins,
								]);		
		}
    
    
    /**
	* 
	* @param undefined $requested_date
	* @param undefined $currentlySelectedTrailers -> array of trailer_ids
	* @param undefined $truck_id
	* 
	* @return
	*/
    public function actionAjaxAddTrailers($requested_date, $selected_trailers, $truck_id)
    {
		
		
		
		$trailerList = Trailers::getAllActiveTrailers();
		$trailersUsed = Trailers::getTrailersUsed(strtotime($requested_date));
		$trailersSelectedOnForm = explode(",", $selected_trailers);
		
		return $this->renderPartial("/trailers/_trailerList", [
			'trailerList' => $trailerList,
			'trailersUsed' => $trailersUsed,
			'selected_trailers' => $trailersSelectedOnForm,
			'truck_id' => $truck_id,
			]);
		
		
	}
    
    
    
    
    
    public function actionAjaxSelectTruck($requested_date, $target_delivery_load, $extra_used_trucks)
    {
		
		$requested_date = strtotime($requested_date);
	
		$truckList = Trucks::getActive();
		$truckLoads = Trucks::getTrucksUsageArray($requested_date);
		
		
		
		//put all the active trucks in the first delivery run
		$delivery_run_num = 1;
		foreach($truckList as $truck)
			{
			$textDisplay = $truck->registration;
			if(array_key_exists($delivery_run_num, $truckLoads) && array_key_exists($truck->id, $truckLoads[$delivery_run_num]))
				{
				$textDisplay .= " (Remaining ".$truckLoads[$delivery_run_num][$truck->id]." )";
				}
			
			$data['Available Trucks'][$truck->id."_".$delivery_run_num] = $textDisplay;
			}
		
		//any additional delivery_runs from the database need to be added in here
		











		//any extra delivery runs only added on the page and not saved need to added in here
		if($extra_used_trucks != "" && $extra_used_trucks != null)
			{
			$extra_runs_array = explode(",", $extra_used_trucks);
			
	
			foreach($extra_runs_array as $extra_run)
				{
				$extra_delivery_run_array = explode("_", $extra_run);
				$extra_truck_id = $extra_delivery_run_array[0];
				$extra_delivery_run_id = $extra_delivery_run_array[1];
				
				//check to see if it already is in the data, if not add it
				if(!(array_key_exists("Delivery Run ".$extra_delivery_run_id, $data) && array_key_exists($extra_truck_id, $data["Delivery Run ".$extra_delivery_run_id])))
					{
					$extra_truck = Trucks::findOne($extra_truck_id);
					$data["Delivery Run ".$extra_delivery_run_id][$extra_truck_id."_".$extra_delivery_run_id] = $extra_truck->registration;
					}
				}
			}
		
		
		
		
		return $this->renderPartial ("/trucks/_selectTruck", [
			"data" => $data,
			"target_delivery_load" => $target_delivery_load,
			
		
		
		]);
	}
    
    
    
    
    /**
	* 
	*   Function: This should return the truck information
	* 
	* @param undefined $truck_id
	* @param undefined $deliveryrun_id
	* 
	* @return
	*/
    public function actionAjaxAddTruck($target_delivery_load, $truck_id, $delivery_run_num, $requestedDate, $usedTrailers)
    {
    	
    	$requestedDate = strtotime($requestedDate);
    	$truck = Trucks::findOne($truck_id);
    	
    	
    	//check to see if the truck is already in a load -> if so return the trailers for that load
    	$trailer1_id = null;
    	$trailer2_id = null;
    	if(($deliveryLoad_id = $truck->isUsedAlready($requestedDate, $delivery_run_num)) !== false)
    		{
			$assignedDeliveryLoad = DeliveryLoad::findOne($deliveryLoad_id);
			
			$i = 1;
			foreach($assignedDeliveryLoad->deliveryLoadTrailer as $deliveryLoadTrailer)
				{
				if($i == 1){$trailer1_id = $deliveryLoadTrailer->trailer_id;}
				if($i == 2){$trailer2_id = $deliveryLoadTrailer->trailer_id;}
				$i++;
				}
			}
		// if its not in a load already check to see if the default trailers are available if so loadthem into trailer1_id and trailer2_id
    	else{
    		
			//This will generate an array that looks like
			//$used_trailer_array = array($trailer_id . "_" . $delivery_run_num;
    		$used_trailer_array = explode(",", $usedTrailers);
    		
				
    		$i = 1;    		
			foreach($truck->defaultTrailers as $defaultTrailer)
				{
					
				//Check to see if the default trailer has already been assigned to another delivery_load
				if(!$defaultTrailer->trailer->isAlreadyAssigned($requestedDate, $delivery_run_num))
					{
					//also check to see that that trailer has already been put into the page	
					$searchString = $defaultTrailer->trailer_id."_".$delivery_run_num;
					if(array_search($searchString, $used_trailer_array) === false)
						{
						if($i == 1){$trailer1_id = $defaultTrailer->trailer_id;}
						if($i == 2){$trailer2_id = $defaultTrailer->trailer_id;}
						}
					}
				$i++;
				}
			}
    	
    	
  	
		return 	$this->renderPartial('/Trucks/_truck', [
			'truck' => $truck,
			'deliveryCount' => $target_delivery_load,
			'trailer1_id' => $trailer1_id,
			'trailer2_id' => $trailer2_id,
			'delivery_run_num' => $delivery_run_num,
	    	]);	
	}
    
    
    
    
    
    
    public function actionAjaxAppendTrailer($truck_id, $selected_trailer_id, $requested_date)
    {
		
		$usedTrailerBins = TrailerBins::getUsedBins(strtotime($requested_date));
		$trailer = Trailers::findOne($selected_trailer_id);
		return $this->renderPartial("/trailers/_trailer", [
			'trailer' => $trailer,
			'truck_id' => $truck_id,
			'usedTrailerBins' => $usedTrailerBins,
			'delivery' => null,
			]);
		
	}
    
    
    public function actionAjaxGetTrailer($trailer_id, $delivery_run_num, $delivery_id, $target_delivery_load, $trailer_slot_num)
    {
		
	
	
		$trailer = Trailers::findOne($trailer_id);
	
		
		
		return $this->renderPartial("/trailers/_trailer", [
			'trailer' => $trailer,
			'delivery_run_num' => $delivery_run_num,
			'target_delivery_load' => $target_delivery_load,
			'trailer_slot_num' => $trailer_slot_num,
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
    public function actionAjaxSelectTrailers($target_delivery_load, $delivery_run_num, $requestedDate, $usedTrailers, $trailer_slot_num)
    	{
		$trailerList = Trailers::getAllActiveTrailers();
		$trailersUsed = Trailers::getTrailersUsed(strtotime($requestedDate), $delivery_run_num);
		$trailersUsed=  ArrayHelper::map($trailersUsed, 'id', 'Registration');
		
		$usedTrailers = explode(",", $usedTrailers); // should be an array of trailer_id + "_" + delivery_run_num
		
		//need to write a function that removes any trailers that are in the trailersUsed or usedTrailer arrays
		$data = array();
		foreach($trailerList as $trailerObject)
			{
			$searchString = $trailerObject->id."_".$delivery_run_num;
			
			//If the trailer isnt in the database as having been used and the not in the current display trailers then use it
			if(!array_key_exists($trailerObject->id, $trailersUsed) && array_search($searchString, $usedTrailers) === false)
				{
				$data[$trailerObject->id] = $trailerObject->Registration;
				}
			}
		
		
		return $this->renderPartial("/trailers/_trailerList", [
			'data' => $data,
			'target_delivery_load' => $target_delivery_load,
			'trailer_slot_num' => $trailer_slot_num,
			
			]);
			
		}
    
    /**
	* 
	* Function actionAjaxRemoveDeliveryLoad
	* 
	* 
	*/
    public function actionAjaxRemoveDeliveryLoad($truck_id, $delivery_id)
    {
    	$response_array['status'] = 'success';
		if (($delivery = Delivery::findOne($delivery_id)) == null)
		 	{
	 	  	$response_array['status'] = 'error';  
		 	}
		
		
		foreach($delivery->deliveryLoad as $delivery_load)
			{
			if($delivery_load->truck_id == $truck_id)
				{
					$delivery_load->removeAllLoads();
				}
			}
		
		echo json_encode($response_array);;
	}
    
    
    
}

    
    
    

