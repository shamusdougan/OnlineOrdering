<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DeliveryLoad */

$this->title = 'Create Delivery Load';
$this->params['breadcrumbs'][] = ['label' => 'Delivery Loads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-load-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
