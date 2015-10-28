<?php
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use app\models\Lookup;






 $this->registerJs(
    "$(document).on('click', \"#refresh_order_grid\", function() 
    	{
    	$.pjax.reload({container:\"#client-orders-grid\"});
		});"
   );	
 

$this->registerJs(
    "$(document).on('click', '.order-view-link', function() 
    	{
    	order_id = $(this).closest('tr').data('key')	
    	window.open('".yii\helpers\Url::toRoute("customer-order/update")."?id=' + order_id);
		
		});
	"
   );


$this->registerJs(
    "$(document).on('click', '.order-copy-link', function() 
    	{
    	order_id = $(this).closest('tr').data('key')	
    	
    	alert('copying order ' + order_id);
    	
    	
		
		});
	"
   );

























$gridColumns = [
	['attribute' => 'Name'],
	['attribute' => 'Qty_Tonnes'],
	
	['attribute' => 'Price_Total'],
	[
	'attribute' => 'Requested_Delivery_by',
	'value' => function ($data)
	    			{
					return date("D d-M-Y", strtotime($data->Requested_Delivery_by));
					},
	],
	[
	'attribute' => 'Status',
	'value' => function ($data)
	    			{
					return Lookup::item($data->Status, "ORDER_STATUS");
					},
	],
	[
	    'class'=>'kartik\grid\ActionColumn',
		'template' => '{view} {copy}',
		'contentOptions' => ['class' => 'padding-left-5px'],

	   	'buttons' => 
	   		[
	   		'view' => function ($url, $model, $key) 
	   			{
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>','#', 
                	[
                    'class' => 'order-view-link',
                    'title' => 'View Details',
					]);
				},
			'copy' => function ($url, $model, $key) 
	   			{
                return Html::a('<span class="glyphicon glyphicon-tags"></span>','#', 
                	[
                    'class' => 'order-copy-link',
                    'title' => 'Copy this order',
					]);
				},
			],
	    'headerOptions'=>['class'=>'kartik-sheet-style'],
	],
	
	];		

echo GridView::widget(
		[
		'id' => 'client_orders-grid-control',
		'panel'=>[
        		'type'=>GridView::TYPE_PRIMARY,
        		'heading'=>"Company Contacts",
   		 ],
		'headerRowOptions'=>['class'=>'kartik-sheet-style'],
		'toolbar'=> 
			[
				['content'=>
					Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'Create New Order', 'class'=>'btn btn-success', 'client_id' => $model->id, 'id' => 'add_order_button' ]) . ' '.
					Html::button('<i class="glyphicon glyphicon-repeat"></i>', ['type'=>'button', 'title'=>'Refresh Orders', 'id' => 'refresh_order_grid', 'class'=>'btn btn-success'])
				],
			],
		'dataProvider'=> new yii\data\ActiveDataProvider(['query' => $model->getOrders()]),
		//'filterModel'=>$searchModel,
		'columns'=>$gridColumns,
		'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
		'headerRowOptions'=>['class'=>'kartik-sheet-style'],
		'filterRowOptions'=>['class'=>'kartik-sheet-style'],
		'pjax'=>true, 
		'pjaxSettings' =>
			[
			'neverTimeout'=>true,
			'options' =>['id' => 'client-orders-grid'],
			
			],
 		'export' => false,
		]);
	



?>