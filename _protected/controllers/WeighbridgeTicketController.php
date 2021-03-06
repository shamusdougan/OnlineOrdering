<?php

namespace app\controllers;

use Yii;
use app\models\WeighbridgeTicket;
use app\models\WeighbridgeTicketSearch;
use app\models\Delivery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;



/**
 * WeighbridgeTicketController implements the CRUD actions for WeighbridgeTicket model.
 */
class WeighbridgeTicketController extends Controller
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

	    $this->view->params['menuItem'] = 'weighbridge';

	    return true; // or false to not run the action
	}




    /**
     * Lists all WeighbridgeTicket models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WeighbridgeTicketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
 		$dataProvider->setSort(['defaultOrder' => ['ticket_number'=>SORT_DESC]]);
		
		
		$actionItems[] = ['label'=>'New', 'button' => 'new', 'url'=> '/weighbridge-ticket/create'];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'actionItems' => $actionItems,
        ]);
    }

    /**
     * Displays a single WeighbridgeTicket model.
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
     * Creates a new WeighbridgeTicket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($delivery_id = null)
    {
        $model = new WeighbridgeTicket();

		

		/**
		* 
		* @var Saving the Weigh Bridge Object
		* 
		*/
        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        	{
        		
        		
        	//model saved correctly make sure the delivery is updated as well
        	$model->delivery->setStatusLoaded();
        	$model->delivery->customerOrder->setStatusDispatched();	
        		
        		
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
		   * @var Creting the Weigh bRidge object
		   * 
		   */
        else {
        	
        	$delivery = null;
        	$deliveryList = array();
        	if($delivery_id != null)
        		{
				$delivery = Delivery::findOne($delivery_id);
				if($delivery->hasWeighBridgeTicket())
					{
					$model = $delivery->weighbridgeTicket;
					}
				else
					{
					$model->delivery_id = $delivery->id;
					$model->date = $delivery->delivery_on;		
					}
				
				}
			else{
				$deliveries = Delivery::getUnloadedDeliveries();
				$deliveryList =  ArrayHelper::map($deliveries, 'id', 'Name') ;
				}
        	
        	
        	$actionItems[] = ['label'=>'back', 'button' => 'back', 'url'=> 'index', 'confirm' => 'Exit with out saving?']; 
			$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'overrideAction' => '/weighbridge-ticket/create?exit=false', 'submit' => 'weighbridge-form', 'confirm' => 'Save Delivery?']; 
			$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=> null, 'submit' => 'weighbridge-form', 'confirm' => 'Save and Exit Delivery?']; 
			
			
			
        	$model->ticket_number = WeighbridgeTicket::generateTicketNumber();
        	
        	
        	
            return $this->render('create', [
                'model' => $model,
                'delivery' => $delivery,
                'deliveryList' => $deliveryList,
                'actionItems' => $actionItems,
            ]);
        	}
    }

    /**
     * Updates an existing WeighbridgeTicket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

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
            
            
            
        	$actionItems[] = ['label'=>'back', 'button' => 'back', 'url'=> 'index', 'confirm' => 'Exit with out saving?']; 
			$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'overrideAction' => '/weighbridge-ticket/update?id='.$model->id.'&exit=false', 'submit' => 'weighbridge-form', 'confirm' => 'Save Delivery?']; 
			$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=> null, 'submit' => 'weighbridge-form', 'confirm' => 'Save and Exit Ticket?']; 
			$actionItems[] = ['label'=>'Print Ticket', 'button' => 'print', 'url'=> null,]; 
            
            
            
            
            
             return $this->render('create', [
                'model' => $model,
                'delivery' => $model->delivery,
                'actionItems' => $actionItems,
                'deliveryList' => null,
            ]);
        }
    }

    /**
     * Deletes an existing WeighbridgeTicket model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	
    	$weighbridgeTicket = $this->findModel($id);
    	
    	if(isset($weighbridgeTicket->delivery))
    		{
			$weighbridgeTicket->delivery->setStatusInprogress();
			if(isset($weighbridgeTicket->delivery->return))
				{
				$weighbridgeTicket->delivery->return->delete();
				}
			if(isset($weighbridgeTicket->delivery->customerOrder))
				{
				$weighbridgeTicket->delivery->customerOrder->setStatusInProduction();
				}
			}
    	
       	$weighbridgeTicket->delete();
        

        return $this->redirect(['index']);
    }



	public function actionPdf($id)
	{
	 
		
	$weighbridgeTicket = WeighbridgeTicket::findOne($id);
	
	$content = $this->renderPartial("weighbridgeTicket", [
			'weighbridgeTicket' => $weighbridgeTicket,

			
			]);
		
		
	$pdf = new Pdf([
		'content' => $content."<br>".$content,  
		//'destination' => Pdf::DEST_FILE, 
		//'filename' => 'c:\temp\test.pdf',
		'format' => Pdf::FORMAT_A4, 
 		'destination' => Pdf::DEST_BROWSER, 
		'options' => ['title' => 'Weighbridge Ticket'],

		'methods' => 
			[
			
            'SetFooter'=>['{PAGENO}'],

			"SetJS" => "'this.print();'",
			]
    	]);

	
 	return $pdf->render(); 

	}

	
	
	/**
	* 
	* @Function Delivery Details - fetch the delivery details from to display in the weight bridge ticket
	* 
	* @return
	*/
	public function actionAjaxDeliveryDetails($delivery_id)
	{
		if($delivery_id != null){
			$delivery =  Delivery::findOne($delivery_id);
			
			if(!$delivery->deliveryLoad[0]->truck)
				{
				$truck = "NONE";
				$truck_id = null;
				}
			else{
				$truck = $delivery->deliveryLoad[0]->truck->registration;
				$truck_id = $delivery->deliveryLoad[0]->truck->id;
			}
			
	    	return \yii\helpers\Json::encode([
	    		'date' => $delivery->delivery_on,
		        'truck'=> $truck,
		        'truck_id'=> $truck_id,
		       	'address' => $delivery->customerOrder->client->Address_1,
		       	'orderinfo' => $delivery->customerOrder->Order_instructions,
		       	'nearest_town' => $delivery->customerOrder->client->Nearest_Town,
		       	'delivery_directions' => $delivery->customerOrder->client->Delivery_Directions,
		        
		    ]);
		    }
		else{
			return True;
		}
	}

    /**
     * Finds the WeighbridgeTicket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WeighbridgeTicket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WeighbridgeTicket::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
