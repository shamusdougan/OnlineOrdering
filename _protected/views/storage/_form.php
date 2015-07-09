<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Storage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="storage-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Capacity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_id')->textInput() ?>

    <?= $form->field($model, 'Auger')->checkbox() ?>

    <?= $form->field($model, 'Blower')->checkbox() ?>

    <?= $form->field($model, 'Delivery_Instructions')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Postcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Status')->textInput() ?>

    <?= $form->field($model, 'Street_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SuburbTown')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Tipper')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
