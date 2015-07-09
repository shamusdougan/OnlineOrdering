<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\customerOrders */

$this->title = 'Update Customer Orders: ' . ' ' . $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'Customer Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Name, 'url' => ['view', 'id' => $model->Order_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="customer-orders-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model, 'clientList' => $clientList
    ]) ?>

</div>
