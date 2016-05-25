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
use app\models\returns;
use app\models\Clients;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use kartik\mpdf\Pdf;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;

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
        	$model->save();			//save so we cna access the object id
	
			$deliveryLoads = Yii::$app->request->post("deliveryLoad");
			$deliveryLoadBins = Yii::$app->request->post("deliveryLoadBins");
			if(isset($deliveryLoads))
				{
				foreach($deliveryLoads as $deliveryCount => $deliveryLoad)
					{
					$deliveryLoadArray["DeliveryLoad"] = $deliveryLoad;
					$deliveryLoadObject = new DeliveryLoad();
					$deliveryLoadObject->load($deliveryLoadArray);
					$deliveryLoadObject->delivery_id = $model->id;
					$deliveryLoadObject->save();
					$model->delivery_on = $deliveryLoadObject->delivery_on;
					$model->save();
					//first check that bins have been selected for that load - can have a case where there are none selected
					if(is_array($deliveryLoadBins) && array_key_exists($deliveryCount, $deliveryLoadBins))
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
				$model->delivery_qty = $order->Qty_Tonnes;
				$model->num_batches = $model->getDefaultBatchSize();
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
        	$model->save();			//save so we cna access the object id
	
			//Clear all the existing child objects from the database and recreate based on form Data
			$model->removeAllLoads();
				
	
			$deliveryLoads = Yii::$app->request->post("deliveryLoad");
			$deliveryLoadBins = Yii::$app->request->post("deliveryLoadBins");
			if(is_array($deliveryLoads))
				{
				
				$load_total = 0;	
				foreach($deliveryLoads as $deliveryCount => $deliveryLoad)
					{
					$deliveryLoadArray["DeliveryLoad"] = $deliveryLoad;
					$deliveryLoadObject = new DeliveryLoad();
					$deliveryLoadObject->load($deliveryLoadArray);
					$deliveryLoadObject->delivery_id = $model->id;
					$deliveryLoadObject->save();
					//first check that bins have been selected for that load - can have a case where there are none selected
					if(is_array($deliveryLoadBins) && array_key_exists($deliveryCount, $deliveryLoadBins))
						{
						foreach($deliveryLoadBins[$deliveryCount]['bins'] as $bin_id => $loadValue)
							{
							$load_total += $loadValue;
							$loadBin = new DeliveryLoadBin();
							$loadBin->bin_load = $loadValue;
							$loadBin->trailer_bin_id = $bin_id;
							$loadBin->delivery_load_id = $deliveryLoadObject->id;
							$loadBin->save();
							}			
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
		$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'overrideAction' => '/delivery/update?id='.$model->id.'&exit=false', 'submit' => 'delivery-form', 'confirm' => 'Save Delivery?']; 
		$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=> null, 'submit' => 'delivery-form', 'confirm' => 'Save and Exit Delivery?']; 
		$actionItems[] = ['label'=>'Print Loader', 'button' => 'print', 'print_url'=> 'print-additive-loader-pdf?id='.$model->id."&autoPrint=1"]; 
		$actionItems[] = ['label'=>'Labels', 'button' => 'print', 'print_url'=>'/delivery/print-label?id='.$model->id.'&autoPrint=1' ];
		if($model->hasWeighbridgeTicket())
			{
			$actionItems[] = ['label'=>'Weigh Ticket', 'button' => 'tags', 'url'=> '/weighbridge-ticket/update?id='.$model->weighbridgeTicket->id]; 		
			}
		elseif($model->isFullyAllocated())
			{
			$actionItems[] = ['label'=>'Save & Load', 'button' => 'truck_load', 'url'=> null, 'overrideAction' => '/delivery/update?id='.$model->id.'&load=true', 'submit' => 'delivery-form', 'confirm' => 'Save and Load Truck?']; 	
			}
		if($model->isStatusCompleted())
			{
			$actionItems[] = ['label'=>'Undo Complete', 'button' => 'reverse', 'url'=>  Url::toRoute(['/delivery/uncomplete', 'id' => $model->id]), 'confirm' => 'Change Status to Loaded?']; 					
			}
		if($model->isStatusLoaded())
			{
			$actionItems[] = ['label'=>'Add Return', 'button' => 'return', 'url'=>  Url::toRoute(['/returns/create', 'delivery_id' => $model->id]), 'confirm' => 'Create a Return and change status to Completed?']; 					
			$actionItems[] = ['label'=>'Complete Delivery', 'button' => 'tick', 'url'=>  Url::toRoute(['/delivery/complete', 'id' => $model->id, 'exit' => false]), 'confirm' => 'Change Status to Completed?']; 					
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
  		
  		
		if($model->return)
			{
			$model->return->delete();
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
    
    
    public function actionAjaxDeleteTruck($requested_date, $truck_id, $truck_run_num)
    {
		
		$deliveryLoads = DeliveryLoad::find()
							->where(['delivery_on' => $requested_date, 'truck_id' => $truck_id, 'truck_run_num' => $truck_run_num])
							->all();
							
		foreach($deliveryLoads as $deliveryLoad)
			{
			$deliveryLoad->truck_id = null;
			$deliveryLoad->truck_run_num = null;
			$deliveryLoad->save();
			}
	}
    
    
    public function actionAjaxAddTruck($requested_date, $truck_id, $truck_run_num, $deliveryTrailers)
    {
		
		
	//Ok unpack the information in the $selectedTrailers Variable. it should be an csv array of vairables
	// trailerid_trailerrunnum
	$deliveryTrailersRawArray = explode(",", $deliveryTrailers);
	
	//Selected Truck array will look like array[trailer_run_num][trailer_id] => trailer_id
	$deliveryTrailersArray = array();
	if($deliveryTrailersRawArray[0] != "") //if no trucks have been selected on the page
		{
		if(array_key_exists(0, $deliveryTrailersRawArray))
			{
			$trailerDetails = explode("_", $deliveryTrailersRawArray[0]);
			$trailer1_id = $trailerDetails[0];
			$trailer1_run_num = $trailerDetails[1];
			}
		if(array_key_exists(1, $deliveryTrailersRawArray))
			{
			$trailerDetails = explode("_", $deliveryTrailersRawArray[1]);
			$trailer2_id = $trailerDetails[0];
			$trailer2_run_num = $trailerDetails[1];
			}
		}

	$sqlQuery = "trailer1_id = '".$trailer1_id."' AND trailer1_run_num = '".$trailer1_run_num."'";
	if(isset($trailer2_id))
		{
		$sqlQuery .= " AND trailer2_id = '".$trailer2_id."' AND trailer2_run_num = '".$trailer2_run_num."'";	
		}

		
	$deliveryLoads = DeliveryLoad::find()
							->where(['delivery_on' => $requested_date, 'trailer1_id' => $deliveryTrailersArray])
							->where($sqlQuery)
							->all();	
		
	foreach($deliveryLoads as $deliveryLoad)
		{
		$deliveryLoad->truck_id = $truck_id;
		$deliveryLoad->truck_run_num = $truck_run_num;
		$deliveryLoad->save();
		}	
	}







	public function actionAjaxAddTruck2($requested_date, $truck_id, $truck_run_num, $trailer1_id, $trailer1_run_num)
	{
		
		$deliveryLoads = DeliveryLoad::find()
						->where(['delivery_on' => $requested_date, 'trailer1_id' => $trailer1_id, 'trailer1_run_num' => $trailer1_run_num])
						->all();
						
		foreach($deliveryLoads as $deliveryLoad)
			{
			$deliveryLoad->truck_id = $truck_id;
			$deliveryLoad->truck_run_num = $truck_run_num;
			$deliveryLoad->save();
			}
		
	}


    
    public function actionAjaxSelectTruck($requested_date, $deliveryCount, $selectedTrucks, $deliveryTrailers, $delivery_id)
    {
		
		
		//List of all the currently active trucks in the system
		$truckList = Trucks::getActive();
	
			
			
		//truckUsed array is the follows $trucksUsed[delivery_run_num][truck_id] => 
		/*$trucksUsed[delivery_run_num][truck_id] => 
				[truck_id => X, 
				trailer1_id => X, 
				trailer1_run_num => X,
				trailer2_id => Y, 
				trailer2_run_num => Y,
				binsRemaining => 4, 
				tonsRemaining => 5]
		*/
		$trucksUsed = Trucks::getTrucksUsed($requested_date, $delivery_id);
		
		
	
		
		//Ok unpack the information in the $selectedTrucks Variable. it should be an csv array of vairables
		// truckid_truckrunnum
		$selectedTruckRawArray = explode(",", $selectedTrucks);
		
		//Selected Truck array will look like array[truck_run_num][truck_id] => truck_id
		$selectedTrucksArray = array();
		if($selectedTruckRawArray[0] != "") //if no trucks have been selected on the page
			{
			foreach($selectedTruckRawArray as $truckDetails)
				{
				$details = explode("_", $truckDetails);
				$selectedTrucksArray[$details[1]][$details[0]] = $details[0];
				}	
			}
		
		
		//Ok unpack the information in the $selectedTrailers Variable. it should be an csv array of vairables
		// trailerid_trailerrunnum
		$deliveryTrailersRawArray = explode(",", $deliveryTrailers);
		
		//Selected Truck array will look like array[trailer_run_num][trailer_id] => trailer_id
		$deliveryTrailersArray = array();
		if($deliveryTrailersRawArray[0] != "") //if no trucks have been selected on the page
			{
			foreach($deliveryTrailersRawArray as $trailerDetails)
				{
				$details = explode("_", $trailerDetails);
				$deliveryTrailersArray[$details[1]][$details[0]] = $details[0];
				}	
			}
		
		
		
		//Create the initial data array of all active trucks, if the truck has been used already on form or the truck has been used in another delivery then mark it as used.
		//The $data array needs to $data[run_num][truck_id], 
		$data = array();
		$delivery_run_num = 1;
		foreach($truckList as $truckObject)
			{
			
			//Default Values of truck selection, used if the truck HASNT been used in another order or currently seleted on the delivery form
			$used = false; //if true adds the "add run button"
			$allowSelect = true;
			$binsRemaining = 0;
			$tonsRemaining = 0;
			$trailer1_run_num = 1;
			$trailer2_run_num = 1;
			$truckText = substr($truckObject->registration." (".$truckObject->description.")", 0, 40);
			
			//If there already trailers assigned dont change them, if not then assign the default trailer for the truck
			if(count($deliveryTrailersArray))
				{
				$trailer1_id = 0;
				$trailer2_id = 0;
				}
			else{
				$trailer1_id = $truckObject->getDefault1stTrailer($requested_date, $delivery_run_num, $delivery_id);	
				$trailer2_id = $truckObject->getDefault2ndTrailer($requested_date, $delivery_run_num, $delivery_id);
				}
				
				
				
				
			
			
			//for trucks already selected on the form
			if(array_key_exists($delivery_run_num, $selectedTrucksArray) && array_key_exists($truckObject->id, $selectedTrucksArray[$delivery_run_num]))
				{
				$used = true;
				$allowSelect = false;
				}
			
			//check to see if another order is using the Truck
			elseif(array_key_exists($delivery_run_num, $trucksUsed) && array_key_exists($truckObject->id, $trucksUsed[$delivery_run_num]))	
				{
				$used = true;
				$binsRemaining = $trucksUsed[$delivery_run_num][$truckObject->id]['binsRemaining'];
				$tonsRemaining = $trucksUsed[$delivery_run_num][$truckObject->id]['tonsRemaining'];
				$trailer1_id = $trucksUsed[$delivery_run_num][$truckObject->id]['trailer1_id'];
				$trailer1_run_num = $trucksUsed[$delivery_run_num][$truckObject->id]['trailer1_run_num'];
				$trailer2_id = $trucksUsed[$delivery_run_num][$truckObject->id]['trailer2_id'];
				$trailer2_run_num = $trucksUsed[$delivery_run_num][$truckObject->id]['trailer2_run_num'];
				$truckText = substr($truckObject->registration." (".$truckObject->description.")", 0, 40);
				//If there is room left on the truck and trailer combo then allow it to be selected
				if($binsRemaining > 0)
					{
					$allowSelect = true;
					$truckText .= "<br>&nbsp&nbspRemaining (".$binsRemaining." Bins, ".$tonsRemaining." Tons)";
					}
					
				//dont allow the truck to be selected if the truck is used on another order with already assigned Trailers and this delivery load
				//already has trailers chosen
				
				if(count($deliveryTrailersArray))
					{
					$allowSelect = false;
					$truckText = substr($truckObject->registration." (".$truckObject->description.")", 0, 40)."<BR>&nbsp&nbspTrailers Already assigned to Truck";
					}
				}
			
				
			$data[$delivery_run_num][] = [
				'id' => $truckObject->id, 
				'delivery_run_num' => $delivery_run_num,
				'truck' => $truckText,
				'trailer1_id' => $trailer1_id,
				'trailer1_run_num' => $trailer1_run_num,
				'trailer2_id' => $trailer2_id,
				'trailer2_run_num' => $trailer2_run_num,
				'used' => $used,
				'allowSelect' => $allowSelect,
				'binsRemaining' => $binsRemaining,
				'tonsRemaining' => $tonsRemaining,
				];
			}
		

		
		//Add an entry in the selection for trucks that have been selected already on this order	
		foreach($selectedTrucksArray as $truck_run_num => $truck_id_array)
			{
			if($truck_run_num > 1)
				{
				foreach($truck_id_array as $truck_id)
					{
					$data[$truck_run_num][] = 
						[
						'id' => $indexedTruckList[$truck_id]->id, 
						'delivery_run_num' => $truck_run_num,
						'truck' => substr($indexedTruckList[$truck_id]->registration." (".$indexedTruckList[$truck_id]->description.")", 0, 40),
						'trailer1_id' => 0,
						'trailer1_run_num' => 0,
						'trailer2_id' => 0,
						'trailer2_run_num' => 0,
						'used' => true,
						'allowSelect' => false,
						'binsRemaining' => 0,
						'tonsRemaining' => 0,
						];
					}	
				}
			}

		//Add entries in the data for trucks after the first delivery run
		foreach($trucksUsed as $truck_run_num => $trucksArray)
			{
				if($truck_run_num > 1)
					{
						foreach($trucksArray as $truck_id)
						{
							
						$used = true;
						$binsRemaining = $trucksUsed[$truck_run_num][$truck_id]['binsRemaining'];
						$tonsRemaining = $trucksUsed[$truck_run_num][$truck_id]['tonsRemaining'];
						$trailer1_id = $trucksUsed[$truck_run_num][$truck_id]['trailer1_id'];
						$trailer1_run_num = $trucksUsed[$truck_run_num][$truck_id]['trailer1_run_num'];
						$trailer2_id = $trucksUsed[$truck_run_num][$truck_id]['trailer2_id'];
						$trailer2_run_num = $trucksUsed[$truck_run_num][$truck_id]['trailer2_run_num'];
						if($binsRemaining > 0)
							{
							$allowSelect = true;
							}
						else{
							$allowSelect = false;
							}	
							
							
							
							
						$data[$truck_run_num][] = 
							[
							'id' => $indexedTruckList[$truck_id]->id, 
							'id' => $truckObject->id, 
							'delivery_run_num' => $truck_run_num,
							'truck' => substr($truckObject->registration." (".$truckObject->description.")", 0, 40),
							'trailer1_id' => $trailer1_id,
							'trailer1_run_num' => $trailer1_run_num,
							'trailer2_id' => $trailer2_id,
							'trailer2_run_num' => $trailer2_run_num,
							'used' => $used,
							'allowSelect' => $allowSelect,
							'binsRemaining' => $binsRemaining,
							'tonsRemaining' => $tonsRemaining,
							];
						}	
					}
			}
		
		
		
		return $this->renderPartial("/Trucks/_selectTruck", [
			'data' => $data,
			'deliveryCount' => $deliveryCount,
			'selectionDate' => $requested_date,
			
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
    
    
    public function actionAjaxGetDeliveryLoadTrailer($trailerSlot, $deliveryCount, $trailer_id, $trailer_run_num, $requested_date, $delivery_id)
    {
		
		
		
		$trailer = Trailers::findOne($trailer_id);
		$usedBins = Trailers::getUsedBins($trailer_id, $trailer_run_num, $requested_date, $delivery_id);
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
    public function actionAjaxSelectTrailers($requested_date, $deliveryCount, $trailerSlot, $selectedTrailers, $delivery_load_id)
    	{
    		
    		
    	//A list of all the currently active trailers
		$trailerList = Trailers::getAllActiveTrailers();
		
		//this wil return an array 
		// output array [Delivery_run_num][trailer_id] => ['binsUsed' => X, 'tonsUsed' => Y, 'truck_id' => XX, 'truck_run_num' => 1, 'other_trailer_slot' => YY, 'other_trailer_run_num' => Y]
		$trailersUsed = Trailers::getTrailersUsed($requested_date, $delivery_load_id);

		//a list of the trailers already on the page, a trailer cannot be selected twice
		$selectedTrailerList = explode(",", $selectedTrailers); // should be an array of trailer_id + "_" + trailer_run_num
		$selectedTrailerArray = array();
		if($selectedTrailerList[0] != "")
			{
			foreach($selectedTrailerList as $selectedTrailer)
				{
				$trailerArray = explode("_", $selectedTrailer);
				$selectedTrailerArray[$trailerArray[1]][$trailerArray[0]] = $trailerArray[0];
				}	
			}
		
		
		
		//Ok if there are no trailers currently being used then just spit out the trail list with no modification
		//The $data array needs to have an index like trailerid_runnum, 
		$data = array();
		$trailer_run_num = 1;
		foreach($trailerList as $trailerObject)
			{
			$data[$trailer_run_num][$trailerObject->id] = [
				'id' => $trailerObject->id, 
				'delivery_run_num' => 1,
				'trailer' => substr($trailerObject->Registration." (".$trailerObject->Description.")", 0, 30),
				'bins' => $trailerObject->NumBins,
				'tons' => $trailerObject->Max_Capacity,
				'used' => false,
				'allowSelect' => true,
				'maxBins' => $trailerObject->NumBins,
				'maxTons' => $trailerObject->Max_Capacity,
				];
			
			//if the trailer is in the list of trailers used by another order then we need to put that information in here
			if(array_key_exists($trailer_run_num, $trailersUsed) && array_key_exists($trailerObject->id, $trailersUsed[$trailer_run_num]))
				{
				$binsLeft = $trailerObject->NumBins - $trailersUsed[$trailer_run_num][$trailerObject->id]['binsUsed'];
				$data[$trailer_run_num][$trailerObject->id]['bins'] = $binsLeft." (of ".$trailerObject->NumBins.")";
				$data[$trailer_run_num][$trailerObject->id]['tons'] = ($trailerObject->Max_Capacity - $trailersUsed[$trailer_run_num][$trailerObject->id]['tonsUsed'])." (of ".$trailerObject->Max_Capacity.")";
				$data[$trailer_run_num][$trailerObject->id]['used'] = true;
				if($binsLeft == 0)
					{
					$data[$trailer_run_num][$trailerObject->id]['allowSelect'] = false;	
					}
				}
				
			//If the trailer has already been selected in this delivery 
			if(array_key_exists($trailer_run_num, $selectedTrailerArray) && array_key_exists($trailerObject->id, $selectedTrailerArray[$trailer_run_num]))
				{
				$data[$trailer_run_num][$trailerObject->id]['allowSelect'] = false;	
				$data[$trailer_run_num][$trailerObject->id]['used'] = true;	
				}

			}	
		
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
	
    
    
    
    public function actionAjaxCheckLoads($truck_id, $trailer1_id, $trailer2_id, $load_total)
    {
		
		$errors = array();
		$errors = Trucks::checkTruckLoad($truck_id,$trailer1_id, $trailer2_id, $load_total );
		
		$returnString = "<ul>";
		foreach($errors as $error)
			{
			$returnString .= "<li><b>Warning: </b>".$error."</li>";
			}
		$returnString .= "</ul>";
		
		return $returnString;
	}
    
    public function actionComplete($id, $exit = true)
    {
		$model = $this->findModel($id);
		$model->setStatusCompleted();
		
		//When the delivery is set to complete also set the herd information details in the customer information
		Clients::updateFeedRates($model);
		
		
		//also set the status of the order to completed
		$model->customerOrder->Status = CustomerOrders::STATUS_COMPLETED;
		$model->customerOrder->save();
		
		
		if($exit)
			{
			return $this->redirect('index');	
			}
		return $this->redirect(Url::to(['update', 'id' => $id]));
        
	}
	
	
	  public function actionUncomplete($id)
    {
		$model = $this->findModel($id);
		$model->setStatusLoaded();
		
		$lastDelivery = $model->customerOrder->client->getLastDelivery();
		$model->customerOrder->client->updateFeedRates($lastDelivery);
		
		$model->customerOrder->Status = CustomerOrders::STATUS_DISPATCHED;
		$model->customerOrder->save();
		
		if($model->return)
			{
			$model->return->delete();
			}
		
        return $this->redirect(Url::to(['update', 'id' => $id]));
	}
	
	
	
public function actionPrintLabel($id)
	{
		
	$delivery = Delivery::findOne($id);
	
	$content = $this->renderPartial("_label", [
			'delivery' => $delivery,

			
			]);
		
		
	$pdf = new Pdf([
		'content' => $content,  
		//'destination' => Pdf::DEST_FILE, 
		//'filename' => 'c:\temp\test.pdf',
		'format' => [50,100], 
 		'destination' => Pdf::DEST_BROWSER, 
		'options' => ['title' => 'Customer Order'],
		'marginLeft' => '2',
		'marginRight' => '2',
		'marginTop' => '2',
		'marginBottom' => '2',
		'orientation' => 'L',
		
	
    	]);

	
	
 	return $pdf->render(); 

	}

}

    
    
    

