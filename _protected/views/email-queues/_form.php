<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\emailQueue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-queue-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'htmlBody')->textInput() ?>

    <?= $form->field($model, 'attachment1')->textInput() ?>

    <?= $form->field($model, 'attachment1_filename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'attachment1_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'attachment2')->textInput() ?>

    <?= $form->field($model, 'attachment2_filename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'attachment2_type')->textInput(['maxlength' => true]) ?>

    

    <?php ActiveForm::end(); ?>

</div>
