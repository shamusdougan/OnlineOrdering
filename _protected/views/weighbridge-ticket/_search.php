<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WeighbridgeTicketSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="weighbridge-ticket-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'delivery_id') ?>

    <?= $form->field($model, 'truck_id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'driver') ?>

    <?php // echo $form->field($model, 'gross') ?>

    <?php // echo $form->field($model, 'tare') ?>

    <?php // echo $form->field($model, 'net') ?>

    <?php // echo $form->field($model, 'Notes') ?>

    <?php // echo $form->field($model, 'Moisture') ?>

    <?php // echo $form->field($model, 'Protein') ?>

    <?php // echo $form->field($model, 'testWeight') ?>

    <?php // echo $form->field($model, 'screenings') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
