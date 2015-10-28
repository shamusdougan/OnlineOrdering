<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\actionButtons;
use app\models\Lookup;
use app\models\User;
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

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'columns' => [
			[
			'attribute' => 'Created_On',
			'value' => function ($data)
			    			{
							return date("d-M-Y", strtotime($data->Created_On));
							},
			],
            [
    		'attribute' => 'Order_ID',
    		'format' => 'raw',
    		'value' => function ($data)
    			{
				return html::a($data->Order_ID, "/customer-order/update?id=".$data->id);
				},
    		],
            [
            'attribute' => 'client.Company_Name',
            'label' => "Customer",
            ],
            [
            'attribute' =>'Name',
            'label' => 'Order Name',
            ],
            [
            'attribute' => 'Qty_Tonnes',
            'hAlign'=>'right', 
			],
			[
			'attribute' => 'Requested_Delivery_by',
			'value' => function ($data)
    			{
				return date("d-M-Y", strtotime($data->Requested_Delivery_by));
				},
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
				'template' => '{update} {delete}',
				'buttons' =>
					[
					'update' => function ($url, $model)
						{
							return $model->isActive() ? html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['update', 'id' => $model->id]), [
                                        'title' => 'Update',
                                        ]) : 
                                        html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::toRoute(['update', 'id' => $model->id]), [
                                        'title' => 'Update',
                                        ]);

						},
					'delete' => function ($url, $model)
						{
							return $model->isActive() ?  html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['delete', 'id' => $model->id]), [
                                        'title' => 'Delete Order',
                                        ]) : "";

						}
					]
			],
        ],
    ]); ?>

</div>
