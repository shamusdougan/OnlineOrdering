<?php

namespace app\controllers;

use Yii;
use app\models\lookup;
use app\models\lookupSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LookupController implements the CRUD actions for lookup model.
 */
class LookupController extends Controller
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
     * Lists all lookup models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$searchModel = new lookupSearch();
    	 $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	$this->view->params['menuItem'] = 'lookupItem';


        return $this->render('index', [
            'dataProvider' => $dataProvider, 'searchModel' => $searchModel
        ]);
    }

    /**
     * Displays a single lookup model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$this->view->params['menuItem'] = 'lookupItem';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new lookup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new lookup();
		$this->view->params['menuItem'] = 'lookupItem';
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing lookup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->view->params['menuItem'] = 'lookupItem';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }




  public function actionTest()
    {
        $model = "blsa";

       
            return $this->render('test', [
                'model' => $model,
            ]);
    }
    /**
     * Deletes an existing lookup model.
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
     * Finds the lookup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return lookup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = lookup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
