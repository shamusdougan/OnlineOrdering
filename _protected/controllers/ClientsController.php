<?php

namespace app\controllers;

use Yii;
use app\models\clients;
use app\models\clientsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use webvimark\modules\UserManagement\models\User;
use app\models\ImportFunctions;
use yii\data\ArrayDataProvider;


/**
 * ClientsController implements the CRUD actions for clients model.
 */
class ClientsController extends Controller
{
	
	
	
	const SALES_STATUS_CURRENT = 1;
	const SALES_STATUS_INTER = 2;
	const SALES_STATUS_LOST = 3;
	
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 0;
	
	
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

    /**
     * Lists all clients models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new clientsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $actionItems = array();
        if(User::hasPermission('createCustomer')){
			$actionItems[] = ['label'=>'New', 'button' => 'new', 'url'=>'/clients/create', ];	
			}
		
		$userList = user::getUserListArray(); 

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'actionItems' => $actionItems,
            'userList' => $userList,
        ]);
    }

    /**
     * Displays a single clients model.
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
     * Creates a new clients model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new clients();

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
			$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'overrideAction' => '/clients/create?&exit=false', 'submit' => 'client_edit_form', 'confirm' => 'Save Customer Information?']; 
			$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=> null, 'submit' => 'client_edit_form', 'confirm' => 'Save Customer Information and Exit?']; 
			
			$clientDropDownList = ArrayHelper::map(Clients::find()->select(['id', 'Company_Name'])->all(), 'id', 'Company_Name') ;
			
			//Set the client Defaults
			$model->Sales_Status = Clients::SALES_STATUS_CURRENT;
			$model->Is_Customer = 1;
			$model->Is_Factory = 0;
			$model->Is_Supplier = 0;
			$model->Owner_id = User::getCurrentUser()->id;
        	
            return $this->render('create', [
                'model' => $model, 
                'clientList' => $clientDropDownList,
                'actionItems' => $actionItems,
            ]);
        }
    }

    /**
     * Updates an existing clients model.
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
            
            //return $this->redirect(['index']);
        } else {
        	
        	$clientList = Clients::find()->select(['id', 'Company_Name'])->all();
        	$clientDropDownList = ArrayHelper::map($clientList, 'id', 'Company_Name') ;
        	
        	$userList = User::find()->all();
        	$userDropDownList = ArrayHelper::map($userList, 'id', 'fullname');
        	
        	$actionItems[] = ['label'=>'back', 'button' => 'back', 'url'=> 'index', 'confirm' => 'Exit with out saving?']; 
			$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'overrideAction' => '/clients/update?id='.$model->id.'&exit=false', 'submit' => 'client_edit_form', 'confirm' => 'Save Customer Information?']; 
			$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=> null, 'submit' => 'client_edit_form', 'confirm' => 'Save Customer Information and Exit?']; 
			if(User::hasPermission('importFromBC')){
				$actionItems[] = ['label'=>'Import BC', 'button' => 'save', 'url'=>'/clients/import-blue-cow?id='.$model->id, 'confirm' => 'Import orders from Blue Cow for this client?']; 
				}
				
				
			$user = User::getCurrentUser();
			
			
			
		
				
				
			$readOnly = !(User::hasPermission("editCustomer") || (User::hasPermission("editOwnCustomer") && ($model->Owner_id == $user->id)));
			$changeCreditHold = User::hasPermission("setCreditHold");
			
			
            return $this->render('update', [
                'model' => $model, 
                'clientList' => $clientDropDownList, 
                'userList' => $userDropDownList,
                'actionItems' => $actionItems,
                'readOnly' => $readOnly,
                'changeCreditHold' => $changeCreditHold,
            ]);
        }
    }

    /**
     * Deletes an existing clients model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    
    public function actionImportBlueCow($id)
    {
		$model = $this->findModel($id);
		$importModel = new ImportFunctions();
		$importModel->name = "Import Orders from Blue Cow Ordering System";
		$importModel->importCustomerOrdersBC($model);
		
		$actionItems[] = ['label'=>'back', 'button' => 'back', 'url'=> '/clients/update?id='.$id, 'confirm' => 'Exit?']; 
		return $this->render('_importBCOrders', [
						'model' => $model,
						'importModel' => $importModel,
						'actionItems' => $actionItems,
						]);

	}
	
	
	
	public function actionAnticipatedSales()
	{
		$user = User::getCurrentUser();
		
		$salesArray = clients::getAnticipatedSales($user->id);
		$dataProvider = new ArrayDataProvider([
			'allModels' => $salesArray,
			'sort' => [
				'attributes' => 
					[
					'Company_Name', 
					'Account_Number', 
					'Feed_QOH_Tonnes',
					'Herd_Size',
					'Feed_Rate_Kg_Day',
					'Feed_Days_Remaining',
					],
				],
			'pagination' => 
			 	[
		        'pageSize' => 20,
		    	],
			]);
			
			
		//print_r($dataProvider);
		//$dataProvider->setSort(['defaultOrder' => ['Feed_Days_Remaining' => SORT_DESC]]);
		
		return $this->render('anticipatedSales',
			[
			'user' => $user,
			'dataProvider' => $dataProvider,
			]
			
			
		);
	}
	
	
	

    /**
     * Finds the clients model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return clients the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = clients::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
   
}
