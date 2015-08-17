<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DeliveryLoad */

$this->title = 'Update Delivery Load: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Delivery Loads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="delivery-load-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
