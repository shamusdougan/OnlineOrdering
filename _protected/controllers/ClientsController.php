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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
        	
        	$clientList = Clients::find()->all();
        	$clientDropDownList = ArrayHelper::map($clientList, 'id', 'Company_Name') ;
        	
        	$userList = User::find()->all();
        	$userDropDownList = ArrayHelper::map($userList, 'id', 'fullname') ;
        	
        	
            return $this->render('create', [
                'model' => $model, 'clientList' => $clientDropDownList, 'userList' => $userDropDownList
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
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
        	
        	$clientList = Clients::find()->select(['id', 'Company_Name'])->all();
        	$clientDropDownList = ArrayHelper::map($clientList, 'id', 'Company_Name') ;
        	
        	$userList = User::find()->all();
        	$userDropDownList = ArrayHelper::map($userList, 'id', 'fullname') ;
        	
            return $this->render('update', [
                'model' => $model, 'clientList' => $clientDropDownList, 'userList' => $userDropDownList
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
