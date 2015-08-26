<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\actionButtons;
use app\models\Lookup;
use app\models\User;
use app\models\CustomerOrders;
use yii\helpers\Url;

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

    

    <?= 
    
    
    
    
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'columns' => [

            'Order_ID',
            [
            'attribute' => 'client.Company_Name',
            'label' => "Customer",
            ],
            'Name',
            [
            'attribute' => 'Qty_Tonnes',
            'hAlign'=>'right', 
			],
			[
			'attribute' => 'createdByUser.fullname',
			'label' => 'Created By',
			'filter' => User::getUserFilterArray(),
			],
            [
            'attribute' => 'Price_Total',
            'value' => function($data)
            	{
					return "$".number_format($data->Price_Total, 2, ".", ",");
				},
			 'hAlign'=>'right', 
			],
            [
            'attribute' => 'Status',
            'value' => function($data) {
					return Lookup::item($data->Status, "ORDER_STATUS");
					},
			'filter' => Lookup::items("ORDER_STATUS"),
			 'hAlign'=>'center', 
			],

            [
				'class' => 'kartik\grid\ActionColumn',
				'template' =>  '{update}{delete}',
				'buttons' =>
					[
					'delete' => function ($url, $model)
						{
							return $model->Status == CustomerOrders::STATUS_ACTIVE ? html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['delete', 'id' => $model->id]), [
                                        'title' => 'Delete Order',
                                        ]) : '';

						}
					]
				
			],
        ],
    ]); ?>

</div>
