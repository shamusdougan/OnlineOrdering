<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StorageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="storage-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'Description') ?>

    <?= $form->field($model, 'Capacity') ?>

    <?= $form->field($model, 'company_id') ?>

    <?= $form->field($model, 'Auger')->checkbox() ?>

    <?php // echo $form->field($model, 'Blower')->checkbox() ?>

    <?php // echo $form->field($model, 'Delivery_Instructions') ?>

    <?php // echo $form->field($model, 'Postcode') ?>

    <?php // echo $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'Street_1') ?>

    <?php // echo $form->field($model, 'SuburbTown') ?>

    <?php // echo $form->field($model, 'Tipper')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
