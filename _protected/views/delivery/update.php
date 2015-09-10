<?php

use yii\helpers\Html;
use app\components\actionButtons;


/* @var $this yii\web\View */
/* @var $model app\models\Delivery */

$this->title = 'Update Delivery : '.$order->Name;;




$this->params['breadcrumbs'][] = ['label' => 'Deliveries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-create">

	<?= actionButtons::widget(['items' => $actionItems]) ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'submittedOrders' => $submittedOrders,
        'order' => $order
    ]) ?>

</div>
