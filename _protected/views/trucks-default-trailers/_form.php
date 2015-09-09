<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrucksDefaultTrailers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trucks-default-trailers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'truck_id')->textInput() ?>

    <?= $form->field($model, 'trailer_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
