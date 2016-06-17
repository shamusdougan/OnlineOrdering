<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use vendor\actionButtons\actionButtonsWidget;
use app\models\Lookup;
use webvimark\modules\UserManagement\models\User;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\customerOrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customer Orders';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJS(
"



    $(document).on('click', '.unsubmit_orders', function()  
    {
	var orderArray = [];
    $('.order_cb').each(function()
    {
        if  ($(this).is(\":checked\"))
        {
            orderArray.push($(this).val());
        }

    });
    
   var selectedOrders = orderArray.join();
   if(selectedOrders == '' || selectedOrders == null )
			{
			alert('No Orders selected');
			}
	else{
        $.ajax({
            url: '".yii\helpers\Url::toRoute("customer-order/ajax-unsubmit-order")."',
            dataType: 'json',
            method: 'GET',
            data: {selectedOrders: selectedOrders},
            success: function (data, textStatus, jqXHR) {
                $.pjax.reload({container:\"#order-grid\"});
                },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('An error occured!');
                alert('Error in ajax request' );
                }
            });
        }
    });
	
"


);

?>
<div class="customer-orders-index">

    <?= actionButtonsWidget::widget(['items' => $actionItems]) ?>

    <h1><?= Html::encode($this->title) ?></h1>
    
    


    
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

      <?php //$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'customer-order-submitted-list-form']); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'pjax'=>true,
	    'pjaxSettings' =>
	        [
	            'options' =>['id' => 'order-grid'],
	        ],
        'columns' => [
			
			[
  			'class' => '\kartik\grid\CheckboxColumn',
  			'checkboxOptions' =>
	            [
	                'class' => 'order_cb',
	            ],
			],

            [
    		'attribute' => 'Order_ID',
    		'format' => 'raw',
    		'value' => function ($data)
    			{
				return html::a($data->Order_ID, "/customer-order/update-production-submitted?id=".$data->id);
				},
    		],
            [
            'attribute' => 'Customer_id',
            'value' => function ($data) use ($customerList)
            	{
				return $customerList[$data->Customer_id];
				},
            'label' => "Customer",
            'filterType'=>GridView::FILTER_SELECT2,
            'filter' => $customerList,
            'filterWidgetOptions'=>['pluginOptions'=>['allowClear'=>true],],
    		'filterInputOptions'=>['placeholder'=>'Any Client'],
    		'width' => '200px',
            ],
            'Name',
            [
            'attribute' => 'Qty_Tonnes',
            'hAlign'=>'right', 
			],
			[
			'attribute' => 'Requested_Delivery_by',
			'label' => 'Requested By Date',
			'value' => function($data)
            	{
					return date("D - d M Y", strtotime($data->Requested_Delivery_by));
				},
			],
			[
			'attribute' => 'createdByUser.fullname',
			'label' => 'Created By',
			'filter' => $userListArray,
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
			'filter' => false,
			'hAlign'=>'center', 
			],

            [
				'class' => 'kartik\grid\ActionColumn',
				'template' => '{update} {delivery}',
				'buttons' =>
					[
					'update' => function ($url, $model)
						{
							return html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['update-production-submitted', 'id' => $model->id]), [
                                        'title' => 'Update',
                                        ]);

						},
					'delivery' => function ($url, $model)
						{
							return html::a('<span class="glyphicon glyphicon-road"></span>', Url::toRoute(['/delivery/create', 'order_id' => $model->id]), [
                                        'title' => 'Create Delivery',
                                        ]);

						}
					]
			],
        ],
    ]); ?>

</div>

     <?php //ActiveForm::end(); ?>    

</div>
<?php

?>