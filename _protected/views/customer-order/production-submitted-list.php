<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use app\components\actionButtons;
use app\models\Lookup;
use app\models\User;
use kartik\widgets\ActiveForm;

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

      <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'customer-order-submitted-list-form']); ?>

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
				return html::a($data->Order_ID, "/customer-order/update-production-submitted?id=".$data->id);
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

     <?php ActiveForm::end(); ?>    

</div>
<?php

?>