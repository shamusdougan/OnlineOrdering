<?php

use yii\helpers\Html;


use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\Typeahead;
use kartik\widgets\datePicker;


/* @var $this yii\web\View */
/* @var $model app\models\customerOrders */
/* @var $form yii\widgets\ActiveForm */
/* @var $clientlist app\models\clients*/

$this->registerJs("$('#customerorders-customer').on('change',function(){
    $.ajax({
        url: '".yii\helpers\Url::toRoute("customer-order/ajax-company-details")."',
        dataType: 'json',
        method: 'GET',
        data: {id: $(this).val()},
        success: function (data, textStatus, jqXHR) {
            $('#customerdetails-contactname').val(data.contact);
           	$('#customerdetails-phone').val(data.number);
           	$('#customerdetails-status').val(data.status);
           	$('#customerdetails-address').val(data.address);
           	$('#customerdetails-nearestTown').val(data.nearestTown);
           	$('#customerdetails-viewmore').show();
           	$('#customerdetails-readmorelink').attr('href', '".yii\helpers\Url::toRoute("clients/view?id=")."' + data.id);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('An error occured!');
            alert('Error in ajax request retriving customer details' );
        }
    });
});"); 


?>

<div class="customer-orders-form">

   

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); 
    
    
	
    //Customer Select options
    echo Form::widget([
    	'model'=>$model,
    	'form'=>$form,
    	'columns'=>1,
    	'attributes'=>[
    		'Customer' =>
    			[
    				'type' => Form::INPUT_WIDGET,
    				'widgetClass' => '\kartik\widgets\Select2',
    				'options'=>
    					[
    					'data'=>$clientList,
    					'options' => ['placeholder' => 'Select Client....']
    					],

    			],			 
      	]
    ]);
    
    //Display the Customer Information this is view only for reference
   
	
    ?>
    <fieldset id="w1_2">
    <div class='col-md-12'>
    	<label class="control-label col-md-2"></label>
    	<div class='col-md-10' >
    		<div class='col-md-4'><b>Contact:</b> <input type='text' id='customerdetails-contactname'  style='border: 0px  solid; width:170px' readonly></div>
    		<div class='col-md-4'><b>Phone: </b><input type='text' id='customerdetails-phone' readonly style='border: 0px  solid'> </div>
    		<div class='col-md-4'><b>Status:</b> <input type='text' id='customerdetails-status' style='border: 0px  solid' readonly> </div>
    	</div>
    	<label class="control-label col-md-2"></label>
    	<div class='col-md-10'>
    		<div class='col-md-10'><b>Nearest Town:</b> <input type='text' id='customerdetails-nearestTown' readonly style='border: 0px  solid; width: 500px'> </div>
    	</div>
    	<label class="control-label col-md-2"></label>
    	<div class='col-md-10'>
    		<div class='col-md-10' '><b>Address: </b><input type='text' id='customerdetails-address'  style='border: 0px  solid; width: 500px' readonly></div>
    	</div>
    	<label class="control-label col-md-2"></label>
    	<div class='col-md-10' id='customerdetails-viewmore' style='display: none'>
    		<div class='col-md-10'><a id='customerdetails-readmorelink' href='<?php echo yii\helpers\Url::toRoute("client/view?id=") ?>' target="_blank">View More Details</a></div>
    	</div>
    	<div class='col-md-12' style='height: 20px; width: 100%'></div>
    	
	</div>  	
	</fieldset>
	
	
   <?= Form::widget(
		[
		'model'=>$model,
		'form'=>$form,
	
		'columns'=>1,
		'attributes'=>
			[
			'Delivery Info' =>
				[  
				'label' => 'Delivery Info',
				'labelSpan' => 2,
				'columns' => 10,
				'attributes' =>
					[    
					'Requested_Delivery_by'=>
						[
						'type'=>Form::INPUT_WIDGET, 
						'widgetClass' => '\kartik\widgets\DatePicker',
						'options' => 
							[
							'type' => DatePicker::TYPE_COMPONENT_APPEND,
							'options' => 
							[
							'placeholder' => 'Requested Delivery By'
							],
							'pluginOptions' => 
								[
								'format' => "dd-M-yyyy",
								'todayHighlight' => true,
								]
							],
						'label' => false,
						'columnOptions'=>['colspan'=>6],
					
						],
					'Storage_Unit' => 
						[
						'type' => FORM::INPUT_TEXT,
						'options' => 
							[
							'placeholder' => 'Select Silo.....'
							],
						'columnOptions'=>['colspan'=>6],
						]
					]
				]
			]
		]) ?>

 	 <?= $form->field($model, 'Name')->textInput(['maxlength' => true]) ?>

   
    <?= $form->field($model, 'Mix_Type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Qty_Tonnes')->textInput() ?>

    <?= $form->field($model, 'Nearest_Town')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Date_Fulfilled')->textInput() ?>

    <?= $form->field($model, 'Date_Submitted')->textInput() ?>

    <?= $form->field($model, 'Status_Reason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Anticipated_Sales')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Bill_To_Address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Bill_to_Contact_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Bill_To_Fax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Bill_To_Phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Bill_to_Address_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Bill_to_CountryRegion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Bill_to_Postal_Code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Bill_to_StateProvince')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Bill_to_Street_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Bill_to_Street_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Bill_to_Street_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Bill_to_TownSuburbCity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Billing_company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Billing_company_admin_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Billing_company_admin_fee_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Billing_company_purchase_order')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Billing_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Created_By')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Created_By_Delegate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Created_On')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Current_Cost_pT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Current_Cost_pT_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Custom_Mix')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Delivery_created')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Discount_')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Discount_pT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Discount_pT_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Discount_notation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Discount_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Exchange_Rate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Feed_Days_Remaining')->textInput() ?>

    <?= $form->field($model, 'Feed_QOH_Tonnes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Feed_Rate_Kg_Day')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Feed_Type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Freight_Amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Freight_Amount_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Freight_Terms')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Herd_Size')->textInput() ?>

    <?= $form->field($model, 'Ingredient_Price_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Ingredients_Percentage_Total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IsMostRecentOrderByCustomer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IsMostRecentOrderByCustomerAndProduct')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Last_Submitted_to_Back_Office')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'List_Price_pT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Load_Due')->textInput() ?>

    <?= $form->field($model, 'me')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Modified_By')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Modified_By_Delegate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Modified_On')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Opportunity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Order_Discount_')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Order_Discount_Amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Order_Discount_Amount_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Order_instructions')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Order_notification')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Owner')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Payment_Terms')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PntFin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PntOpps')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price_pT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price_pT_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price_List')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price_Production')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price_Production_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price_production_pT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price_production_pT_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price_Sub_Total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price_Sub_Total_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price_Total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price_Total_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price_Total_pT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price_Total_pT_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price_Transport')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price_Transport_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price_transport_pT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price_transport_pT_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Prices_Locked')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Priority')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Process')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Process_Stage')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Product')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Product_Category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Product_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Quote')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Record_Created_On')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Requested_Delivery_by')->textInput() ?>

    <?= $form->field($model, 'Second_Customer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Second_customer_Order_percent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Ship_To')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Ship_To_Address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Ship_To_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Ship_to_Contact_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Ship_to_CountryRegion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Ship_to_Fax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Ship_to_Freight_Terms')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Ship_to_Phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Ship_to_Postal_Code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Ship_to_StateProvince')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Ship_to_Street_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Ship_to_Street_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Ship_to_Street_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Ship_to_TownSuburbCity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Shipping_Method')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Source_Campaign')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Standard_Cost_pT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Standard_Cost_pT_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Storage_Unit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Submitted_Status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Submitted_Status_Description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Total_Amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Total_Amount_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Total_Detail_Amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Total_Detail_Amount_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Total_Discount_Amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Total_Discount_Amount_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Total_Line_Item_Discount_Amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Total_Line_Item_Discount_Amount_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Total_PreFreight_Amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Total_PreFreight_Amount_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Total_Tax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Total_Tax_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'triggerSubmit')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
