<?php

use yii\helpers\Html;
use app\components\actionButtons;


/* @var $this yii\web\View */
/* @var $model app\models\WeighbridgeTicket */

$this->title = 'Weighbridge Ticket: '.$model->ticket_number;
$this->params['breadcrumbs'][] = ['label' => 'Weighbridge Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weighbridge-ticket-create">

    <h1><?= Html::encode($this->title) ?></h1>
	<?= actionButtons::widget(['items' => $actionItems]) ?>
	
	
	
    <?= $this->render('_form', [
        'model' => $model,
        'delivery' => $delivery,
        'deliveryList' => $deliveryList,
        ]) ?>

</div>
