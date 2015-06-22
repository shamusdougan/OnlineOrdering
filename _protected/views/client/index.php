<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\clientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Clients', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Company_Name',
            'Trading_as',
            'Main_Phone',
            'TownSuburb',
            'Is_Customer',
            // 'Is_Factory',
            // 'Is_Supplier',
            // 'Credit_Hold',
            // 'Owner',
            // 'Account_Number',
            // 'Third_Party_Company',
            // 'ABN',
            // 'Account_Rating',
            // 'Address_1',
            // 'Address_1_Address_Type',
            // 'Address_1_CountryRegion',
            // 'Address_1_County',
            // 'Address_1_Fax',
            // 'Address_1_Freight_Terms',
            // 'Address_1_Latitude',
            // 'Address_1_Longitude',
            // 'Address_1_Name',
            // 'Address_1_Post_Office_Box',
            // 'Address_1_Postal_Code',
            // 'Address_1_Primary_Contact_Name',
            // 'Address_1_Shipping_Method',
            // 'Address_1_StateProvince',
            // 'Address_1_Street_1',
            // 'Address_1_Street_2',
            // 'Address_1_Street_3',
            // 'Address_1_Telephone_2',
            // 'Address_1_Telephone_3',
            // 'Address_1_UPS_Zone',
            // 'Address_1_UTC_Offset',
            // 'Address_2',
            // 'Address_2_Address_Type',
            // 'Address_2_CountryRegion',
            // 'Address_2_County',
            // 'Address_2_Fax',
            // 'Address_2_Freight_Terms',
            // 'Address_2_Latitude',
            // 'Address_2_Longitude',
            // 'Address_2_Name',
            // 'Address_2_Post_Office_Box',
            // 'Address_2_Postal_Code',
            // 'Address_2_Primary_Contact_Name',
            // 'Address_2_Shipping_Method',
            // 'Address_2_StateProvince',
            // 'Address_2_Street_1',
            // 'Address_2_Street_2',
            // 'Address_2_Street_3',
            // 'Address_2_Telephone_1',
            // 'Address_2_Telephone_2',
            // 'Address_2_Telephone_3',
            // 'Address_2_TownSuburb',
            // 'Address_2_UPS_Zone',
            // 'Address_2_UTC_Offset',
            // 'Address_Phone',
            // 'Address1_IsBillTo',
            // 'Address1_IsShipTo',
            // 'Aging_30',
            // 'Aging_30_Base',
            // 'Aging_60',
            // 'Aging_60_Base',
            // 'Aging_90',
            // 'Aging_90_Base',
            // 'Annual_Revenue',
            // 'Annual_Revenue_Base',
            // 'Beef_Notes',
            // 'Billing_company_admin_fee',
            // 'Billing_company_admin_fee_Base',
            // 'Billing_contact',
            // 'Billing_type',
            // 'Business_Type',
            // 'Category',
            // 'Classification',
            // 'Client_Status',
            // 'Copy_addess',
            // 'Copy_address',
            // 'Created_By',
            // 'Created_By_Delegate',
            // 'Created_On',
            // 'Credit_Limit',
            // 'Credit_Limit_Base',
            // 'Currency',
            // 'Customer_Size',
            // 'Dairy_No',
            // 'Dairy_Notes',
            // 'Delivery_Directions',
            // 'Description',
            // 'Do_not_allow_Bulk_Emails:email',
            // 'Do_not_allow_Bulk_Mails',
            // 'Do_not_allow_Emails:email',
            // 'Do_not_allow_Faxes',
            // 'Do_not_allow_Mails',
            // 'Do_not_allow_Phone_Calls',
            // 'Email:email',
            // 'Email_Address_2:email',
            // 'Email_Address_3:email',
            // 'Exchange_Rate',
            // 'Farm_Mgr',
            // 'Farm_No',
            // 'Farm_Operation',
            // 'Fax',
            // 'Feed_Days_Remaining',
            // 'Feed_empty',
            // 'Feed_QOH_Tonnes',
            // 'Feed_QOH_Update',
            // 'Feed_Rate_Kg_Day',
            // 'FTP_Site',
            // 'Herd_Notes',
            // 'Herd_Size',
            // 'Herd_Type',
            // 'Industry_Code',
            // 'Is_Internal',
            // 'Is_Provider',
            // 'Last_Date_Included_in_Campaign',
            // 'Main_Competitor',
            // 'Main_Product',
            // 'Map_Reference',
            // 'Market_Capitalization',
            // 'Market_Capitalization_Base',
            // 'Mobile_Phone',
            // 'Modified_By',
            // 'Modified_By_Delegate',
            // 'Modified_On',
            // 'Nearest_Town',
            // 'No_of_Employees',
            // 'Originating_Lead',
            // 'Other_Phone',
            // 'Ownership',
            // 'Parent_Company',
            // 'Parent_Region',
            // 'Payment_Terms',
            // 'Preferred_Day',
            // 'Preferred_FacilityEquipment',
            // 'Preferred_Method_of_Contact',
            // 'Preferred_Service',
            // 'Preferred_Time',
            // 'Preferred_User',
            // 'Price_List',
            // 'Primary_Contact',
            // 'Process',
            // 'Process_Stage',
            // 'Property_Name',
            // 'Record_Created_On',
            // 'Relationship_Type',
            // 'Send_Marketing_Materials',
            // 'Shares_Outstanding',
            // 'Shipping_Method',
            // 'SIC_Code',
            // 'Status',
            // 'Status_Reason',
            // 'Stock_Exchange',
            // 'Sub_Region',
            // 'Supplies_to',
            // 'Telephone_3',
            // 'Territory',
            // 'Territory_Code',
            // 'Ticker_Symbol',
            // 'Website',
            // 'Yomi_Account_Name',
            // 'z_old_Industry',
            // 'z_old_Payment_Terms',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
