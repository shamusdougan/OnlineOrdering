<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DeliveryLoadBin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delivery-load-bin-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'delivery_load_id')->textInput() ?>

    <?= $form->field($model, 'trailer_bin_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
