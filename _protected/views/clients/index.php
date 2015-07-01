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
 			'Account_Number',
            'Company_Name',
            'Main_Phone',
            'owner.fullname',
            // 'TownSuburb',
            // 'Is_Customer:boolean',
            // 'Is_Factory:boolean',
            // 'Is_Supplier:boolean',
            // '3rd_Party_Company',
            // 'ABN',
            // 'Address_1',
            // 'Address_1_Address_Type',
            // 'Address_1_CountryRegion',
            // 'Address_1_Postal_Code',
            // 'Address_1_StateProvince',
            // 'Address_1_Street_1',
            // 'Address_1_Street_2',
            // 'Address_1_Street_3',
            // 'Address_1_Telephone_2',
            // 'Address_1_Telephone_3',
            // 'Address_2',
            // 'Address_2_Address_Type',
            // 'Address_2_CountryRegion',
            // 'Address_2_Postal_Code',
            // 'Address_2_StateProvince',
            // 'Address_2_Street_1',
            // 'Address_2_Street_2',
            // 'Address_2_Street_3',
            // 'Address_2_Telephone_1',
            // 'Address_2_Telephone_2',
            // 'Address_2_Telephone_3',
            // 'Address_2_TownSuburb',
            // 'Address_Phone',
            // 'Address1_IsBillTo:boolean',
            // 'Address1_IsShipTo:boolean',
            // 'Billing_company_admin_fee',
            // 'Billing_company_admin_fee_Base',
            // 'Billing_contact',
            // 'Billing_type',
            // 'Business_Type',
            // 'Category',
            // 'Client_Status',
            // 'Copy_addess',
            // 'Copy_address',
            // 'Created_By',
            // 'Created_On',
            // 'Credit_Hold:boolean',
            // 'Dairy_No',
            // 'Dairy_Notes',
            // 'Delivery_Directions',
            // 'Description',
            // 'Do_not_allow_Bulk_Emails:boolean',
            // 'Do_not_allow_Bulk_Mails:boolean',
            // 'Do_not_allow_Emails:boolean',
            // 'Do_not_allow_Faxes:boolean',
            // 'Do_not_allow_Mails:boolean',
            // 'Do_not_allow_Phone_Calls:boolean',
            // 'Email:email',
            // 'Email_Address_2:email',
            // 'Email_Address_3:email',
            // 'Exchange_Rate',
            // 'Farm_Mgr',
            // 'Farm_No',
            // 'Farm_Operation',
            // 'Feed_Days_Remaining',
            // 'Feed_empty',
            // 'Feed_QOH_Tonnes',
            // 'Feed_QOH_Update',
            // 'Feed_Rate_Kg_Day',
            // 'Herd_Notes',
            // 'Herd_Size',
            // 'Herd_Type',
            // 'Is_Internal:boolean',
            // 'Is_Provider:boolean',
            // 'Main_Competitor',
            // 'Map_Reference',
            // 'Mobile_Phone',
            // 'Modified_By',
            // 'Modified_On',
            // 'Nearest_Town',
            // 'No_of_Employees',
            // 'Owner',
            // 'Parent_Region',
            // 'Payment_Terms',
            // 'Preferred_Day',
            // 'Preferred_FacilityEquipment',
            // 'Property_Name',
            // 'Status',
            // 'Sub_Region',
            // 'Supplies_to',
            // 'Trading_as',
            // 'Website',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
