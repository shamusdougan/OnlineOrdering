<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\actionButtons;

/* @var $this yii\web\View */
/* @var $searchModel app\models\customerOrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customer Orders';
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="customer-orders-index">

    <?= actionButtons::widget(['items' => $actionItems]) ?>

    <h1><?= Html::encode($this->title) ?></h1>
    
    


    
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'columns' => [

            'Order_ID',
            'client.Company_Name',
            'Name',
            'Qty_Tonnes',
  
            'Price_Total',
  
            'Status',
            [
  			'class' => '\kartik\grid\CheckboxColumn',
			],
            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete}',
			],
        ],
    ]); ?>

</div>
