<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use vendor\actionButtons\actionButtonsWidget;

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
			'date',
			'truck.registration',
            'ticket_number',
            'delivery_id',
          
            
            // 'gross',
            // 'tare',
            // 'net',
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
