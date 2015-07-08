<?php

namespace app\controllers;

use Yii;
use app\models\contacts;
use app\models\contactsSearch;
use app\models\Clients;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ContactsController implements the CRUD actions for contacts model.
 */
class ContactsController extends Controller
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
     * Lists all contacts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new contactsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single contacts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	
    	$clientList = ArrayHelper::map(Clients::find()->all(), 'id', 'Company_Name') ;
        	 
        	 
       if(Yii::$app->request->isAjax ){
       		return $this->renderAjax('view', ['model' => $this->findModel($id), 'clientList' => $clientList]);
       		}
        return $this->render('view', ['model' => $this->findModel($id), 'clientList' => $clientList]);
    }

    /**
     * Creates a new contacts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new contacts();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
        	
        	$clientList = ArrayHelper::map(Clients::find()->all(), 'id', 'Company_Name') ;
        	
            return $this->render('details', [
                'model' => $model, 'clientList' => $clientList, 'mode' => 'edit'
            ]);
        }
    }

    /**
     * Updates an existing contacts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
     
        $model = $this->findModel($id);	
		$post = Yii::$app->request->post(); 
		if ($model->load($post) && $model->save()) 
			{
        	Yii::$app->session->setFlash('kv-detail-success', 'Details Saved');
			}
			
		$clientList = ArrayHelper::map(Clients::find()->select(['id', 'Company_Name'])->all(), 'id', 'Company_Name') ;
		if(Yii::$app->request->isAjax ){
			return $this->renderAjax('_form', ['model' => $model, 'clientList' => $clientList]);	
			}
        return $this->render('_form', ['model' => $model, 'clientList' => $clientList, 'mode' => 'edit']);
    }



	public function actionModal($id)
	{
		 $model = $this->findModel($id);	
		$post = Yii::$app->request->post(); 
		if ($model->load($post) && $model->save()) 
			{
        	 return true;
			}
			
		$clientList = ArrayHelper::map(Clients::find()->select(['id', 'Company_Name'])->all(), 'id', 'Company_Name') ;
		if(Yii::$app->request->isAjax ){
			return $this->renderAjax('details', ['model' => $model, 'clientList' => $clientList]);	
			}
        return $this->render('details', ['model' => $model, 'clientList' => $clientList, 'mode' => 'edit']);
	}

    /**
     * Deletes an existing contacts model.
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
     * Finds the contacts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return contacts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = contacts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
 
    
    
    
    public function actionDetail($id = null, $mode = 'view') 
	{
		
		
	if(isset($id)){
		$model = $this->findModel($id);	
		}
	else{
		$model = new contacts();
	}
    
   
     $post = Yii::$app->request->post();  
    // process ajax delete
    if (Yii::$app->request->isAjax && isset($post['delete'])) {
        echo Json::encode([
            'success' => true,
            'messages' => [
                'kv-detail-info' => 'Contact Deleted. '
            ]
        ]);
        return;
    }
    
    
    // return messages on update of record
	
    if ($model->load($post) && $model->save()) {
        Yii::$app->session->setFlash('kv-detail-success', 'Details Saved');
    }
    
    
    $clientList = ArrayHelper::map(Clients::find()->all(), 'id', 'Company_Name');
    if(Yii::$app->request->isAjax ){
		return $this->renderAjax('details', ['model'=>$model, 'clientList' => $clientList, 'mode' => $mode]);
		}
    return $this->render('details', ['model'=>$model, 'clientList' => $clientList, 'mode' => $mode]);
	}
    
    
    
}
