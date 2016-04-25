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
use app\models\WeighbridgeTicket;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use kartik\mpdf\Pdf;
use yii\data\ArrayDataProvider;

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
        
        $actionItems= array();
        //$actionItems[] = ['label'=>'New', 'button' => 'new', 'url'=> '/delivery/create'];
		
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
        		
        	//print_r(Yii::$app->request->post());
        		
        	//create the Delivery Name other attributes already loaded such as the delivery date
        	$model->Name = Delivery::generateName($model->id); 
        	$model->status = Delivery::STATUS_INPROGRESS;
        	$model->delivery_qty = 0;
        	$model->save();			//save so we cna access the object id
	
			$deliveryLoads = Yii::$app->request->post("deliveryLoad");
			$deliveryLoadBins = Yii::$app->request->post("deliveryLoadBins");
			foreach($deliveryLoads as $deliveryCount => $deliveryLoad)
				{
				$deliveryLoadArray["DeliveryLoad"] = $deliveryLoad;
				$deliveryLoadObject = new DeliveryLoad();
				$deliveryLoadObject->load($deliveryLoadArray);
				$deliveryLoadObject->delivery_id = $model->id;
				$deliveryLoadObject->save();
				//first check that bins have been selected for that load - can have a case where there are none selected
				if(array_key_exists($deliveryCount, $deliveryLoadBins))
					{
					foreach($deliveryLoadBins[$deliveryCount]['bins'] as $bin_id => $loadValue)
						{
						$loadBin = new DeliveryLoadBin();
						$loadBin->bin_load = $loadValue;
						$loadBin->trailer_bin_id = $bin_id;
						$loadBin->delivery_load_id = $deliveryLoadObject->id;
						$loadBin->save();
						}			
					}		
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
				$model->num_batches = $model->calculateBatchSize($order->Qty_Tonnes);
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
        		
        	//create the Delivery Name other attributes already loaded such as the delivery date
        	$model->Name = Delivery::generateName($model->id); 
        	$model->status = Delivery::STATUS_INPROGRESS;
        	$model->delivery_qty = 0;
        	$model->save();			//save so we cna access the object id
	
			//Clear all the existing child objects from the database and recreate based on form Data
			$model->removeAllLoads();
				
	
			$deliveryLoads = Yii::$app->request->post("deliveryLoad");
			$deliveryLoadBins = Yii::$app->request->post("deliveryLoadBins");
			foreach($deliveryLoads as $deliveryCount => $deliveryLoad)
				{
				$deliveryLoadArray["DeliveryLoad"] = $deliveryLoad;
				$deliveryLoadObject = new DeliveryLoad();
				$deliveryLoadObject->load($deliveryLoadArray);
				$deliveryLoadObject->delivery_id = $model->id;
				$deliveryLoadObject->save();
				//first check that bins have been selected for that load - can have a case where there are none selected
				if(array_key_exists($deliveryCount, $deliveryLoadBins))
					{
					foreach($deliveryLoadBins[$deliveryCount]['bins'] as $bin_id => $loadValue)
						{
						$loadBin = new DeliveryLoadBin();
						$loadBin->bin_load = $loadValue;
						$loadBin->trailer_bin_id = $bin_id;
						$loadBin->delivery_load_id = $deliveryLoadObject->id;
						$loadBin->save();
						}			
					}		
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
        	
       
       
    	
        	//Once save, either stay on the page or exit. Controlled via the actiob buttons
        	$get = Yii::$app->request->get();
            if(isset($get['exit']) && $get['exit'] == 'false' )
    			{
				return $this->redirect(['update', 'id' => $model->id]);
				}
			
            elseif(isset($get['load']) && $get['load'] == 'true')
   				{
				return $this->redirect(['weighbridge-ticket/create', 'delivery_id' => $model->id]);
				}
   			else{
				return $this->redirect(['index']);
				}
    		} 
        
        
        
        
        
        
        
        
        
        
        
        
        
    
    else{
    	
    	$actionItems[] = ['label'=>'back', 'button' => 'back', 'url'=> 'index', 'confirm' => 'Exit with out saving?']; 
    	$actionItems[] = ['label'=>'Print Loader', 'button' => 'print', 'print_url'=> 'print-additive-loader-pdf?id='.$model->id."&autoPrint=1"]; 
		$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'overrideAction' => '/delivery/update?id='.$model->id.'&exit=false', 'submit' => 'delivery-form', 'confirm' => 'Save Delivery?']; 
		$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=> null, 'submit' => 'delivery-form', 'confirm' => 'Save and Exit Delivery?']; 
		if($model->hasWeighbridgeTicket())
			{
			$actionItems[] = ['label'=>'Weigh Ticket', 'button' => 'tags', 'url'=> '/weighbridge-ticket/update?id='.$model->weighbridgeTicket->id]; 		
			}
		else{
			$actionItems[] = ['label'=>'Save & Load', 'button' => 'truck_load', 'url'=> null, 'overrideAction' => '/delivery/update?id='.$model->id.'&load=true', 'submit' => 'delivery-form', 'confirm' => 'Save and Load Truck?']; 	
			}
		
		
	
		
		
		//$submittedOrders = CustomerOrders::getSubmittedOrdersWithoutDelivery();
		//$submittedOrderArray = ArrayHelper::map($submittedOrders, 'id', 'Name');
		
		//echo $model->delivery_on."<br>";
		///$trucksAvailable = Trucks::getTrucksUsageArray(strtotime($model->delivery_on));
		//$usedTrailerBins = TrailerBins::getUsedBins(strtotime($model->delivery_on))	;
		
	
	
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
       	if(isset($model->customerOrder))
       	{
		$model->customerOrder->unsetStatusDelivery();	
		}
        
       
       if($model->weighbridgeTicket)
        	{
			$model->weighbridgeTicket->delete();
			}
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
	public function actionAjaxAddDeliveryLoad($deliveryCount, $requestedDate, $delivery_id)
	{
		
		$deliveryLoad =  new DeliveryLoad();
		$deliveryLoad->delivery_on = $requestedDate;
	
		
		return $this->renderPartial("/delivery-load/_delivery_load_form", [
								'deliveryLoad' => $deliveryLoad,
								'deliveryCount' => $deliveryCount,
								'delivery_id' => $delivery_id,
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
    
    
    
    
    
    public function actionAjaxSelectTruck($requested_date, $deliveryCount, $selectedTrucks)
    {
		
		
	
		$truckList = Trucks::getActive();
		$trucksUsed = Trucks::getTrucksUsed($requested_date);
		
		//Ok unpack the information in the $selectedTrucks Variable. it should be an csv array of vairables
		// truckid_truckrunnum
		$selectedTruckRawArray = explode(",", $selectedTrucks);
		
		
		$selectedTrucksArray = array();
		foreach($selectedTruckRawArray as $truckDetails)
			{
			$details = explode("_", $truckDetails);
			$selectedTrucksArray[$details[1]][$details[0]] = $details[0];
			}
		
		//Ok if there are no trucks currently being used then just spit out the truck list with no modification
		//The $data array needs to have an index like truckid_runnum, 
		$data = array();
		if(count($trucksUsed == 0))
			{
			$delivery_run_num = 1;
			foreach($truckList as $truckObject)
				{
				//check to see if the truck has been selected on the form already
				$used = false;
				if(array_key_exists($truckObject->id, $selectedTrucksArray[$delivery_run_num]))
					{
					$used = true;
					}
					
					
				$data[1][] = [
					'id' => $truckObject->id, 
					'delivery_run_num' => $delivery_run_num,
					'truck' => substr($truckObject->registration." (".$truckObject->description.")", 0, 40),
				
					'max_trailers' => $truckObject->max_trailers,
					'max_load' => $truckObject->max_load,
					'Auger' => $truckObject->Auger,
					'Blower' => $truckObject->Blower,
					'Tipper' => $truckObject->Tipper,
					'used' => $used,

					];
				}	
			}
		
		
		/*$dataProvider = new ArrayDataProvider([
   			'allModels' => $data,
		    'sort' => [
		        'attributes' => ['id', 'username', 'email'],
		    	],
		    'pagination' => false
		]);
		*/
		
		return $this->renderPartial("/Trucks/_selectTruck", [
			'data' => $data,
			'deliveryCount' => $deliveryCount,
			'selectionDate' => $requested_date,
			
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
    
    
    public function actionAjaxGetDeliveryLoadTrailer($trailerSlot, $deliveryCount, $trailer_id, $trailer_run_num, $delivery_load_id)
    {
		
		
		
		$trailer = Trailers::findOne($trailer_id);
		$usedBins = array();
		$selectedBins = array();
		
		
		
		return $this->renderPartial('/Trailers/_trailer',
				[
				'trailer_slot_num' => $trailerSlot,
				'deliveryCount' => $deliveryCount, 
				'trailer' => $trailer,
				'trailer_run_num' => $trailer_run_num,
				'usedBins' => $usedBins,
				'selectedBins' => $selectedBins,
				]);
	
		
		
		
	}
    
    public function actionAjaxGetDeliveryLoadTruck($deliveryCount, $truck_id, $truck_run_num, $delivery_load_id)
    {
		$truck = Trucks::findOne($truck_id);
		
		return $this->renderPartial('/Trucks/_truck',
			[
			'truck' => $truck,
			'deliveryCount' => $deliveryCount,
			'truck_run_num' => $truck_run_num,
			]
		);
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
    public function actionAjaxSelectTrailers($requested_date, $deliveryCount, $trailerSlot, $selectedTrailers)
    	{
    		
    		
    	//A list of all the currently active trailers
		$trailerList = Trailers::getAllActiveTrailers();
		
		
		
		//this wil return an array [Delivery_run_num][trailer_id] => ['binsUsed' => X, 'tonsUsed' => Y, 'truck_id' => XX, 'trailer_slot_2_id' => YY]
		$trailersUsed = Trailers::getTrailersUsed(strtotime($requested_date));
		
		
	
		//a list of the trailers already on the page, a trailer cannot be selected twice
		$selectedTrailerList = explode(",", $selectedTrailers); // should be an array of trailer_id + "_" + trailer_run_num
		
		
		

		
		
		//Ok if there are no trailers currently being used then just spit out the trail list with no modification
		//The $data array needs to have an index like trailerid_runnum, 
		$data = array();
		if(count($trailersUsed == 0))
			{
			foreach($trailerList as $trailerObject)
				{
				$data[] = [
					'id' => $trailerObject->id, 
					'delivery_run_num' => 1,
					'trailer' => substr($trailerObject->Registration." (".$trailerObject->Description.")", 0, 40),
					'bins' => $trailerObject->NumBins,
					'tons' => $trailerObject->Max_Capacity,
					//'default_truck_id' => $trailerObject->default_truck_id,
					//'default_trailer_pair_id' => $trailerObject->default_trailer_pair_id,
					];
				}	
			}
		
		
		/*$dataProvider = new ArrayDataProvider([
   			'allModels' => $data,
		    'sort' => [
		        'attributes' => ['id', 'username', 'email'],
		    	],
		    'pagination' => false
		]);
		*/
		
		return $this->renderPartial("/trailers/_selectTrailers", [
			'data' => $data,
			'trailerList' => $trailerList,
			'deliveryCount' => $deliveryCount,
			'trailerSlot' => $trailerSlot,
			'selectionDate' => $requested_date,
			
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
    
    
    /**
	* Action to print the additive and loader sheet for the delivery/order
	* 
	* @return
	*/
    public function actionPrintAdditiveLoaderPdf($id, $autoPrint = false, $saveLocal=false)
	{
		
	$defaultLocalSaveLocation = "C:\\IrwinsOrders\\a4Printer\\";
		
	$delivery = Delivery::findOne($id);
	
	$content = $this->renderPartial("additive-loader", [
			'delivery' => $delivery,
			]);


		
	$methods = 
		[
		'SetFooter'=>['{PAGENO}'],
		];
	if($autoPrint)
		{
		$methods['SetJS'] = "'this.print();'"	;
		}
		
	if($saveLocal)
		{
		$localPdf = new Pdf([
			'content' => $content,  
			'destination' => Pdf::DEST_FILE, 
			'filename' => $defaultLocalSaveLocation.$delivery->Name.'.pdf',
			'format' => Pdf::FORMAT_A4, 
			'options' => ['title' => 'Additive Loader Sheet'],
			'methods' => $methods,
	    	]);
	    	
	    $localPdf->render();
		}


	$pdf = new Pdf([
		'content' => $content,  
		
		'format' => Pdf::FORMAT_A4, 
 		'destination' => Pdf::DEST_BROWSER, 
		'options' => ['title' => 'Additive Loader Sheet'],

		'methods' => $methods,
    	]);
	
	
	
 	return $pdf->render(); 

	}
	
    
    
    
}

    
    
    

