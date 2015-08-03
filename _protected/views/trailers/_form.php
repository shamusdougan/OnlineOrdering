<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\trailers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trailers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Registration')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Max_Capacity')->textInput() ?>

    <?= $form->field($model, 'NumBins')->textInput() ?>

    <?= $form->field($model, 'Auger')->textInput() ?>

    <?= $form->field($model, 'Blower')->textInput() ?>

    <?= $form->field($model, 'Tipper')->textInput() ?>

    <?= $form->field($model, 'Status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
