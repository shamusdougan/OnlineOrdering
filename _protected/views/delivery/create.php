<?php

use yii\helpers\Html;
use vendor\actionButtons\actionButtonsWidget;
use vendor\orderState\orderStateWidget;


/* @var $this yii\web\View */
/* @var $model app\models\Delivery */

$this->title = 'Create Delivery';
if(isset($model->order_id))
	{
	$this->title .= ': '.$order->Name;		
	}



//$this->params['breadcrumbs'][] = ['label' => 'Deliveries', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-create">

	<?= orderStateWidget::widget(['object' => $model]) ?>
	<?= actionButtonsWidget::widget(['items' => $actionItems]) ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'order' => $order,
    ]) ?>

</div>
