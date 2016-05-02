<?php

namespace app\controllers;

use Yii;
use app\models\ProductsBins;
use app\models\ProductsBinsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductsBinsController implements the CRUD actions for ProductsBins model.
 */
class ProductsBinsController extends Controller
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
     * Lists all ProductsBins models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsBinsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['location_id' => SORT_ASC, 'order'=>SORT_ASC]]);
  		$actionItems[] = ['label'=>'New', 'button' => 'new', 'url'=> '/products-bins/create'];
  		  		
		
  		  		
  		  		
  		return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'actionItems' => $actionItems,
        ]);
    }

    /**
     * Displays a single ProductsBins model.
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
     * Creates a new ProductsBins model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductsBins();

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
			$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'overrideAction' => '/products-bins/create?exit=false', 'submit' => 'products-bin-form', 'confirm' => 'Save Delivery?']; 
			$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=> null, 'submit' => 'products-bin-form', 'confirm' => 'Save and Exit Delivery?']; 
	
        	
            return $this->render('create', [
                'model' => $model,
                'actionItems' => $actionItems,
            ]);
        }
    }

    /**
     * Updates an existing ProductsBins model.
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
			$actionItems[] = ['label'=>'Save', 'button' => 'save', 'url'=> null, 'overrideAction' => '/products-bins/update?id='.$id.'&exit=false', 'submit' => 'products-bin-form', 'confirm' => 'Save Delivery?']; 
			$actionItems[] = ['label'=>'Save & Exit', 'button' => 'save', 'url'=> null, 'submit' => 'products-bin-form', 'confirm' => 'Save and Exit Delivery?']; 
	
        	
            return $this->render('update', [
                'model' => $model,
                'actionItems' => $actionItems,
            ]);
        }
    }

    /**
     * Deletes an existing ProductsBins model.
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
     * Finds the ProductsBins model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductsBins the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductsBins::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
