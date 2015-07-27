<?php

use yii\helpers\Html;
use app\models\CustomerOrders;


/* @var $this yii\web\View */
/* @var $model app\models\customerOrders */
if($model->Customer_id ==  CustomerOrders::PLACEHOLDERID)
	{
		$title = "New Order";
	}
else{
	$title = $model->Name;
}

$this->title = 'Customer Orders: ' . ' ' . $title;
$this->params['breadcrumbs'][] = ['label' => 'Customer Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Order_ID, 'url' => ['update', 'id' => $model->Order_ID]];

?>
<div class="customer-orders-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model, 'clientList' => $clientList
    ]) ?>

</div>
