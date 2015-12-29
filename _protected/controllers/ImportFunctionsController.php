<?php

namespace app\controllers;

use Yii;
use app\models\ImportFunctions;
use app\models\ImportFunctionSearch;
use app\models\Product;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\ProductsPrices;


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
					
					//Initialise the counters for the import
					$model->initImport();
					
					//iterate through each line of the csv file with and apply the import function to it.
					//The import function will save the data.
                    while (($fileLine = fgetcsv($handle, ",")) !== false) 
						{
						$functionName = $model->function;
						$model->$functionName($fileLine);
						}
					$model->closeImport();

					}

				
			return $this->render('import', ['id' => $id, 'model' => $model]); 
			}
			
		 return $this->render('import', ['id' => $id, 'model' => $model]); 
	}
    
    
   public function actionImportIngredient($product_id)
   	{
	$importIngredientId = 7;
	$model = $this->findModel($importIngredientId);
	$product = Product::findOne($product_id);
	$actionItems[] = ['label'=>'Back', 'button' => 'back', 'url'=>'/product/update?id='.$product_id];
	
	
	if ($model->load(Yii::$app->request->post()) )
			{
				
				$model->file = UploadedFile::getInstance($model, 'file');
				
				if ( $model->file )
				{
				$time = date("Ymd Hi");
					$model->file->saveAs(Yii::getAlias('@runtime').'/csv/'.$time." ".$model->name.'.' . $model->file->extension);
                    $model->file = Yii::getAlias('@runtime').'/csv/'.$time." ".$model->name.'.' . $model->file->extension;
                    $handle = fopen($model->file, "r");
					
					//Initialise the counters for the import
					$model->initImport();
					
					//clear the existing product ingedients
					
					$product->clearIngredients();


					$sum = 0;
					//iterate through each line of the csv file with and apply the import function to it.
					//The import function will save the data.
                    while (($fileLine = fgetcsv($handle, ",")) !== false) 
						{
						$functionName = $model->function;
						$sum += $model->$functionName($fileLine, $product_id);
						}
					$model->closeImport();	
					
					if(bccomp($sum, 100) != 0)
						{
						$model->recordsFailed++;
						$model->progress .= "Total Ingredients need to sum to 100, currently ingredient percentage is: ".bccomp($sum, 100)."\n";
						}
				}
				
			if($model->recordsFailed > 0)
				{
				return $this->render('import-ingredient', 
					[
					'model' => $model,
					'product' => $product,
					'actionItems' => $actionItems,
					]); 		
				}	
			else{
				return $this->redirect(['/product/update', 'id' => $product_id]); 		
				}
			
			}
	
	
	
	return $this->render('import-ingredient', 
		[
		'model' => $model, 
		'product' => $product,
		'actionItems' => $actionItems,
		
		]); 
	}
    


	public function actionImportPriceSheet()
	   	{
		$importPricingModelId = 8;
		$model = $this->findModel($importPricingModelId);
		
		$progress[] = ['label' => 'Select File', 'url'=>['/import-functions/import-price-sheet'], 'icon' => null, 'mouseOver' => 'Select a File to import to the Pricing Sheet. To get the Correct format first export an excel file from the price update page'];
		$progress[] = ['label' => 'Choose Column', 'url'=>null, 'icon' => null,  'mouseOver' => 'this is a test popup'];
		$progress[] = ['label' => 'Prices Imported', 'url'=>null, 'icon' => null,  'mouseOver' => 'this is a test popup'];
		
		//Check the state of the data inport, entry state is upload->to upload the excel file
		$post = Yii::$app->request->post();
		$importState = "upload";
		if(array_key_exists("importState", $post))
			{
			$importState = $post['importState'];
			}
		
		//Render the for to upload the excel file 
		if($importState == "upload")
			{
				
			$actionItems[] = ['label'=>'Back', 'button' => 'back', 'url'=>'/product/update-pricing'];				
				
			return $this->render('import-pricing', 
				[
				'model' => $model, 
				'actionItems' => $actionItems,
				'progress' => $progress,
				'progressStep' => 0,
				'currentState' => $importState,
				'nextState' => "selectColumns",
				]); 
			}
			
		//render the form to select which (if any) to import the prcing data from
		elseif($importState == 'selectColumns')
			{
			$actionItems[] = ['label'=>'Back', 'button' => 'back', 'url'=>'/import-functions/import-price-sheet?id=8'];				
				
			$model->load(Yii::$app->request->post());
			$model->file = UploadedFile::getInstance($model, 'file');
			if ($model->file)
				{
				$time = date("Ymd Hi");
				$model->file->saveAs(Yii::getAlias('@runtime').'/csv/'.$time." ".$model->name.'.' . $model->file->extension);
                $model->file = Yii::getAlias('@runtime').'/csv/'.$time." ".$model->name.'.' . $model->file->extension;
                $handle = fopen($model->file, "r");
					
				//parse the excel file, if any thing is a little off then redisplay the file upload screen
				$dataProvider = ProductsPrices::getDataProviderFromExcel($model->file);
				if(is_string($dataProvider))
					{
					Yii::$app->session->setFlash('error', $dataProvider);
					$actionItems = [];
					$actionItems[] = ['label'=>'Back', 'button' => 'back', 'url'=>'/product/update-pricing'];	
					return $this->render('import-pricing', 
						[
						'model' => $model, 
						'actionItems' => $actionItems,
						'progress' => $progress,
						'progressStep' => 0,
						'currentState' => "upload",
						'nextState' => "selectColumns",
						]); 	
						
					}
					
				
				
				return $this->render('import-pricing', 
					[
					'model' => $model, 
					'actionItems' => $actionItems,
					'progress' => $progress,
					'progressStep' => 1,
					'currentState' => $importState,
					'nextState' => "importData",
					'dataProvider' => $dataProvider,
					]); 
				
				}
			}
		else{
			die("unknown Import state");
			}
	
		
		
		
		
		
		}
    
    public function actionCreateTemplateCsv()
    {
		$content = "Ingredient Code,Ingredient,Ingedient %";
		
		return $this->renderPartial("csvTemplate", ['content' => $content]);
	}
    
    
}
