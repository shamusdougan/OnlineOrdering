<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\trucksSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trucks-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'registration') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'CreatedBy') ?>

    <?= $form->field($model, 'defaultTrailer') ?>

    <?php // echo $form->field($model, 'SpecialInstruction') ?>

    <?php // echo $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'Auger') ?>

    <?php // echo $form->field($model, 'Blower') ?>

    <?php // echo $form->field($model, 'Tipper') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
