<?php

namespace app\controllers;

use Yii;
use app\models\trailers;
use app\models\trailersSearch;
use app\models\TrailerBins;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TrailersController implements the CRUD actions for trailers model.
 */
class TrailersController extends Controller
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

	    $this->view->params['menuItem'] = 'trailers';

	    return true; // or false to not run the action
	}



    /**
     * Lists all trailers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new trailersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

 		$actionItems[] = ['label'=>'New', 'button' => 'new', 'url'=> '/trailers/create'];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'actionItems' => $actionItems,
        ]);
    }

    /**
     * Displays a single trailers model.
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
     * Creates a new trailers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new trailers();


		$actionItems[] = ['label'=>'Cancel', 'button' => 'back', 'url'=>'/trailers/index', 'confirm' => 'Cancel Changes?'];
		$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'overrideAction' => '/trailers/update?id='.$model->id.'&exit=false', 'submit' => 'trailer-form', 'confirm' => 'Save Trailer?']; 
		$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=>null, 'submit'=> 'trailer-form', 'confirm' => 'Save and Exit Trailers?'];


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
            return $this->render('create', [
                'model' => $model,
                'actionItems' => $actionItems,
            ]);
        }
    }

    /**
     * Updates an existing trailers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		$actionItems[] = ['label'=>'Cancel', 'button' => 'back', 'url'=>'/trailers/index', 'confirm' => 'Cancel Changes?'];
		$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'overrideAction' => '/trailers/update?id='.$model->id.'&exit=false', 'submit' => 'trailer-form', 'confirm' => 'Save Trailer?']; 
		$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=>null, 'submit'=> 'trailer-form', 'confirm' => 'Save and Exit Trailers?'];
		
		
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
        
        
        
            return $this->render('update', [
                'model' => $model,
                'actionItems' => $actionItems,
            ]);
        }
    }

    /**
     * Deletes an existing trailers model.
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
     * Finds the trailers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return trailers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = trailers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    
    public function actionAjaxAddBin($trailer_id)
    {
    	
	$trailer_bin = new TrailerBins();
	var_dump($_POST);
	if (array_key_exists("Add_Trailers", $_POST)) 
		{
	    $bins = explode(',', $_POST['Add_Trailers']['Bin Squence']);
	    
	    $trailer = Trailers::findOne($trailer_id);
	    $startingBinNumber = count($trailer->trailerBins)+1;
	    
	    foreach($bins as $bin)
	    	{
			$newTrailerBin = new TrailerBins();
			$newTrailerBin->trailer_id = $trailer_id;
			$newTrailerBin->Status = TrailerBins::STATUS_ACTIVE;
			$newTrailerBin->MaxCapacity = $bin;
			$newTrailerBin->BinNo = (string)$startingBinNumber;
			$startingBinNumber++;
			if(!$newTrailerBin->save())
				{
				var_dump($newTrailerBin->getErrors());
				}
			}
	    
	    return;
	    
		} 
	else {
		$trailer_bin->trailer_id = $trailer_id;
		$trailer_bin->Status = TrailerBins::STATUS_ACTIVE;
		return $this->renderAjax("_trailerBin", ['model' => $trailer_bin]);
		}
	}
	
	
	 public function actionAjaxDeleteBin($id)
    {
	$trailer_bin = TrailerBins::findOne($id)->delete();
	}


    public function actionAjaxUpdateBin($id)
    {
    	
	$trailer_bin = TrailerBins::findOne($id);

	if ($trailer_bin->load(Yii::$app->request->post()) && $trailer_bin->save()) 
		{
	    return ;
		} 
	else {

		return $this->renderAjax("_trailerBin", ['model' => $trailer_bin]);
		}
	}


	
}
