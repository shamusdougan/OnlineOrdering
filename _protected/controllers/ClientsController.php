<?php

namespace app\controllers;

use Yii;
use app\models\clients;
use app\models\clientsSearch;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;


/**
 * ClientsController implements the CRUD actions for clients model.
 */
class ClientsController extends Controller
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

    /**
     * Lists all clients models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new clientsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$actionItems[] = ['label'=>'New', 'button' => 'new', 'url'=>'/clients/create', ];
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
        	

	        $user = Yii::$app->user->canEditCustomer(); 
	        print_r($user);
	        //$user->canEditCustomer();
        
        	$actionItems[] = ['label'=>'back', 'button' => 'back', 'url'=> 'index', 'confirm' => 'Exit with out saving?']; 
			$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'overrideAction' => '/clients/create?&exit=false', 'submit' => 'client_edit_form', 'confirm' => 'Save Customer Information?']; 
			$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=> null, 'submit' => 'client_edit_form', 'confirm' => 'Save Customer Information and Exit?']; 
			
			$clientDropDownList = ArrayHelper::map(Clients::find()->select(['id', 'Company_Name'])->all(), 'id', 'Company_Name') ;
			
			//Set the client Defaults
			$model->Status = Clients::STATUS_ACTIVE;
			$model->Owner_id = Yii::$app->user->identity->id;
			$model->Is_Customer = 1;
			$model->Is_Factory = 0;
			$model->Is_Supplier = 0;
			$model->Owner_id = Yii::$app->user->identity->id;
        	
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
            
          
            $actionItems[] = ['label'=>'back', 'button' => 'back', 'url'=> 'index', 'confirm' => 'Exit with out saving?']; 
			$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'overrideAction' => '/clients/create?&exit=false', 'submit' => 'client_edit_form', 'confirm' => 'Save Customer Information?']; 
			$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=> null, 'submit' => 'client_edit_form', 'confirm' => 'Save Customer Information and Exit?']; 
	
          
          
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
			
            return $this->render('update', [
                'model' => $model, 
                'clientList' => $clientDropDownList, 
                'userList' => $userDropDownList,
                'actionItems' => $actionItems,
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
