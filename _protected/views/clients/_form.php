<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\clients */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clients-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'Company_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Account_Number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Main_Phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Fax')->textInput() ?>

    <?= $form->field($model, 'TownSuburb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Is_Customer')->checkbox() ?>

    <?= $form->field($model, 'Is_Factory')->checkbox() ?>

    <?= $form->field($model, 'Is_Supplier')->checkbox() ?>

    <?= $form->field($model, '3rd_Party_Company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ABN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Address_Type')->textInput() ?>

    <?= $form->field($model, 'Address_1_CountryRegion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Postal_Code')->textInput() ?>

    <?= $form->field($model, 'Address_1_StateProvince')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Street_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Street_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Street_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Telephone_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Telephone_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Address_Type')->textInput() ?>

    <?= $form->field($model, 'Address_2_CountryRegion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Postal_Code')->textInput() ?>

    <?= $form->field($model, 'Address_2_StateProvince')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Street_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Street_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Street_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Telephone_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Telephone_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Telephone_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_TownSuburb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_Phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address1_IsBillTo')->checkbox() ?>

    <?= $form->field($model, 'Address1_IsShipTo')->checkbox() ?>

    <?= $form->field($model, 'Billing_company_admin_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Billing_company_admin_fee_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Billing_contact')->textInput() ?>

    <?= $form->field($model, 'Billing_type')->textInput() ?>

    <?= $form->field($model, 'Business_Type')->textInput() ?>

    <?= $form->field($model, 'Category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Client_Status')->textInput() ?>

    <?= $form->field($model, 'Copy_addess')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Copy_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Created_By')->textInput() ?>

    <?= $form->field($model, 'Created_On')->textInput() ?>

    <?= $form->field($model, 'Credit_Hold')->checkbox() ?>

    <?= $form->field($model, 'Dairy_No')->textInput() ?>

    <?= $form->field($model, 'Dairy_Notes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Delivery_Directions')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Do_not_allow_Bulk_Emails')->checkbox() ?>

    <?= $form->field($model, 'Do_not_allow_Bulk_Mails')->checkbox() ?>

    <?= $form->field($model, 'Do_not_allow_Emails')->checkbox() ?>

    <?= $form->field($model, 'Do_not_allow_Faxes')->checkbox() ?>

    <?= $form->field($model, 'Do_not_allow_Mails')->checkbox() ?>

    <?= $form->field($model, 'Do_not_allow_Phone_Calls')->checkbox() ?>

    <?= $form->field($model, 'Email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Email_Address_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Email_Address_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Exchange_Rate')->textInput() ?>

    <?= $form->field($model, 'Farm_Mgr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Farm_No')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Farm_Operation')->textInput() ?>

    <?= $form->field($model, 'Feed_Days_Remaining')->textInput() ?>

    <?= $form->field($model, 'Feed_empty')->textInput() ?>

    <?= $form->field($model, 'Feed_QOH_Tonnes')->textInput() ?>

    <?= $form->field($model, 'Feed_QOH_Update')->textInput() ?>

    <?= $form->field($model, 'Feed_Rate_Kg_Day')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Herd_Notes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Herd_Size')->textInput() ?>

    <?= $form->field($model, 'Herd_Type')->textInput() ?>

    <?= $form->field($model, 'Is_Internal')->checkbox() ?>

    <?= $form->field($model, 'Is_Provider')->checkbox() ?>

    <?= $form->field($model, 'Main_Competitor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Map_Reference')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Mobile_Phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Modified_By')->textInput() ?>

    <?= $form->field($model, 'Modified_On')->textInput() ?>

    <?= $form->field($model, 'Nearest_Town')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'No_of_Employees')->textInput() ?>

    <?= $form->field($model, 'Owner')->textInput() ?>

    <?= $form->field($model, 'Parent_Region')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Payment_Terms')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Preferred_Day')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Preferred_FacilityEquipment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Property_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Status')->textInput() ?>

    <?= $form->field($model, 'Sub_Region')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Supplies_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Trading_as')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Website')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
