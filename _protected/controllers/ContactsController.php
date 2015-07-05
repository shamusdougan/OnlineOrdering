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
        	 
        return $this->render('dialog', [
            'model' => $this->findModel($id), 'clientList' => $clientList, 'readOnly' => true
        ]);
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
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
        	
        	$clientList = ArrayHelper::map(Clients::find()->all(), 'id', 'Company_Name') ;
        	
            return $this->render('dialog', [
                'model' => $model, 'clientList' => $clientList
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
        	
        	$clientList = ArrayHelper::map(Clients::find()->all(), 'id', 'Company_Name') ;
        	
            return $this->render('dialog', [
                'model' => $model, 'clientList' => $clientList
            ]);
        }
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
    
    public function actionAjaxView($id)
    {
    	
    	$clientList = ArrayHelper::map(Clients::find()->all(), 'id', 'Company_Name') ;
		 return $this->renderAjax('dialog', [
            'model' => $this->findModel($id), 'clientList' => $clientList
        ]);
	}
    
    
}
