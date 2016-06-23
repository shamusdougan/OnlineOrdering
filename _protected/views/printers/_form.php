<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Printers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="printers-form">

   <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'printer-form']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'print_label')->checkbox() ?>

    <?= $form->field($model, 'print_a4')->checkbox() ?>

    

    <?php ActiveForm::end(); ?>

</div>
