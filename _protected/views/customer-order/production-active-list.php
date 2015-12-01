<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use vendor\actionButtons\actionButtonsWidget;
use app\models\Lookup;
use app\models\User;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\customerOrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customer Orders: ACTIVE';
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="customer-orders-index">

    <?= actionButtonsWidget::widget(['items' => $actionItems]) ?>

    <h1><?= Html::encode($this->title) ?></h1>
    
    


    
    
  <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'customer-order-active-list-form']); ?>

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'columns' => [
			
			[
  			'class' => '\kartik\grid\CheckboxColumn',
			],
			[
    		'attribute' => 'Order_ID',
    		'format' => 'raw',
    		'value' => function ($data)
    			{
				return html::a($data->Order_ID, "/customer-order/update-production-active?id=".$data->id);
				},
    		],
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
				'template' => '{update} {delete}',
				'buttons' =>
					[
					'update' => function ($url, $model)
						{
							return html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['update-production-active', 'id' => $model->id]), [
                                        'title' => 'Update',
                                        ]);

						},
					'delete' => function ($url, $model)
						{
							return html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['delete', 'id' => $model->id, 'redirectTo' => 'production-active-list']), [
                                        'title' => 'Delete',
                                        ]);

						}
					]
			],
        ],
    ]); ?>

</div>

         
<?php ActiveForm::end(); ?>

</div>
