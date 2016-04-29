<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Lookup;
use vendor\actionButtons\actionButtonsWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DeliverySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Deliveries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-index">


    <?= actionButtonswidget::widget(['items' => $actionItems]) ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'columns' => [
        	[
    		'attribute' => 'Name',
    		'format' => 'raw',
    		'value' => function ($data)
    			{
				return html::a($data->Name, "/delivery/update?id=".$data->id);
				},
			'width' => '10%',
    		],
    		[
	    		'attribute' => 'customerOrder.Requested_Delivery_by',
	    		'format' => 'raw',
	    		'value' => function ($data)
	    			{
	    			if(isset($data->customerOrder))
	    				{
						return date("D - d M Y", strtotime($data->customerOrder->Requested_Delivery_by));		
						}
					else{
						return "Not Set";
					}
					},
				'width' => '10%',
    		],
    		[
	    		'attribute' => 'customerOrder.Name',
	    		'width' => '15%',
    		],
           	[
	            'attribute' => 'customerOrder.Qty_Tonnes',
	            'width' => '5%',
            ],
            [
    		'attribute' => 'delivery_on',
    		'label' => 'Delivery Scheduled On',
    		'filterType'=> GridView::FILTER_DATE,
    		'filterWidgetOptions' => 
    			[
				'pluginOptions'=>
					[
					'format' => 'dd M yyyy',
					'autoWidget' => true,
					'autoclose' => true,
					'todayBtn' => true,
					],
				],
    		'format' => 'raw',
    		'value' => function ($data)
    			{
				return date("D - d M Y", strtotime($data->delivery_on));
				},
			'width' => '15%',
    		],
    		[
	    		'attribute' => 'delivery_qty',
	    		'label' => 'Qty Unallocated',
	    		'format' => 'raw',
	    		'value' => function ($data)
	    			{
	    			if(isset($data->customerOrder))
	    				{
						return ($data->customerOrder->Qty_Tonnes - $data->delivery_qty);
						}
					else{
						return "Not Set";
						}
					},
				'width' => '5%'
    		],
    		[
    			'attribute' => 'status',
    			'value' => function ($data)
    				{
					return Lookup::item($data->status, "DELIVERY_STATUS");
					},
				'width' => '10%',
				'filter' => Lookup::items("DELIVERY_STATUS"),
    		
    		],
            [
            'attribute' => 'Weighbridge Ticket',
            'format' =>'raw',
            'value' => function ($data)
            	{
				if($data->hasWeighBridgeTicket())
					{
					return html::a($data->weighbridgeTicket->ticket_number,  Url::toRoute(['/weighbridge-ticket/update', 'id' => $data->weighbridgeTicket->id]));
					}
				else{
					return "";
					}
				},
            'width' => '10%',
            ],
            [
				'class' => 'kartik\grid\ActionColumn',
				'template' => '{update} {delete} {weighbridge} {complete} {complete-return}',
				'width' => '5%',
				'buttons' =>
					[
					'weighbridge' => function ($url, $model)
						{
						if(!$model->hasWeighBridgeTicket())
							{
							return html::a('<span class="glyphicon glyphicon-tags"></span>', Url::toRoute(['/weighbridge-ticket/create', 'delivery_id' => $model->id]), [
                                    'title' => 'Create Weighbridge Ticket',
                                    ]);		
							}
						},
					'complete' => function ($url, $model)
						{
						if($model->isStatusLoaded())
							{
							return html::a('<span class="glyphicon glyphicon-ok"></span>', Url::toRoute(['/delivery/complete', 'id' => $model->id]), [
                                    'title' => 'Complete Delivery (No Returns)',
                                    ]);	
								
							}
						},
					'complete-return' => function($url, $model)
						{
						if($model->isStatusLoaded())
							{
							return html::a('<span class="glyphicon glyphicon-download-alt"></span>', Url::toRoute(['/returns/create', 'delivery_id' => $model->id]), [
                                    'title' => 'Complete with a Return',
                                    ]);	
								
							}	
						}
					]
			],
        ],
    ]); ?>

</div>

