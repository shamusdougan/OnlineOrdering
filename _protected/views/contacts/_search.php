<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\contactsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contacts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'Business_Phone') ?>

    <?= $form->field($model, 'Address_1') ?>

    <?= $form->field($model, 'Address_1_CountryRegion') ?>

    <?= $form->field($model, 'Address_1_Postal_Code') ?>

    <?php // echo $form->field($model, 'Address_1_StateProvince') ?>

    <?php // echo $form->field($model, 'Address_1_Street_1') ?>

    <?php // echo $form->field($model, 'Address_1_Street_2') ?>

    <?php // echo $form->field($model, 'Address_1_TownSuburbCity') ?>

    <?php // echo $form->field($model, 'Do_Not_Allow_Bulk_Emails')->checkbox() ?>

    <?php // echo $form->field($model, 'Do_Not_Allow_Bulk_Mails')->checkbox() ?>

    <?php // echo $form->field($model, 'Do_Not_Allow_Emails')->checkbox() ?>

    <?php // echo $form->field($model, 'Do_Not_Allow_Faxes')->checkbox() ?>

    <?php // echo $form->field($model, 'Do_Not_Allow_Mails')->checkbox() ?>

    <?php // echo $form->field($model, 'Do_Not_Allow_Phone_Calls')->checkbox() ?>

    <?php // echo $form->field($model, 'Email') ?>

    <?php // echo $form->field($model, 'Fax') ?>

    <?php // echo $form->field($model, 'First_Name') ?>

    <?php // echo $form->field($model, 'Job_Title') ?>

    <?php // echo $form->field($model, 'Last_Name') ?>

    <?php // echo $form->field($model, 'Mobile_Phone') ?>

    <?php // echo $form->field($model, 'Company') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
