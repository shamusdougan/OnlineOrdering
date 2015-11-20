<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use vendor\actionButtons\actionButtonsWidget;
use app\models\trucks;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WeighbridgeTicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Weighbridge Tickets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weighbridge-ticket-index">

  	<?= actionButtonsWidget::widget(['items' => $actionItems]) ?>
    <h1><?= Html::encode($this->title) ?></h1>
  

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'columns' => [
        	[
	        	'attribute' => 'ticket_number',
	        	'format' => 'raw',
	    		'value' => function ($data)
	    			{
					return html::a($data->ticket_number, "/weighbridge-ticket/update?id=".$data->id);
					},
				'width' => '10%',
    		],
			[
	    		'attribute' => 'date',
	    		'label' => 'Date',
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
					return date("D - d M Y", strtotime($data->date));
					},
				'width' => '15%',
    		],
			[
				'attribute' => 'truck_id',
				'label' => 'Vehicle',
				'filter' => Trucks::getFilterList(),
				'value' => function ($data)
	    			{
					return $data->truck->registration;
					},
			],
           
          
            
            'gross',
            'tare',
            'net',
            // 'Notes',
            // 'Moisture',
            // 'Protein',
            // 'testWeight',
            // 'screenings',

            [
				'class' => 'kartik\grid\ActionColumn',
				'template' => '{update} {delete}',
				'width' => '5%',
			],
        ],
    ]); ?>

</div>
