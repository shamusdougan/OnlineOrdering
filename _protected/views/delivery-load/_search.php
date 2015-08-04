<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DeliveryLoadSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delivery-load-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'delivery_id') ?>

    <?= $form->field($model, 'load_qty') ?>

    <?= $form->field($model, 'trailer_bin_id') ?>

    <?= $form->field($model, 'delivery_on') ?>

    <?php // echo $form->field($model, 'delivery_completed_on') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
