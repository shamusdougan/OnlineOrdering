<?php

use yii\helpers\Html;
use app\models\CustomerOrders;


/* @var $this yii\web\View */
/* @var $model app\models\customerOrders */

$this->title = 'Customer Orders: ' . ' ' . ($model->Customer_id ==  CustomerOrders::PLACEHOLDERID) ? "New Order" : $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'Customer Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Order_ID, 'url' => ['update', 'id' => $model->Order_ID]];

?>
<div class="customer-orders-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model, 'clientList' => $clientList
    ]) ?>

</div>
