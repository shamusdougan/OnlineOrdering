<?php

use yii\helpers\Html;
use vendor\actionButtons\actionButtonsWidget;
use vendor\orderState\orderStateWidget;


/* @var $this yii\web\View */
/* @var $model app\models\WeighbridgeTicket */

//$this->title = 'Weighbridge Ticket: '.$model->ticket_number;
//$this->params['breadcrumbs'][] = ['label' => 'Weighbridge Tickets', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weighbridge-ticket-create">
  <?= orderStateWidget::widget(['object' => $model]) ?>
    <h1><?= Html::encode($this->title) ?></h1>
  
	<?= actionButtonsWidget::widget(['items' => $actionItems]) ?>
	
	
	
    <?= $this->render('_form', [
        'model' => $model,
        'delivery' => $delivery,
        'deliveryList' => $deliveryList,
        ]) ?>

</div>
