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

    <?= $form->field($model, 'Company_Name') ?>

    <?= $form->field($model, 'Trading_as') ?>

    <?= $form->field($model, 'Main_Phone') ?>

    <?= $form->field($model, 'TownSuburb') ?>

    <?= $form->field($model, 'Is_Customer') ?>

    <?php // echo $form->field($model, 'Is_Factory') ?>

    <?php // echo $form->field($model, 'Is_Supplier') ?>

    <?php // echo $form->field($model, 'Credit_Hold') ?>

    <?php // echo $form->field($model, 'Owner') ?>

    <?php // echo $form->field($model, 'Account_Number') ?>

    <?php // echo $form->field($model, 'Third_Party_Company') ?>

    <?php // echo $form->field($model, 'ABN') ?>

    <?php // echo $form->field($model, 'Account_Rating') ?>

    <?php // echo $form->field($model, 'Address_1') ?>

    <?php // echo $form->field($model, 'Address_1_Address_Type') ?>

    <?php // echo $form->field($model, 'Address_1_CountryRegion') ?>

    <?php // echo $form->field($model, 'Address_1_County') ?>

    <?php // echo $form->field($model, 'Address_1_Fax') ?>

    <?php // echo $form->field($model, 'Address_1_Freight_Terms') ?>

    <?php // echo $form->field($model, 'Address_1_Latitude') ?>

    <?php // echo $form->field($model, 'Address_1_Longitude') ?>

    <?php // echo $form->field($model, 'Address_1_Name') ?>

    <?php // echo $form->field($model, 'Address_1_Post_Office_Box') ?>

    <?php // echo $form->field($model, 'Address_1_Postal_Code') ?>

    <?php // echo $form->field($model, 'Address_1_Primary_Contact_Name') ?>

    <?php // echo $form->field($model, 'Address_1_Shipping_Method') ?>

    <?php // echo $form->field($model, 'Address_1_StateProvince') ?>

    <?php // echo $form->field($model, 'Address_1_Street_1') ?>

    <?php // echo $form->field($model, 'Address_1_Street_2') ?>

    <?php // echo $form->field($model, 'Address_1_Street_3') ?>

    <?php // echo $form->field($model, 'Address_1_Telephone_2') ?>

    <?php // echo $form->field($model, 'Address_1_Telephone_3') ?>

    <?php // echo $form->field($model, 'Address_1_UPS_Zone') ?>

    <?php // echo $form->field($model, 'Address_1_UTC_Offset') ?>

    <?php // echo $form->field($model, 'Address_2') ?>

    <?php // echo $form->field($model, 'Address_2_Address_Type') ?>

    <?php // echo $form->field($model, 'Address_2_CountryRegion') ?>

    <?php // echo $form->field($model, 'Address_2_County') ?>

    <?php // echo $form->field($model, 'Address_2_Fax') ?>

    <?php // echo $form->field($model, 'Address_2_Freight_Terms') ?>

    <?php // echo $form->field($model, 'Address_2_Latitude') ?>

    <?php // echo $form->field($model, 'Address_2_Longitude') ?>

    <?php // echo $form->field($model, 'Address_2_Name') ?>

    <?php // echo $form->field($model, 'Address_2_Post_Office_Box') ?>

    <?php // echo $form->field($model, 'Address_2_Postal_Code') ?>

    <?php // echo $form->field($model, 'Address_2_Primary_Contact_Name') ?>

    <?php // echo $form->field($model, 'Address_2_Shipping_Method') ?>

    <?php // echo $form->field($model, 'Address_2_StateProvince') ?>

    <?php // echo $form->field($model, 'Address_2_Street_1') ?>

    <?php // echo $form->field($model, 'Address_2_Street_2') ?>

    <?php // echo $form->field($model, 'Address_2_Street_3') ?>

    <?php // echo $form->field($model, 'Address_2_Telephone_1') ?>

    <?php // echo $form->field($model, 'Address_2_Telephone_2') ?>

    <?php // echo $form->field($model, 'Address_2_Telephone_3') ?>

    <?php // echo $form->field($model, 'Address_2_TownSuburb') ?>

    <?php // echo $form->field($model, 'Address_2_UPS_Zone') ?>

    <?php // echo $form->field($model, 'Address_2_UTC_Offset') ?>

    <?php // echo $form->field($model, 'Address_Phone') ?>

    <?php // echo $form->field($model, 'Address1_IsBillTo') ?>

    <?php // echo $form->field($model, 'Address1_IsShipTo') ?>

    <?php // echo $form->field($model, 'Aging_30') ?>

    <?php // echo $form->field($model, 'Aging_30_Base') ?>

    <?php // echo $form->field($model, 'Aging_60') ?>

    <?php // echo $form->field($model, 'Aging_60_Base') ?>

    <?php // echo $form->field($model, 'Aging_90') ?>

    <?php // echo $form->field($model, 'Aging_90_Base') ?>

    <?php // echo $form->field($model, 'Annual_Revenue') ?>

    <?php // echo $form->field($model, 'Annual_Revenue_Base') ?>

    <?php // echo $form->field($model, 'Beef_Notes') ?>

    <?php // echo $form->field($model, 'Billing_company_admin_fee') ?>

    <?php // echo $form->field($model, 'Billing_company_admin_fee_Base') ?>

    <?php // echo $form->field($model, 'Billing_contact') ?>

    <?php // echo $form->field($model, 'Billing_type') ?>

    <?php // echo $form->field($model, 'Business_Type') ?>

    <?php // echo $form->field($model, 'Category') ?>

    <?php // echo $form->field($model, 'Classification') ?>

    <?php // echo $form->field($model, 'Client_Status') ?>

    <?php // echo $form->field($model, 'Copy_addess') ?>

    <?php // echo $form->field($model, 'Copy_address') ?>

    <?php // echo $form->field($model, 'Created_By') ?>

    <?php // echo $form->field($model, 'Created_By_Delegate') ?>

    <?php // echo $form->field($model, 'Created_On') ?>

    <?php // echo $form->field($model, 'Credit_Limit') ?>

    <?php // echo $form->field($model, 'Credit_Limit_Base') ?>

    <?php // echo $form->field($model, 'Currency') ?>

    <?php // echo $form->field($model, 'Customer_Size') ?>

    <?php // echo $form->field($model, 'Dairy_No') ?>

    <?php // echo $form->field($model, 'Dairy_Notes') ?>

    <?php // echo $form->field($model, 'Delivery_Directions') ?>

    <?php // echo $form->field($model, 'Description') ?>

    <?php // echo $form->field($model, 'Do_not_allow_Bulk_Emails') ?>

    <?php // echo $form->field($model, 'Do_not_allow_Bulk_Mails') ?>

    <?php // echo $form->field($model, 'Do_not_allow_Emails') ?>

    <?php // echo $form->field($model, 'Do_not_allow_Faxes') ?>

    <?php // echo $form->field($model, 'Do_not_allow_Mails') ?>

    <?php // echo $form->field($model, 'Do_not_allow_Phone_Calls') ?>

    <?php // echo $form->field($model, 'Email') ?>

    <?php // echo $form->field($model, 'Email_Address_2') ?>

    <?php // echo $form->field($model, 'Email_Address_3') ?>

    <?php // echo $form->field($model, 'Exchange_Rate') ?>

    <?php // echo $form->field($model, 'Farm_Mgr') ?>

    <?php // echo $form->field($model, 'Farm_No') ?>

    <?php // echo $form->field($model, 'Farm_Operation') ?>

    <?php // echo $form->field($model, 'Fax') ?>

    <?php // echo $form->field($model, 'Feed_Days_Remaining') ?>

    <?php // echo $form->field($model, 'Feed_empty') ?>

    <?php // echo $form->field($model, 'Feed_QOH_Tonnes') ?>

    <?php // echo $form->field($model, 'Feed_QOH_Update') ?>

    <?php // echo $form->field($model, 'Feed_Rate_Kg_Day') ?>

    <?php // echo $form->field($model, 'FTP_Site') ?>

    <?php // echo $form->field($model, 'Herd_Notes') ?>

    <?php // echo $form->field($model, 'Herd_Size') ?>

    <?php // echo $form->field($model, 'Herd_Type') ?>

    <?php // echo $form->field($model, 'Industry_Code') ?>

    <?php // echo $form->field($model, 'Is_Internal') ?>

    <?php // echo $form->field($model, 'Is_Provider') ?>

    <?php // echo $form->field($model, 'Last_Date_Included_in_Campaign') ?>

    <?php // echo $form->field($model, 'Main_Competitor') ?>

    <?php // echo $form->field($model, 'Main_Product') ?>

    <?php // echo $form->field($model, 'Map_Reference') ?>

    <?php // echo $form->field($model, 'Market_Capitalization') ?>

    <?php // echo $form->field($model, 'Market_Capitalization_Base') ?>

    <?php // echo $form->field($model, 'Mobile_Phone') ?>

    <?php // echo $form->field($model, 'Modified_By') ?>

    <?php // echo $form->field($model, 'Modified_By_Delegate') ?>

    <?php // echo $form->field($model, 'Modified_On') ?>

    <?php // echo $form->field($model, 'Nearest_Town') ?>

    <?php // echo $form->field($model, 'No_of_Employees') ?>

    <?php // echo $form->field($model, 'Originating_Lead') ?>

    <?php // echo $form->field($model, 'Other_Phone') ?>

    <?php // echo $form->field($model, 'Ownership') ?>

    <?php // echo $form->field($model, 'Parent_Company') ?>

    <?php // echo $form->field($model, 'Parent_Region') ?>

    <?php // echo $form->field($model, 'Payment_Terms') ?>

    <?php // echo $form->field($model, 'Preferred_Day') ?>

    <?php // echo $form->field($model, 'Preferred_FacilityEquipment') ?>

    <?php // echo $form->field($model, 'Preferred_Method_of_Contact') ?>

    <?php // echo $form->field($model, 'Preferred_Service') ?>

    <?php // echo $form->field($model, 'Preferred_Time') ?>

    <?php // echo $form->field($model, 'Preferred_User') ?>

    <?php // echo $form->field($model, 'Price_List') ?>

    <?php // echo $form->field($model, 'Primary_Contact') ?>

    <?php // echo $form->field($model, 'Process') ?>

    <?php // echo $form->field($model, 'Process_Stage') ?>

    <?php // echo $form->field($model, 'Property_Name') ?>

    <?php // echo $form->field($model, 'Record_Created_On') ?>

    <?php // echo $form->field($model, 'Relationship_Type') ?>

    <?php // echo $form->field($model, 'Send_Marketing_Materials') ?>

    <?php // echo $form->field($model, 'Shares_Outstanding') ?>

    <?php // echo $form->field($model, 'Shipping_Method') ?>

    <?php // echo $form->field($model, 'SIC_Code') ?>

    <?php // echo $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'Status_Reason') ?>

    <?php // echo $form->field($model, 'Stock_Exchange') ?>

    <?php // echo $form->field($model, 'Sub_Region') ?>

    <?php // echo $form->field($model, 'Supplies_to') ?>

    <?php // echo $form->field($model, 'Telephone_3') ?>

    <?php // echo $form->field($model, 'Territory') ?>

    <?php // echo $form->field($model, 'Territory_Code') ?>

    <?php // echo $form->field($model, 'Ticker_Symbol') ?>

    <?php // echo $form->field($model, 'Website') ?>

    <?php // echo $form->field($model, 'Yomi_Account_Name') ?>

    <?php // echo $form->field($model, 'z_old_Industry') ?>

    <?php // echo $form->field($model, 'z_old_Payment_Terms') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
