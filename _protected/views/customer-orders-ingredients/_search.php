<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CustomerOrdersIngredientsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-orders-ingredients-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'created_on') ?>

    <?= $form->field($model, 'category') ?>

    <?= $form->field($model, 'ingredient_id') ?>

    <?= $form->field($model, 'ingredient_percent') ?>

    <?php // echo $form->field($model, 'modified_by') ?>

    <?php // echo $form->field($model, 'modified_on') ?>

    <?php // echo $form->field($model, 'order_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
