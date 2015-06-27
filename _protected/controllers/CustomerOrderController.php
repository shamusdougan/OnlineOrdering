<?php

namespace app\controllers;

use Yii;
use app\models\customerOrders;
use app\models\customerOrdersSearch;
use app\models\Clients;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerOrderController implements the CRUD actions for customerOrders model.
 */
class CustomerOrderController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'customerdetails' => ['get', 'post']
                ],
            ],
        ];
    }




	public function beforeAction($action)
	{
	    if (!parent::beforeAction($action)) {
	        return false;
	    }

	    $this->view->params['menuItem'] = 'customer-order';

	    return true; // or false to not run the action
	}




    /**
     * Lists all customerOrders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new customerOrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single customerOrders model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new customerOrders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new customerOrders();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->Order_ID]);
        } else {
        	
        	
        	$clientList = Clients::find()->all();
            return $this->render('create', [
                'model' => $model, 'clientlist' => $clientList
            ]);
        }
    }

    /**
     * Updates an existing customerOrders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->Order_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing customerOrders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the customerOrders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return customerOrders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = customerOrders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    
    public function actionCustomerdetails($id)
    {
		$model=  \app\models\Clients::findOne(['id'=>$id]);
    	return \yii\helpers\Json::encode([
    		'contact' => $model->Owner,
	        'address'=>$model->Address_1,
	        'phone'=>$model->Main_Phone,
	        'status'=>$model->Status,
	        'nearestTown'=>$model->Nearest_Town,
	        'id'=>$model->id
	    ]);

	}
}
