<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\customerOrdersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-orders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Order_ID') ?>

    <?= $form->field($model, 'Customer') ?>

    <?= $form->field($model, 'Name') ?>

    <?= $form->field($model, 'Mix_Type') ?>

    <?= $form->field($model, 'Qty_Tonnes') ?>

    <?php // echo $form->field($model, 'Nearest_Town') ?>

    <?php // echo $form->field($model, 'Date_Fulfilled') ?>

    <?php // echo $form->field($model, 'Date_Submitted') ?>

    <?php // echo $form->field($model, 'Status_Reason') ?>

    <?php // echo $form->field($model, 'Anticipated_Sales') ?>

    <?php // echo $form->field($model, 'Bill_To_Address') ?>

    <?php // echo $form->field($model, 'Bill_to_Contact_Name') ?>

    <?php // echo $form->field($model, 'Bill_To_Fax') ?>

    <?php // echo $form->field($model, 'Bill_To_Phone') ?>

    <?php // echo $form->field($model, 'Bill_to_Address_Name') ?>

    <?php // echo $form->field($model, 'Bill_to_CountryRegion') ?>

    <?php // echo $form->field($model, 'Bill_to_Postal_Code') ?>

    <?php // echo $form->field($model, 'Bill_to_StateProvince') ?>

    <?php // echo $form->field($model, 'Bill_to_Street_1') ?>

    <?php // echo $form->field($model, 'Bill_to_Street_2') ?>

    <?php // echo $form->field($model, 'Bill_to_Street_3') ?>

    <?php // echo $form->field($model, 'Bill_to_TownSuburbCity') ?>

    <?php // echo $form->field($model, 'Billing_company') ?>

    <?php // echo $form->field($model, 'Billing_company_admin_fee') ?>

    <?php // echo $form->field($model, 'Billing_company_admin_fee_Base') ?>

    <?php // echo $form->field($model, 'Billing_company_purchase_order') ?>

    <?php // echo $form->field($model, 'Billing_type') ?>

    <?php // echo $form->field($model, 'cp') ?>

    <?php // echo $form->field($model, 'Created_By') ?>

    <?php // echo $form->field($model, 'Created_By_Delegate') ?>

    <?php // echo $form->field($model, 'Created_On') ?>

    <?php // echo $form->field($model, 'Currency') ?>

    <?php // echo $form->field($model, 'Current_Cost_pT') ?>

    <?php // echo $form->field($model, 'Current_Cost_pT_Base') ?>

    <?php // echo $form->field($model, 'Custom_Mix') ?>

    <?php // echo $form->field($model, 'Delivery_created') ?>

    <?php // echo $form->field($model, 'Description') ?>

    <?php // echo $form->field($model, 'Discount_') ?>

    <?php // echo $form->field($model, 'Discount_pT') ?>

    <?php // echo $form->field($model, 'Discount_pT_Base') ?>

    <?php // echo $form->field($model, 'Discount_notation') ?>

    <?php // echo $form->field($model, 'Discount_type') ?>

    <?php // echo $form->field($model, 'Exchange_Rate') ?>

    <?php // echo $form->field($model, 'Feed_Days_Remaining') ?>

    <?php // echo $form->field($model, 'Feed_QOH_Tonnes') ?>

    <?php // echo $form->field($model, 'Feed_Rate_Kg_Day') ?>

    <?php // echo $form->field($model, 'Feed_Type') ?>

    <?php // echo $form->field($model, 'Freight_Amount') ?>

    <?php // echo $form->field($model, 'Freight_Amount_Base') ?>

    <?php // echo $form->field($model, 'Freight_Terms') ?>

    <?php // echo $form->field($model, 'Herd_Size') ?>

    <?php // echo $form->field($model, 'Ingredient_Price_Base') ?>

    <?php // echo $form->field($model, 'Ingredients_Percentage_Total') ?>

    <?php // echo $form->field($model, 'IsMostRecentOrderByCustomer') ?>

    <?php // echo $form->field($model, 'IsMostRecentOrderByCustomerAndProduct') ?>

    <?php // echo $form->field($model, 'Last_Submitted_to_Back_Office') ?>

    <?php // echo $form->field($model, 'List_Price_pT') ?>

    <?php // echo $form->field($model, 'Load_Due') ?>

    <?php // echo $form->field($model, 'me') ?>

    <?php // echo $form->field($model, 'Modified_By') ?>

    <?php // echo $form->field($model, 'Modified_By_Delegate') ?>

    <?php // echo $form->field($model, 'Modified_On') ?>

    <?php // echo $form->field($model, 'Opportunity') ?>

    <?php // echo $form->field($model, 'Order_Discount_') ?>

    <?php // echo $form->field($model, 'Order_Discount_Amount') ?>

    <?php // echo $form->field($model, 'Order_Discount_Amount_Base') ?>

    <?php // echo $form->field($model, 'Order_instructions') ?>

    <?php // echo $form->field($model, 'Order_notification') ?>

    <?php // echo $form->field($model, 'Owner') ?>

    <?php // echo $form->field($model, 'Payment_Terms') ?>

    <?php // echo $form->field($model, 'PntFin') ?>

    <?php // echo $form->field($model, 'PntOpps') ?>

    <?php // echo $form->field($model, 'Price_pT') ?>

    <?php // echo $form->field($model, 'Price_pT_Base') ?>

    <?php // echo $form->field($model, 'Price_List') ?>

    <?php // echo $form->field($model, 'Price_Production') ?>

    <?php // echo $form->field($model, 'Price_Production_Base') ?>

    <?php // echo $form->field($model, 'Price_production_pT') ?>

    <?php // echo $form->field($model, 'Price_production_pT_Base') ?>

    <?php // echo $form->field($model, 'Price_Sub_Total') ?>

    <?php // echo $form->field($model, 'Price_Sub_Total_Base') ?>

    <?php // echo $form->field($model, 'Price_Total') ?>

    <?php // echo $form->field($model, 'Price_Total_Base') ?>

    <?php // echo $form->field($model, 'Price_Total_pT') ?>

    <?php // echo $form->field($model, 'Price_Total_pT_Base') ?>

    <?php // echo $form->field($model, 'Price_Transport') ?>

    <?php // echo $form->field($model, 'Price_Transport_Base') ?>

    <?php // echo $form->field($model, 'Price_transport_pT') ?>

    <?php // echo $form->field($model, 'Price_transport_pT_Base') ?>

    <?php // echo $form->field($model, 'Prices_Locked') ?>

    <?php // echo $form->field($model, 'Priority') ?>

    <?php // echo $form->field($model, 'Process') ?>

    <?php // echo $form->field($model, 'Process_Stage') ?>

    <?php // echo $form->field($model, 'Product') ?>

    <?php // echo $form->field($model, 'Product_Category') ?>

    <?php // echo $form->field($model, 'Product_Name') ?>

    <?php // echo $form->field($model, 'Quote') ?>

    <?php // echo $form->field($model, 'Record_Created_On') ?>

    <?php // echo $form->field($model, 'Requested_Delivery_by') ?>

    <?php // echo $form->field($model, 'Second_Customer') ?>

    <?php // echo $form->field($model, 'Second_customer_Order_percent') ?>

    <?php // echo $form->field($model, 'Ship_To') ?>

    <?php // echo $form->field($model, 'Ship_To_Address') ?>

    <?php // echo $form->field($model, 'Ship_To_Name') ?>

    <?php // echo $form->field($model, 'Ship_to_Contact_Name') ?>

    <?php // echo $form->field($model, 'Ship_to_CountryRegion') ?>

    <?php // echo $form->field($model, 'Ship_to_Fax') ?>

    <?php // echo $form->field($model, 'Ship_to_Freight_Terms') ?>

    <?php // echo $form->field($model, 'Ship_to_Phone') ?>

    <?php // echo $form->field($model, 'Ship_to_Postal_Code') ?>

    <?php // echo $form->field($model, 'Ship_to_StateProvince') ?>

    <?php // echo $form->field($model, 'Ship_to_Street_1') ?>

    <?php // echo $form->field($model, 'Ship_to_Street_2') ?>

    <?php // echo $form->field($model, 'Ship_to_Street_3') ?>

    <?php // echo $form->field($model, 'Ship_to_TownSuburbCity') ?>

    <?php // echo $form->field($model, 'Shipping_Method') ?>

    <?php // echo $form->field($model, 'Source_Campaign') ?>

    <?php // echo $form->field($model, 'Standard_Cost_pT') ?>

    <?php // echo $form->field($model, 'Standard_Cost_pT_Base') ?>

    <?php // echo $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'Storage_Unit') ?>

    <?php // echo $form->field($model, 'Submitted_Status') ?>

    <?php // echo $form->field($model, 'Submitted_Status_Description') ?>

    <?php // echo $form->field($model, 'Total_Amount') ?>

    <?php // echo $form->field($model, 'Total_Amount_Base') ?>

    <?php // echo $form->field($model, 'Total_Detail_Amount') ?>

    <?php // echo $form->field($model, 'Total_Detail_Amount_Base') ?>

    <?php // echo $form->field($model, 'Total_Discount_Amount') ?>

    <?php // echo $form->field($model, 'Total_Discount_Amount_Base') ?>

    <?php // echo $form->field($model, 'Total_Line_Item_Discount_Amount') ?>

    <?php // echo $form->field($model, 'Total_Line_Item_Discount_Amount_Base') ?>

    <?php // echo $form->field($model, 'Total_PreFreight_Amount') ?>

    <?php // echo $form->field($model, 'Total_PreFreight_Amount_Base') ?>

    <?php // echo $form->field($model, 'Total_Tax') ?>

    <?php // echo $form->field($model, 'Total_Tax_Base') ?>

    <?php // echo $form->field($model, 'triggerSubmit') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
