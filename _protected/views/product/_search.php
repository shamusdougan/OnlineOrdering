<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'Name') ?>

    <?= $form->field($model, 'Product_ID') ?>

    <?= $form->field($model, 'Description') ?>

    <?= $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'cp') ?>

    <?php // echo $form->field($model, 'Decimals_Supported') ?>

    <?php // echo $form->field($model, 'Default_Unit') ?>

    <?php // echo $form->field($model, 'Feed_notes') ?>

    <?php // echo $form->field($model, 'List_Price_pT_Base') ?>

    <?php // echo $form->field($model, 'me') ?>

    <?php // echo $form->field($model, 'Mix_Margin') ?>

    <?php // echo $form->field($model, 'Mix_Margin_Base') ?>

    <?php // echo $form->field($model, 'Mix_Type') ?>

    <?php // echo $form->field($model, 'ndf') ?>

    <?php // echo $form->field($model, 'Product_Category') ?>

    <?php // echo $form->field($model, 'Retail_Price_t') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
