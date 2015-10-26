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

use mPDF;

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

		


        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        	{
            return $this->redirect(['view', 'id' => $model->id]);
        	} 
        else {
        	
        	$delivery = null;
        	$deliveryList = array();
        	if($delivery_id != null)
        		{
				$delivery = Delivery::findOne($delivery_id);
				}
			else{
				$deliveries = Delivery::getUnloadedDeliveries();
				$deliveryList =  ArrayHelper::map($deliveries, 'id', 'Name') ;
			}
        	
            return $this->render('create', [
                'model' => $model,
                'delivery' => $delivery,
                'deliveryList' => $deliveryList,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }



	public function actionPdf()
	{
		$mpdf = new mPDF;
		
		$html = "<table border='1'><tr><td width='150px' height='150px'>hello world</td></Tr></table>";
		
		
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        exit;

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
