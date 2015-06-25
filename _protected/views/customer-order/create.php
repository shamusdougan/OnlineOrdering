<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\customerOrders */

$this->title = 'Create Customer Orders';
$this->params['breadcrumbs'][] = ['label' => 'Customer Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-orders-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model, 'clientlist' => $clientlist
    ]) ?>

</div>
