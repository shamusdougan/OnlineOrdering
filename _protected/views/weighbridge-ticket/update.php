<?php

use yii\helpers\Html;
use vendor\orderState\orderStateWidget;

/* @var $this yii\web\View */
/* @var $model app\models\WeighbridgeTicket */

$this->title = 'Update Weighbridge Ticket: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Weighbridge Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="weighbridge-ticket-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
