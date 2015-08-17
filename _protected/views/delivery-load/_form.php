<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DeliveryLoad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delivery-load-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'delivery_id')->textInput() ?>

    <?= $form->field($model, 'load_qty')->textInput() ?>

    <?= $form->field($model, 'trailer_bin_id')->textInput() ?>

    <?= $form->field($model, 'delivery_on')->textInput() ?>

    <?= $form->field($model, 'delivery_completed_on')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
