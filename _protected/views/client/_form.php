<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\clients */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clients-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Company_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Trading_as')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Main_Phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TownSuburb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Is_Customer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Is_Factory')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Is_Supplier')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Credit_Hold')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Owner')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Account_Number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Third_Party_Company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ABN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Account_Rating')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Address_Type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_CountryRegion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_County')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Fax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Freight_Terms')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Latitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Longitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Post_Office_Box')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Postal_Code')->textInput() ?>

    <?= $form->field($model, 'Address_1_Primary_Contact_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Shipping_Method')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_StateProvince')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Street_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Street_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Street_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Telephone_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_Telephone_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_UPS_Zone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_1_UTC_Offset')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Address_Type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_CountryRegion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_County')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Fax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Freight_Terms')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Latitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Longitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Post_Office_Box')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Postal_Code')->textInput() ?>

    <?= $form->field($model, 'Address_2_Primary_Contact_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Shipping_Method')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_StateProvince')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Street_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Street_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Street_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Telephone_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Telephone_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Telephone_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_TownSuburb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_UPS_Zone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_UTC_Offset')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_Phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address1_IsBillTo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address1_IsShipTo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Aging_30')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Aging_30_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Aging_60')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Aging_60_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Aging_90')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Aging_90_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Annual_Revenue')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Annual_Revenue_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Beef_Notes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Billing_company_admin_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Billing_company_admin_fee_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Billing_contact')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Billing_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Business_Type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Classification')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Client_Status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Copy_addess')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Copy_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Created_By')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Created_By_Delegate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Created_On')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Credit_Limit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Credit_Limit_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Customer_Size')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Dairy_No')->textInput() ?>

    <?= $form->field($model, 'Dairy_Notes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Delivery_Directions')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Do_not_allow_Bulk_Emails')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Do_not_allow_Bulk_Mails')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Do_not_allow_Emails')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Do_not_allow_Faxes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Do_not_allow_Mails')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Do_not_allow_Phone_Calls')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Email_Address_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Email_Address_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Exchange_Rate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Farm_Mgr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Farm_No')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Farm_Operation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Fax')->textInput() ?>

    <?= $form->field($model, 'Feed_Days_Remaining')->textInput() ?>

    <?= $form->field($model, 'Feed_empty')->textInput() ?>

    <?= $form->field($model, 'Feed_QOH_Tonnes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Feed_QOH_Update')->textInput() ?>

    <?= $form->field($model, 'Feed_Rate_Kg_Day')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FTP_Site')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Herd_Notes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Herd_Size')->textInput() ?>

    <?= $form->field($model, 'Herd_Type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Industry_Code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Is_Internal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Is_Provider')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Last_Date_Included_in_Campaign')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Main_Competitor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Main_Product')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Map_Reference')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Market_Capitalization')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Market_Capitalization_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Mobile_Phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Modified_By')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Modified_By_Delegate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Modified_On')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Nearest_Town')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'No_of_Employees')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Originating_Lead')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Other_Phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Ownership')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Parent_Company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Parent_Region')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Payment_Terms')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Preferred_Day')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Preferred_FacilityEquipment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Preferred_Method_of_Contact')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Preferred_Service')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Preferred_Time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Preferred_User')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price_List')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Primary_Contact')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Process')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Process_Stage')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Property_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Record_Created_On')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Relationship_Type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Send_Marketing_Materials')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Shares_Outstanding')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Shipping_Method')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SIC_Code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Status_Reason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Stock_Exchange')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Sub_Region')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Supplies_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Telephone_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Territory')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Territory_Code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Ticker_Symbol')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Website')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Yomi_Account_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'z_old_Industry')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'z_old_Payment_Terms')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
