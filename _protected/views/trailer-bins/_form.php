<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrailerBins */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trailer-bins-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'trailer_id')->textInput() ?>

    <?= $form->field($model, 'BinNo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MaxCapacity')->textInput() ?>

    <?= $form->field($model, 'Status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
