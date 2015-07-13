<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CustomerOrdersIngredients */

$this->title = 'Update Customer Orders Ingredients: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Customer Orders Ingredients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="customer-orders-ingredients-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
