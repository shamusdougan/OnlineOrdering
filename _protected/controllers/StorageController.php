<?php

namespace app\controllers;

use Yii;
use app\models\Storage;
use app\models\StorageSearch;
use app\models\Clients;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StorageController implements the CRUD actions for Storage model.
 */
class StorageController extends Controller
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

	    $this->view->params['menuItem'] = 'storage';

	    return true; // or false to not run the action
	}



    /**
     * Lists all Storage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StorageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		
		$clientList = clients::find()->select(['id', 'Company_Name'])->orderBy('Company_Name')->asArray()->all();



        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'clientList' => $clientList,
        ]);
    }

    /**
     * Displays a single Storage model.
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
     * Creates a new Storage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Storage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Storage model.
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
     * Deletes an existing Storage model.
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
     * Finds the Storage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Storage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Storage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    
    
    
    
 
 	public function actionAjaxCreate($client_id)
 	{
 	
 	$model = new Storage();
 	
 	
 	$client = Clients::findOne($client_id);
	if($client == null)
		{
		die("Unable to find specified client from client id: ".$client_id);
		}
		
	$post = Yii::$app->request->post(); 
	if ($model->load($post) && $model->save()) 
		{
		return "saved Storage";
		}

	else{
	
		$model->company_id = $client->id;
		$model->Status = Storage::STATUS_ACTIVE;
		$model->Street_1 = $client->Address_1_Street_1;
		$model->SuburbTown = $client->Address_1_TownSuburb;
		$model->Postcode = $client->Address_1_Postal_Code;
		
			
		return $this->renderAjax('_ajaxForm', ['model' => $model]);	
		}
	}
	
	
	public function actionAjaxUpdate($id)
    {
		$model = $this->findModel($id);	
		if($model == null)
			{
			die("Uanble to find the Contact from contract id: ".$id);
			}
		
		$post = Yii::$app->request->post(); 
		if ($model->load($post) && $model->save()) 
			{
        	Yii::$app->session->setFlash('kv-detail-success', 'Details Saved');
			}
		else{
			return $this->renderAjax('_ajaxForm', ['model' => $model]);
			}
		
		
	}
    
    
    public function actionAjaxDelete($id)
    {
		$model = $this->findModel($id);	
		if($model == null)
			{
			die("Unable to find the Contact from contract id: ".$id);
			}
		$model->delete();
		
		
		
	}
    
    
    
}
