<?php

use yii\helpers\Html;
use kartik\grid\GridView;

use app\components\actionButtons;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DeliverySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Deliveries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-index">


    <?= actionButtons::widget(['items' => $actionItems]) ?>
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
    		],
    		[
    		'attribute' => 'customerOrder.Requested_Delivery_by',
    		'format' => 'raw',
    		'value' => function ($data)
    			{
				return date("D - d M Y", strtotime($data->customerOrder->Requested_Delivery_by));
				},
    		],
    		
            'customerOrder.Name',
           
            'customerOrder.Qty_Tonnes',
            [
    		'attribute' => 'delivery_on',
    		'label' => 'Delivery Scheduled On',
    		'filterType'=> GridView::FILTER_DATE_RANGE,
    		'format' => 'raw',
    		'value' => function ($data)
    			{
				return date("D - d M Y", strtotime($data->delivery_on));
				},
    		],
    		[
    		'attribute' => 'delivery_qty',
    		'label' => 'Qty Unallocated',
    		'format' => 'raw',
    		'value' => function ($data)
    			{
				return ($data->customerOrder->Qty_Tonnes - $data->delivery_qty);
				},
    		],
            
            [
				'class' => 'kartik\grid\ActionColumn',
				'template' => '{update} {delete}',
			],
        ],
    ]); ?>

</div>
