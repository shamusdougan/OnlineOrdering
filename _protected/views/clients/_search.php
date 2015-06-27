<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\clientsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clients-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'Company_Name') ?>

    <?= $form->field($model, 'Account_Number') ?>

    <?= $form->field($model, 'Main_Phone') ?>

    <?= $form->field($model, 'Fax') ?>

    <?php // echo $form->field($model, 'TownSuburb') ?>

    <?php // echo $form->field($model, 'Is_Customer')->checkbox() ?>

    <?php // echo $form->field($model, 'Is_Factory')->checkbox() ?>

    <?php // echo $form->field($model, 'Is_Supplier')->checkbox() ?>

    <?php // echo $form->field($model, '3rd_Party_Company') ?>

    <?php // echo $form->field($model, 'ABN') ?>

    <?php // echo $form->field($model, 'Address_1') ?>

    <?php // echo $form->field($model, 'Address_1_Address_Type') ?>

    <?php // echo $form->field($model, 'Address_1_CountryRegion') ?>

    <?php // echo $form->field($model, 'Address_1_Postal_Code') ?>

    <?php // echo $form->field($model, 'Address_1_StateProvince') ?>

    <?php // echo $form->field($model, 'Address_1_Street_1') ?>

    <?php // echo $form->field($model, 'Address_1_Street_2') ?>

    <?php // echo $form->field($model, 'Address_1_Street_3') ?>

    <?php // echo $form->field($model, 'Address_1_Telephone_2') ?>

    <?php // echo $form->field($model, 'Address_1_Telephone_3') ?>

    <?php // echo $form->field($model, 'Address_2') ?>

    <?php // echo $form->field($model, 'Address_2_Address_Type') ?>

    <?php // echo $form->field($model, 'Address_2_CountryRegion') ?>

    <?php // echo $form->field($model, 'Address_2_Postal_Code') ?>

    <?php // echo $form->field($model, 'Address_2_StateProvince') ?>

    <?php // echo $form->field($model, 'Address_2_Street_1') ?>

    <?php // echo $form->field($model, 'Address_2_Street_2') ?>

    <?php // echo $form->field($model, 'Address_2_Street_3') ?>

    <?php // echo $form->field($model, 'Address_2_Telephone_1') ?>

    <?php // echo $form->field($model, 'Address_2_Telephone_2') ?>

    <?php // echo $form->field($model, 'Address_2_Telephone_3') ?>

    <?php // echo $form->field($model, 'Address_2_TownSuburb') ?>

    <?php // echo $form->field($model, 'Address_Phone') ?>

    <?php // echo $form->field($model, 'Address1_IsBillTo')->checkbox() ?>

    <?php // echo $form->field($model, 'Address1_IsShipTo')->checkbox() ?>

    <?php // echo $form->field($model, 'Billing_company_admin_fee') ?>

    <?php // echo $form->field($model, 'Billing_company_admin_fee_Base') ?>

    <?php // echo $form->field($model, 'Billing_contact') ?>

    <?php // echo $form->field($model, 'Billing_type') ?>

    <?php // echo $form->field($model, 'Business_Type') ?>

    <?php // echo $form->field($model, 'Category') ?>

    <?php // echo $form->field($model, 'Client_Status') ?>

    <?php // echo $form->field($model, 'Copy_addess') ?>

    <?php // echo $form->field($model, 'Copy_address') ?>

    <?php // echo $form->field($model, 'Created_By') ?>

    <?php // echo $form->field($model, 'Created_On') ?>

    <?php // echo $form->field($model, 'Credit_Hold')->checkbox() ?>

    <?php // echo $form->field($model, 'Dairy_No') ?>

    <?php // echo $form->field($model, 'Dairy_Notes') ?>

    <?php // echo $form->field($model, 'Delivery_Directions') ?>

    <?php // echo $form->field($model, 'Description') ?>

    <?php // echo $form->field($model, 'Do_not_allow_Bulk_Emails')->checkbox() ?>

    <?php // echo $form->field($model, 'Do_not_allow_Bulk_Mails')->checkbox() ?>

    <?php // echo $form->field($model, 'Do_not_allow_Emails')->checkbox() ?>

    <?php // echo $form->field($model, 'Do_not_allow_Faxes')->checkbox() ?>

    <?php // echo $form->field($model, 'Do_not_allow_Mails')->checkbox() ?>

    <?php // echo $form->field($model, 'Do_not_allow_Phone_Calls')->checkbox() ?>

    <?php // echo $form->field($model, 'Email') ?>

    <?php // echo $form->field($model, 'Email_Address_2') ?>

    <?php // echo $form->field($model, 'Email_Address_3') ?>

    <?php // echo $form->field($model, 'Exchange_Rate') ?>

    <?php // echo $form->field($model, 'Farm_Mgr') ?>

    <?php // echo $form->field($model, 'Farm_No') ?>

    <?php // echo $form->field($model, 'Farm_Operation') ?>

    <?php // echo $form->field($model, 'Feed_Days_Remaining') ?>

    <?php // echo $form->field($model, 'Feed_empty') ?>

    <?php // echo $form->field($model, 'Feed_QOH_Tonnes') ?>

    <?php // echo $form->field($model, 'Feed_QOH_Update') ?>

    <?php // echo $form->field($model, 'Feed_Rate_Kg_Day') ?>

    <?php // echo $form->field($model, 'Herd_Notes') ?>

    <?php // echo $form->field($model, 'Herd_Size') ?>

    <?php // echo $form->field($model, 'Herd_Type') ?>

    <?php // echo $form->field($model, 'Is_Internal')->checkbox() ?>

    <?php // echo $form->field($model, 'Is_Provider')->checkbox() ?>

    <?php // echo $form->field($model, 'Main_Competitor') ?>

    <?php // echo $form->field($model, 'Map_Reference') ?>

    <?php // echo $form->field($model, 'Mobile_Phone') ?>

    <?php // echo $form->field($model, 'Modified_By') ?>

    <?php // echo $form->field($model, 'Modified_On') ?>

    <?php // echo $form->field($model, 'Nearest_Town') ?>

    <?php // echo $form->field($model, 'No_of_Employees') ?>

    <?php // echo $form->field($model, 'Owner') ?>

    <?php // echo $form->field($model, 'Parent_Region') ?>

    <?php // echo $form->field($model, 'Payment_Terms') ?>

    <?php // echo $form->field($model, 'Preferred_Day') ?>

    <?php // echo $form->field($model, 'Preferred_FacilityEquipment') ?>

    <?php // echo $form->field($model, 'Property_Name') ?>

    <?php // echo $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'Sub_Region') ?>

    <?php // echo $form->field($model, 'Supplies_to') ?>

    <?php // echo $form->field($model, 'Trading_as') ?>

    <?php // echo $form->field($model, 'Website') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
