<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\WeighbridgeTicket */

$this->title = 'Create Weighbridge Ticket';
$this->params['breadcrumbs'][] = ['label' => 'Weighbridge Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weighbridge-ticket-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'delivery' => $delivery,
        'deliveryList' => $deliveryList,
        ]) ?>

</div>
