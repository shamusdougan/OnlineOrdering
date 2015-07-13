<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CustomerOrdersIngredients */

$this->title = 'Create Customer Orders Ingredients';
$this->params['breadcrumbs'][] = ['label' => 'Customer Orders Ingredients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-orders-ingredients-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
