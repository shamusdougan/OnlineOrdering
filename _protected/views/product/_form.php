<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Product_ID')->textInput() ?>

    <?= $form->field($model, 'Description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Status')->textInput() ?>

    <?= $form->field($model, 'cp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Decimals_Supported')->textInput() ?>

    <?= $form->field($model, 'Default_Unit')->textInput() ?>

    <?= $form->field($model, 'Feed_notes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'List_Price_pT_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'me')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Mix_Margin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Mix_Margin_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Mix_Type')->textInput() ?>

    <?= $form->field($model, 'ndf')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Product_Category')->textInput() ?>

    <?= $form->field($model, 'Retail_Price_t')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
