<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\trucks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trucks-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'registration')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CreatedBy')->textInput() ?>

    <?= $form->field($model, 'defaultTrailer')->textInput() ?>

    <?= $form->field($model, 'SpecialInstruction')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Status')->textInput() ?>

    <?= $form->field($model, 'Auger')->textInput() ?>

    <?= $form->field($model, 'Blower')->textInput() ?>

    <?= $form->field($model, 'Tipper')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
