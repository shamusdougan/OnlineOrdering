<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Delivery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delivery-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'weigh_bridge_ticket')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weighed_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_qty')->textInput() ?>

    <?= $form->field($model, 'delivery_on')->textInput() ?>

    <?= $form->field($model, 'delivery_completed_on')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
