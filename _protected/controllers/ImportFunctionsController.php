<?php

namespace app\controllers;

use Yii;
use app\models\ImportFunctions;
use app\models\ImportFunctionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ImportFunctionsController implements the CRUD actions for ImportFunctions model.
 */
class ImportFunctionsController extends Controller
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

	    $this->view->params['menuItem'] = 'import';

	    return true; // or false to not run the action
	}


    /**
     * Lists all ImportFunctions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImportFunctionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ImportFunctions model.
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
     * Creates a new ImportFunctions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ImportFunctions();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ImportFunctions model.
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
     * Deletes an existing ImportFunctions model.
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
     * Finds the ImportFunctions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ImportFunctions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ImportFunctions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    public function actionImport($id){
		
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post()) )
			{
				
				$model->file = UploadedFile::getInstance($model, 'file');
				
				if ( $model->file )
					{
						
					//If we have a valid file input grab the file, move it to the CSV section of runtime and rename with data stamp
					$time = date("Ymd Hi");
					$model->file->saveAs(Yii::getAlias('@runtime').'/csv/'.$time." ".$model->name.'.' . $model->file->extension);
                    $model->file = Yii::getAlias('@runtime').'/csv/'.$time." ".$model->name.'.' . $model->file->extension;
                    $handle = fopen($model->file, "r");
					
					//Initialise the couters for the import
					$model->initImport();
                    while (($fileLine = fgetcsv($handle, ",")) !== false) 
						{
						
						
						//Check to see if the first line imported is the header, if so skip
						if($fileLine[0] != "Order ID"){
							$functionName = $model->function;
							$importedObject = $model->$functionName($fileLine);
							// print_r($fileop);exit();
							//$sql = "INSERT INTO details(name, age, location) VALUES ('$name', '$age', '$location')";
							//$query = Yii::$app->db->createCommand($sql)->execute();
							}
						}
					$model->closeImport();

					}

				
			return $this->render('import', ['id' => $id, 'model' => $model]); 
			}
			
		 return $this->render('import', ['id' => $id, 'model' => $model]); 
	}
    
    
	
    
}
