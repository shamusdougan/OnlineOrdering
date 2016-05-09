<?php

use yii\helpers\Html;
use app\models\CustomerOrders;
use vendor\actionButtons\actionButtonsWidget;
use vendor\orderState\orderStateWidget;
use app\models\Lookup;


/* @var $this yii\web\View */
/* @var $model app\models\customerOrders */
if(!isset($readOnly)){ $readOnly = False;}
if($model->Customer_id ==  CustomerOrders::PLACEHOLDERID)
	{
		$title = "New Order";
	}
else{
	$title = $model->Name;
}


$this->title = 'Customer Order: ' . ' ' . $title . ($model->isActive() ? "" : "(". Lookup::item($model->Status, "ORDER_STATUS").") ");
//$this->params['breadcrumbs'][] = ['label' => 'Customer Orders', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->Order_ID, 'url' => ['update', 'id' => $model->id]];

?>
<div class="customer-orders-update">

	<?= orderStateWidget::widget(['object' => $model]) ?>
	<?= actionButtonsWidget::widget(['items' => $actionItems]) ?>

    <h1><?= Html::encode($this->title) ?></h1>



    <?= $this->render('_form', [
        'model' => $model, 
        'clientList' => $clientList, 
        'storageList' => $storageList, 
        'readOnly' => $readOnly
    ]) ?>

</div>
