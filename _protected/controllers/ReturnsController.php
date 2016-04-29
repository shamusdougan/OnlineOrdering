<?php

namespace app\controllers;

use Yii;
use app\models\Returns;
use app\models\ReturnsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Delivery;

/**
 * ReturnsController implements the CRUD actions for Returns model.
 */
class ReturnsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Returns models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReturnsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
  		$actionItems = array(); //[] = ['label'=>'New', 'button' => 'new', 'url'=> 'create'];
  		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'actionItems' => $actionItems,
        ]);
    }

    /**
     * Displays a single Returns model.
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
     * Creates a new Returns model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($delivery_id)
    {
        
        $delivery = Delivery::findOne($delivery_id);
        $model = new Returns();
        $model->delivery_id = $delivery_id;
        
        //If there is no valid adelivery for this return go back to the delivery index page
        if(!$delivery)
        	{
        	Yii::$app->session->setFlash('error', "Invalid Delivery ID");
			return $this->redirect('/delivery');
			}

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
			$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'overrideAction' => '/returns/create?delivery_id='.$delivery_id.'&exit=false', 'submit' => 'return-form', 'confirm' => 'Save Delivery?']; 
			$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=> null, 'submit' => 'return-form', 'confirm' => 'Save and Exit Delivery?']; 
	
        	
            return $this->render('create', [
                'model' => $model,
                'delivery' => $delivery,
                'actionItems' => $actionItems,
            ]);
        }
    }

    /**
     * Updates an existing Returns model.
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
			$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'overrideAction' => '/delivery/create?exit=false', 'submit' => 'return-form', 'confirm' => 'Save Delivery?']; 
			$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=> null, 'submit' => 'return-form', 'confirm' => 'Save and Exit Delivery?']; 
	
        	
            return $this->render('update', [
                'model' => $model,
                'actionItems' => $actionItems,
                'delivery' => $model->delivery,
            ]);
        }
    }

    /**
     * Deletes an existing Returns model.
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
     * Finds the Returns model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Returns the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Returns::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
