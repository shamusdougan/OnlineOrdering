<?php

namespace app\controllers;

use Yii;
use app\models\trucks;
use app\models\trailers;
use app\models\trucksSearch;
use app\models\trucksDefaultTrailers;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * TrucksController implements the CRUD actions for trucks model.
 */
class TrucksController extends Controller
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

	    $this->view->params['menuItem'] = 'trucks';

	    return true; // or false to not run the action
	}


    /**
     * Lists all trucks models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new trucksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
          $dataProvider->setSort(['defaultOrder' => ['registration'=>SORT_ASC]]);
        
        $actionItems[] = ['label'=>'New', 'button' => 'new', 'url'=> '/trucks/create'];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'actionItems' => $actionItems,
        ]);
    }

    /**
     * Displays a single trucks model.
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
     * Creates a new trucks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new trucks();

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        	{
           
           
           	
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
        else {
        	
        	$actionItems[] = ['label'=>'back', 'button' => 'back', 'url'=> 'index', 'confirm' => 'Exit with out saving?']; 
			$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'overrideAction' => '/trucks/create?exit=false', 'submit' => 'truck-form', 'confirm' => 'Save Truck?']; 
			$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=> null, 'submit' => 'truck-form', 'confirm' => 'Save and Exit Truck?']; 
			
			
			$trailerObjects = Trailers::getAllActiveTrailers();
        	$trailerList = ArrayHelper::map($trailerObjects, 'id', 'Registration') ;

			
			
        	$model->Status = TRUCKS::STATUS_ACTIVE;
            return $this->render('create', [
                'model' => $model,
                'actionItems' => $actionItems,
                'trailerList' => $trailerList,
            ]);
        }
    }

    /**
     * Updates an existing trucks model.
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
			$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'overrideAction' => '/trucks/update?id='.$model->id.'&exit=false', 'submit' => 'truck-form', 'confirm' => 'Save Truck?']; 
			$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=> null, 'submit' => 'truck-form', 'confirm' => 'Save and Exit Truck?']; 
			
        	$trailerObjects = Trailers::getAllActiveTrailers();
        	$trailerList = ArrayHelper::map($trailerObjects, 'id', 'Registration') ;

        	
            return $this->render('update', [
                'model' => $model,
                'actionItems' => $actionItems,
                'trailerList' => $trailerList,
            ]);
        }
    }

    /**
     * Deletes an existing trucks model.
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
     * Finds the trucks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return trucks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = trucks::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
