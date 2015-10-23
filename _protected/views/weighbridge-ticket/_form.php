<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WeighbridgeTicket */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="weighbridge-ticket-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'delivery_id')->textInput() ?>

    <?= $form->field($model, 'truck_id')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'driver')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gross')->textInput() ?>

    <?= $form->field($model, 'tare')->textInput() ?>

    <?= $form->field($model, 'net')->textInput() ?>

    <?= $form->field($model, 'Notes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Moisture')->textInput() ?>

    <?= $form->field($model, 'Protein')->textInput() ?>

    <?= $form->field($model, 'testWeight')->textInput() ?>

    <?= $form->field($model, 'screenings')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
