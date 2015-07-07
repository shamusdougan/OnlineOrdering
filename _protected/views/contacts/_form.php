<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\contacts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contacts-form">

    <?php $form = ActiveForm::begin(['id' => 'contact_update_form']); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'Business_Phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_CountryRegion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Postal_Code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_StateProvince')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Street_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Street_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_TownSuburbCity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Do_Not_Allow_Bulk_Emails')->checkbox() ?>

    <?= $form->field($model, 'Do_Not_Allow_Bulk_Mails')->checkbox() ?>

    <?= $form->field($model, 'Do_Not_Allow_Emails')->checkbox() ?>

    <?= $form->field($model, 'Do_Not_Allow_Faxes')->checkbox() ?>

    <?= $form->field($model, 'Do_Not_Allow_Mails')->checkbox() ?>

    <?= $form->field($model, 'Do_Not_Allow_Phone_Calls')->checkbox() ?>

    <?= $form->field($model, 'Email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Fax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'First_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Job_Title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Last_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Mobile_Phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Company_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
