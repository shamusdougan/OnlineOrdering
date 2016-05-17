<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\emailQueueSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-queue-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'from') ?>

    <?= $form->field($model, 'to') ?>

    <?= $form->field($model, 'subject') ?>

    <?= $form->field($model, 'htmlBody') ?>

    <?php // echo $form->field($model, 'attachment1') ?>

    <?php // echo $form->field($model, 'attachment1_filename') ?>

    <?php // echo $form->field($model, 'attachment1_type') ?>

    <?php // echo $form->field($model, 'attachment2') ?>

    <?php // echo $form->field($model, 'attachment2_filename') ?>

    <?php // echo $form->field($model, 'attachment2_type') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
