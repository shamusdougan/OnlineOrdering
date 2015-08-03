<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\trailersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trailers-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'Registration') ?>

    <?= $form->field($model, 'Description') ?>

    <?= $form->field($model, 'Max_Capacity') ?>

    <?= $form->field($model, 'NumBins') ?>

    <?php // echo $form->field($model, 'Auger') ?>

    <?php // echo $form->field($model, 'Blower') ?>

    <?php // echo $form->field($model, 'Tipper') ?>

    <?php // echo $form->field($model, 'Status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
