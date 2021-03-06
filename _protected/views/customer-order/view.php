<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\customerOrders */

$this->title = $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'Customer Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->Order_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->Order_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Order_ID',
            'Customer',
            'Name',
            'Mix_Type',
            'Qty_Tonnes',
            'Nearest_Town',
            'Date_Fulfilled',
            'Date_Submitted',
            'Status_Reason',
            'Anticipated_Sales',
            'Bill_To_Address',
            'Bill_to_Contact_Name',
            'Bill_To_Fax',
            'Bill_To_Phone',
            'Bill_to_Address_Name',
            'Bill_to_CountryRegion',
            'Bill_to_Postal_Code',
            'Bill_to_StateProvince',
            'Bill_to_Street_1',
            'Bill_to_Street_2',
            'Bill_to_Street_3',
            'Bill_to_TownSuburbCity',
            'Billing_company',
            'Billing_company_admin_fee',
            'Billing_company_admin_fee_Base',
            'Billing_company_purchase_order',
            'Billing_type',
            'cp',
            'Created_By',
            'Created_By_Delegate',
            'Created_On',
            'Currency',
            'Current_Cost_pT',
            'Current_Cost_pT_Base',
            'Custom_Mix',
            'Delivery_created',
            'Description',
            'Discount_',
            'Discount_pT',
            'Discount_pT_Base',
            'Discount_notation',
            'Discount_type',
            'Exchange_Rate',
            'Feed_Days_Remaining',
            'Feed_QOH_Tonnes',
            'Feed_Rate_Kg_Day',
            'Feed_Type',
            'Freight_Amount',
            'Freight_Amount_Base',
            'Freight_Terms',
            'Herd_Size',
            'Ingredient_Price_Base',
            'Ingredients_Percentage_Total',
            'IsMostRecentOrderByCustomer',
            'IsMostRecentOrderByCustomerAndProduct',
            'Last_Submitted_to_Back_Office',
            'List_Price_pT',
            'Load_Due',
            'me',
            'Modified_By',
            'Modified_By_Delegate',
            'Modified_On',
            'Opportunity',
            'Order_Discount_',
            'Order_Discount_Amount',
            'Order_Discount_Amount_Base',
            'Order_instructions',
            'Order_notification',
            'Owner',
            'Payment_Terms',
            'PntFin',
            'PntOpps',
            'Price_pT',
            'Price_pT_Base',
            'Price_List',
            'Price_Production',
            'Price_Production_Base',
            'Price_production_pT',
            'Price_production_pT_Base',
            'Price_Sub_Total',
            'Price_Sub_Total_Base',
            'Price_Total',
            'Price_Total_Base',
            'Price_Total_pT',
            'Price_Total_pT_Base',
            'Price_Transport',
            'Price_Transport_Base',
            'Price_transport_pT',
            'Price_transport_pT_Base',
            'Prices_Locked',
            'Priority',
            'Process',
            'Process_Stage',
            'Product',
            'Product_Category',
            'Product_Name',
            'Quote',
            'Record_Created_On',
            'Requested_Delivery_by',
            'Second_Customer',
            'Second_customer_Order_percent',
            'Ship_To',
            'Ship_To_Address',
            'Ship_To_Name',
            'Ship_to_Contact_Name',
            'Ship_to_CountryRegion',
            'Ship_to_Fax',
            'Ship_to_Freight_Terms',
            'Ship_to_Phone',
            'Ship_to_Postal_Code',
            'Ship_to_StateProvince',
            'Ship_to_Street_1',
            'Ship_to_Street_2',
            'Ship_to_Street_3',
            'Ship_to_TownSuburbCity',
            'Shipping_Method',
            'Source_Campaign',
            'Standard_Cost_pT',
            'Standard_Cost_pT_Base',
            'Status',
            'Storage_Unit',
            'Submitted_Status',
            'Submitted_Status_Description',
            'Total_Amount',
            'Total_Amount_Base',
            'Total_Detail_Amount',
            'Total_Detail_Amount_Base',
            'Total_Discount_Amount',
            'Total_Discount_Amount_Base',
            'Total_Line_Item_Discount_Amount',
            'Total_Line_Item_Discount_Amount_Base',
            'Total_PreFreight_Amount',
            'Total_PreFreight_Amount_Base',
            'Total_Tax',
            'Total_Tax_Base',
            'triggerSubmit',
        ],
    ]) ?>

</div>
