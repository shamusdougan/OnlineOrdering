<?php
$debug = false;
use yii\helpers\Html;

use app\models\Lookup;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\Typeahead;
use kartik\datecontrol\DateControl;
use kartik\widgets\datePicker;
use kartik\widgets\DepDrop;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use webvimark\modules\UserManagement\models\User;


use yii\helpers\Url;





if(!isset($readOnly)){ $readOnly = False;}


/* @var $this yii\web\View */
/* @var $model app\models\customerOrders */
/* @var $form yii\widgets\ActiveForm */
/* @var $clientlist app\models\clients*/


/************************************************************
*
*		Javascript: page functions/calculations
*
****************************************************************/
$this->registerJs("

function getIngredientSum()
{

	var sum = 0
	$(\".ingredient_percent\").each(function() 
 		{
		if(!isNaN($(this).text()) && $(this).text().length!=0) 
			{
           	sum += parseFloat($(this).text());
       		}
		});
	$(\"#".Html::getInputId($model, 'Percent_ingredients')."\").val(sum);
	$('tfoot td:eq(2)').text(sum.toFixed(2));
	
	
	return sum;
}


function checkOverrideCost()
{
	var overrideCost = $(\"#".Html::getInputId($model, 'Price_pT_Base_override')."\").val();
	if (!isNaN(overrideCost) && overrideCost.length != 0)
		{
		return true;
		}
	else{
		return false;
	}
}

function getOverridePrice()
{
	var overrideCost = $(\"#".Html::getInputId($model, 'Price_pT_Base_override')."\").val();
	if (!isNaN(overrideCost) && overrideCost.length != 0)
		{
		return parseFloat(overrideCost);
		}
	else{
		return 0;
	}
}


function getIngredientWeightedCost()
{
	var weightedCost = 0
	$(\".weightedCost\").each(function() 
 		{
 		costString = ($(this).text()).replace('$', '');
		if(!isNaN(costString) && costString.length!=0) 
			{
           	weightedCost += parseFloat(costString);
       		}
		});
	
	$('tfoot td:eq(4)').text(weightedCost.toFixed(2));
	
	
	if(checkOverrideCost())
		{
		var overridePrice = getOverridePrice();
		$(\"#".Html::getInputId($model, 'Price_pT_Base')."-disp\").maskMoney('mask',overridePrice);	
		$(\"#".Html::getInputId($model, 'Price_pT_Base')."\").val(overridePrice);
		return overridePrice;	
		}
	
	$(\"#".Html::getInputId($model, 'Price_pT_Base')."-disp\").maskMoney('mask',weightedCost);	
	$(\"#".Html::getInputId($model, 'Price_pT_Base')."\").val(weightedCost);
	return weightedCost;
}

function updateOrderCosts()
{
	
	var weightedCost = getIngredientWeightedCost();
	var productionCost = $(\"#".Html::getInputId($model, 'Price_production_pT')."\").val();
	var transportCost = $(\"#".Html::getInputId($model, 'Price_transport_pT')."\").val();
	var basePricePerTone = $(\"#".Html::getInputId($model, 'Price_Sub_Total')."\").val();
	var baseDiscountPerTonne = $(\"#".Html::getInputId($model, 'Discount_pT')."\").val();
	var OrderQty =  $(\"#".Html::getInputId($model, 'Qty_Tonnes')."\").val();
	

	
	if(!isNaN(productionCost) && productionCost.length!=0) 
		{
		productionCost = parseFloat(productionCost);
		}
	else{
		productionCost = 0;
		}
		
	if(!isNaN(transportCost) && transportCost.length!=0) 
		{
		transportCost = parseFloat(transportCost);
		}
	else{
		transportCost = 0;
		}
	
	if(!isNaN(basePricePerTone) && basePricePerTone.length!=0) 
		{
		basePricePerTone = parseFloat(basePricePerTone);
		}
	else{
		basePricePerTone = 0;
		}
		
	if(!isNaN(baseDiscountPerTonne) && baseDiscountPerTonne.length!=0) 
		{
		baseDiscountPerTonne = parseFloat(baseDiscountPerTonne);
		}
	else{
		baseDiscountPerTonne = 0;
		}
	
	if(!isNaN(OrderQty) && OrderQty.length!=0) 
		{
		OrderQty = parseFloat(OrderQty);
		}
	else{
		OrderQty = 0;
		}
	
	
	var basePricePerTone = weightedCost + (productionCost) + (transportCost);
	
	if(basePricePerTone == 0)
		{
		var discountPercent = 0;
		}
	else{
		var discountPercent = 100 * (baseDiscountPerTonne / basePricePerTone);
		}
	
	var totalPricePerTon = basePricePerTone - baseDiscountPerTonne;
	//alert(weightedCost + '+' + productionCost + '+' + transportCost + '=' + basePricePerTon);
	//alert(discountPercent + '= 100 * (' + baseDiscountPerTonne + ' / ' + basePricePerTon +')');
	
	$(\"#".Html::getInputId($model, 'Price_Sub_Total')."\").val(basePricePerTone);
	$(\"#".Html::getInputId($model, 'Price_Sub_Total')."-disp\").maskMoney('mask',basePricePerTone);	
	$(\"#".Html::getInputId($model, 'Discount_Percent')."\").val(discountPercent.toFixed(2));
	
	if(checkOverrideCost())
		{
		$(\"#override\").show();
		}
	else{
		$(\"#override\").hide();
		}
		
		
	$(\"#orderdetails-basePricePT\").val(weightedCost.toFixed(2));
	$(\"#orderdetails-productionPricePT\").val(productionCost.toFixed(2));
	$(\"#orderdetails-transportPricePT\").val(transportCost.toFixed(2));
	$(\"#orderdetails-discountPricePT\").val(baseDiscountPerTonne.toFixed(2) + ' (' + discountPercent.toFixed(2) + '%)');
	$(\"#orderdetails-subPricePT\").val(totalPricePerTon.toFixed(2));
	
	var totalOrderCost = OrderQty * totalPricePerTon;
	$(\"#orderdetails-totalPrice\").val(totalOrderCost.toFixed(2));
	
	$(\"#".Html::getInputId($model, 'Price_Total')."\").val(totalOrderCost.toFixed(2));    		
		    		
		
		    		
	
	return basePricePerTone;
}



function updateOrderDetails()
{
	var orderStatus = $(\"#".Html::getInputId($model, 'Status')."\").val();
	var orderCreatedBy = $(\"#".Html::getInputId($model, 'Created_By')."\").val();
	
	$('#orderdetails-status').val('".Lookup::item($model->Status, "ORDER_STATUS")."');
	$('#orderdetails-createdby').val('".$model->createdByUser->fullname."');
	
	 $.ajax({
        url: '".yii\helpers\Url::toRoute("customer-order/ajax-company-details")."',
        dataType: 'json',
        method: 'GET',
        data: {id: $('#customerorders-customer_id').val()},
        success: function (data, textStatus, jqXHR) {
           	$('#customerdetails-address').val(data.address);
           	$('#customerdetails-nearestTown').val(data.nearestTown);
           	$('#customerdetails-viewmore').show();
           	$('#customerdetails-readmorelink').attr('href', '".yii\helpers\Url::toRoute("clients/update?id=")."' + data.id);
           	
           	Feed_Rate_Input = $('#".Html::getInputId($model, 'Feed_Rate_Kg_Day')."');
           	Herd_Size_Input = $('#".Html::getInputId($model, 'Herd_Size')."');
           	QOH_input = $('#".Html::getInputId($model, 'Feed_QOH_Tonnes')."');
           	if(Feed_Rate_Input.val() == '' || Feed_Rate_Input.val() == null)
           		{
				Herd_Size_Input.val(data.Herd_Size);
				}
				
			if(Feed_Rate_Input.val() == '' || Feed_Rate_Input.val() == null)
				{
				Feed_Rate_Input.val(data.Feed_Rate_Kg_Day);
				}
			if(QOH_input.val() == '' || QOH_input.val() == null)
				{
				QOH_input.val(data.Feed_QOH_Tonnes);
				}	
          	updateFeedDetails();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('An error occured!');
            alert('Error in ajax request retriving customer details' );
        }
    });
	
	
}

function updateFeedDetails()
{

	var Herd_Size = $('#".Html::getInputId($model, 'Herd_Size')."').val();	
	var Feed_Rate =	$('#".Html::getInputId($model, 'Feed_Rate_Kg_Day')."').val();
	var Feed_QOH = $('#".Html::getInputId($model, 'Feed_QOH_Tonnes')."').val();
	var Feed_Days_Remaining = $('#".Html::getInputId($model, 'Feed_Days_Remaining')."');
	var OrderQty =  $(\"#".Html::getInputId($model, 'Qty_Tonnes')."\").val();
   
   	if(!isNaN(Herd_Size) && Herd_Size.length!=0) 
		{
		Herd_Size = parseFloat(Herd_Size);
		}
	else{
		Herd_Size = 0;
		}
   
    if(!isNaN(Feed_Rate) && Feed_Rate.length!=0) 
		{
		Feed_Rate = parseFloat(Feed_Rate);
		}
	else{
		Feed_Rate = 0;
		}
   
   	if(!isNaN(Feed_QOH) && Feed_QOH.length!=0) 
		{
		Feed_QOH = parseFloat(Feed_QOH);
		}
	else{
		Feed_QOH = 0;
		}
     
     if(!isNaN(OrderQty) && OrderQty.length!=0) 
		{
		OrderQty = parseFloat(OrderQty);
		}
	else{
		OrderQty = 0;
		}
	
	if(Herd_Size == 0 || Feed_Rate == 0)	
		{
		Feed_Days_Remaining.val(0);	
		}
	else{
		Feed_Days_Remaining.val(Math.floor((Feed_QOH + OrderQty) / (Herd_Size * Feed_Rate /1000)) );	
		}
     
          	
}




");




/**********************************************************
* 
*  Javascript event handlers
* 
***********************************************************/


//This handles the clicking of the refresh button on the grid
$this->registerJs(
    "$(document).on('click', \"#refresh_ingredients_grid\", function() 
    	{
    	$.pjax.reload({container:\"#order_ingredient_grid\"});
		});"
   );	



//This handles the change of customer details
$this->registerJs("$('#customerorders-customer_id').on('change',function(){
	updateOrderDetails();
});"); 


/*
$this->registerJs("$('#".Html::getInputId($model, 'Storage_Unit')."').on('change',function(){
	
	var storage_id = $(this).val();
	$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("customer-order/ajax-get-storage-delivery-instructions")."',
		data: {storage_id: storage_id}, 
		success: function (data, textStatus, jqXHR) 
			{
			$('#".Html::getInputId($model, 'Order_instructions')."').val(data);
			},
        error: function (jqXHR, textStatus, errorThrown) 
        	{
            console.log('An error occured!');
            alert('Error in ajax request' );
        	}
        });
});"); 
*/


//Action on adding an ingredient
$this->registerJs(
    "$(document).on('click', '#add_ingredient_button', function() 
    	{
    	var percentAllocated = getIngredientSum();
    	productType = $(\"#".Html::getInputId($model, 'Product_Category')."\").val();
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("customer-order/ajax-add-ingredient")."',
		data: {id: 'new', order_id: ".$model->id.", productType: productType, total: percentAllocated},
		success: function (data, textStatus, jqXHR) 
			{
			$('#activity-modal').modal();
			$('.modal-body').html(data);
			},
        error: function (jqXHR, textStatus, errorThrown) 
        	{
            console.log('An error occured!');
            alert('Error in ajax request' );
        	}
		});
	});"
   );


//action on clicking the ingredient percentage amount link in the grid
$this->registerJs(
    "$(document).on('click', \".sap_edit_ingredient_link\", function() 
    	{
    	var ingredientID = ($(this).attr('ingredientId'));
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("customer-order/ajax-update-ingredient")."',
		data: {id: ingredientID},
		success: function (data, textStatus, jqXHR) 
			{
			$('#activity-modal').modal();
			$('.modal-body').html(data);
			},
        error: function (jqXHR, textStatus, errorThrown) 
        	{
            console.log('An error occured!');
            alert('Error in ajax request' );
        	}
		});
		
		
	});"
   );




//action on submiting the ingredient add form
$this->registerJs("
$('body').on('beforeSubmit', 'form#ingredient_add', function () {
     var form = $(this);
     // return false if form still have some validation errors
     if (form.find('.has-error').length) {
          return false;
     }
     // submit form
     $.ajax({
          url: form.attr('action'),
          type: 'post',
          data: form.serialize(),
          success: function (response) 
          		{
          		$('#activity-modal').modal('hide');
          		
          		$.pjax.reload({container:'#order_ingredient_grid'});
				}
		  });	
     return false;
});
");	
	


//action of deleting an ingredient
$this->registerJs(
    "$(document).on('click', '.order_ingredient_delete', function()  
    {
  	$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("customer-orders-ingredients/ajax-delete")."',
		data: {id: $(this).closest('tr').data('key')},
		success: function (data, textStatus, jqXHR) 
			{
			var url = '".yii\helpers\Url::toRoute("customer-order/update")."&id=".$model->id."';
          	$.pjax.reload({container:'#order_ingredient_grid'});
			},
        error: function (jqXHR, textStatus, errorThrown) 
        	{
            console.log('An error occured!');
            alert('Error in ajax request' );
        	}
		});
   	});"
   );
	
//activate the discount fields when a discount type is selected	
$this->registerJs("
	$('#".Html::getInputId($model, 'Discount_type')."').on('change', function()
		{
		if(this.value > 1)
			{
			$('#".Html::getInputId($model, 'Discount_pT')."').prop('readonly', false);
			$('#".Html::getInputId($model, 'Discount_notation')."').prop('readonly', false);
			}
		else{
			$('#".Html::getInputId($model, 'Discount_pT')."').prop('readonly', true);
			$(\"#".Html::getInputId($model, 'Discount_pT')."\").val(0);
			$(\"#".Html::getInputId($model, 'Discount_Percent')."\").val(0);
			$('#".Html::getInputId($model, 'Discount_notation')."').prop('readonly', true);
			
			}
		});
	");
	
//when the grid has been updated also update the other fields
$this->registerJs("
$(document).on('pjax:end', function() {
   getIngredientSum();
   updateOrderCosts();
   updateOrderDetails();
    });
");


//recalculates the sub total price per ton of the ingredients
$this->registerJs("
	$('#".Html::getInputId($model, 'Price_pT_Base_override')."').on('change', function()
		{
			updateOrderCosts();
		});
	$('#".Html::getInputId($model, 'Price_production_pT')."').on('change', function()
		{
			updateOrderCosts();
		});
	$('#".Html::getInputId($model, 'Price_transport_pT')."').on('change', function()
		{
			updateOrderCosts();
		});	

	$('#".Html::getInputId($model, 'Discount_pT')."').on('change', function()
		{
			updateOrderCosts();
		});	
	
	$('#".Html::getInputId($model, 'Price_Sub_Total')."').on('change', function()
		{
			updateOrderCosts();
		});	
		
	$('#".Html::getInputId($model, 'Qty_Tonnes')."').on('change', function()
		{
		updateOrderCosts();
		updateFeedDetails();
		});	
		
	$('#".Html::getInputId($model, 'Herd_Size')."').on('change', function()
		{
		updateFeedDetails();
		});		
	
	$('#".Html::getInputId($model, 'Feed_Rate_Kg_Day')."').on('change', function()
		{
		updateFeedDetails();
		});		
		
	$('#".Html::getInputId($model, 'Feed_QOH_Tonnes')."').on('change', function()
		{
		updateFeedDetails();
		});	
	
			
	
");

//Load the initial order data to the right hand Side
$this->registerJs("

$( document ).ready(function() {
    updateOrderDetails();
    updateOrderCosts();
	getIngredientSum();
	
});

");




$this->registerJs("$('.sap_print').on('click',function(){
	
	var windowSizeArray = [ 'width=200,height=200',
                            'width=300,height=400,scrollbars=yes' ];

	var url = '".yii\helpers\Url::toRoute(["customer-order/print", 'id' => $model->id])."';
    var windowName = 'Weigh Bridge Ticket';
    var windowSize = windowSizeArray[$(this).attr('rel')];

    window.open(url, windowName, windowSize);

   

	
	});
");

?>

<div class="customer-orders-form">
		<div class='customer-orders-form-pricing'>
			<fieldset>
		    
		    		<div class='order_info'>
		    			<b>Order Status:</b> <input type='text' id='orderdetails-status' class='infoInput' readonly> 
		    			<b>Created By: </b><input type='text' id='orderdetails-createdby' readonly class='infoInput'> 
		    		</div>
		       		<div class='order_info'><b>Nearest Town:</b> <input type='text' id='customerdetails-nearestTown' readonly class='infoInputLarge'> </div>
		    		<div class='order_info'><b>Address: </b><input type='text' id='customerdetails-address'  class='infoInputLarge' readonly></div>
		    
		
		    	<div class='order_info' id='customerdetails-viewmore' style='display: none'>
		    		<a id='customerdetails-readmorelink' href='<?php echo yii\helpers\Url::toRoute("client/view?id=") ?>' target="_blank">View Customer Details</a>
		    	</div>
		    	<hr>
		    	<p>Order Pricing Details</p>
		    	<table>
		    		<tr>
		    			<td width='200px'><b>Base Price P/T:</b><span id='override' style='color:red;'> (Manual) </span></td>
		    			<td>$<input type='text' style='text-align: right;' id='orderdetails-basePricePT' class='infoInput' readonly></td>
		    		</tr>
		    		<tr>
		    			<td width='150px'><b>Production Price P/T:</b></td>
		    			<td>$<input type='text' style='text-align: right;' id='orderdetails-productionPricePT' class='infoInput' readonly></td>
		    		</tr>
		    		<tr>
		    			<td width='150px'><b>Transport Price P/T:</b></td>
		    			<td>$<input type='text' style='text-align: right;' id='orderdetails-transportPricePT' class='infoInput' readonly></td>
		    		</tr>
		    			<tr>
		    			<td width='150px'><b>Discount Price P/T:</b></td>
		    			<td>-$<input type='text' style='text-align: right;' id='orderdetails-discountPricePT' class='infoInput' readonly></td>
		    		</tr>
		   			<tr>
		    			<td width='150px'><b>Overall Price P/T:</b></td>
		    			<td style='border-top: 1px solid ' >$<input type='text'  style='text-align: right;' id='orderdetails-subPricePT' class='infoInput' readonly></td>
		    		</tr>
		    	</table>
		    	<hr>
		    	<table>
		    		<tr>
		    			<td width='200px'><b>Total Order Value: </b></td>
		    			<td>$<input type='text'  style='text-align: right;' id='orderdetails-totalPrice' class='infoInput' readonly></td>
		    		</tr>
		    	</table>
		
				
			</fieldset>
		</div>
		<div class='customer-orders-form-main'>
   		
		<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'customer-order-form']);
		
		
		 ?>
   
		  	 <?= $form->errorSummary($model); ?>  
		<?php	
		
			
		
		
		    //Customer Select options
		    echo Form::widget([
		    	'model'=>$model,
		    	'form'=>$form,
		    	'columns'=>1,
		    	'attributes'=>[
		    		'Customer_id' =>
		    			[
		    				'type' => Form::INPUT_WIDGET,
		    				'widgetClass' => '\kartik\widgets\Select2',
		    				'options'=>
		    					[
		    					'data'=>$clientList,
		    					'options' => ['placeholder' => 'Select Client....', 'selected' => null,],
		    					'disabled' => $readOnly,
		    					],
							
		    			],			 
		      	]
		    ]);
		    
		    //Display the Customer Information this is view only for reference
		   
			
		    ?>
		  
			
			
		   <?= Form::widget(
				[
				'model'=>$model,
				'form'=>$form,
			
				'columns'=>2,
				'attributes' =>
					[    
					'Requested_Delivery_by'=>
						[
						'type'=>Form::INPUT_WIDGET, 
						'widgetClass' => DateControl::classname(),
						'options' => 
							[
							'type'=>DateControl::FORMAT_DATE,
							'disabled' => $readOnly,
							'options' =>
								[
								'type' => DatePicker::TYPE_COMPONENT_APPEND,
								//'placeholder' => "Requested Delivery Date...",
								'pluginOptions' =>
									[
									'autoclose' => true,
									'todayHighlight' => true,
									'startDate' => date("d M Y"),
									]
								]
							],

					
						],
					'Storage_Unit' => 
						[
						'type' => FORM::INPUT_WIDGET,
						'widgetClass' => DepDrop::classname(), 
					
						'options'=>[
							'disabled' => $readOnly,
							'pluginOptions'=>
								[
								'placeholder'=>'Select Storage Location.....',
								'depends'=>[Html::getInputId($model, 'Customer_id')],
								'url'=>yii\helpers\Url::toRoute('/customer-order/ajax-storage-details'),
								'emptyMsg' => 'No Storage Available',
								'initialize'=>false,
								],
							'data' => $storageList,
							],
						],
					'Order_instructions' =>
						[
						'type' => FORM::INPUT_TEXTAREA,
						'columnOptions'=>['colspan'=>2],
						'options' =>
							[
							'disabled' => $readOnly,
							],
						
						],
					'verify_notes' =>
						[
						'type' => FORM::INPUT_CHECKBOX,
						'options' =>
							[
							'disabled' => $readOnly,
							],
						]
					]
				])
				
				
				
				?><br>
				
		<div class='customer_order_subheading'>Herd Details</div>	
			<?= Form::widget(
				[
				'model'=>$model,
				'form'=>$form,
			
				'columns'=>4,
				'attributes' => 
					[
					'Feed_QOH_Tonnes' =>
						[
						'type' => FORM::INPUT_TEXT,
						'options' =>
							[
							'disabled' => $readOnly,
							],
						],
					'Herd_Size' =>
						[
						'type' => FORM::INPUT_TEXT,
						'options' =>
							[
							'disabled' => $readOnly,
							],
						],
					'Feed_Rate_Kg_Day' =>
						[
						'type' => FORM::INPUT_TEXT,
						'options' =>
							[
							'disabled' => $readOnly,
							],
						],
					'Feed_Days_Remaining' =>
						[
						'type' => FORM::INPUT_TEXT,
						'options' => 
							[
							'readOnly' => true,
							]
						],
					]
				]);
				?>
	
		<div class='customer_order_subheading'>Order Details</div>
		
		
		
			<?= Form::widget(
				[
				'model'=>$model,
				'form'=>$form,
			
				'columns'=>6,
				'attributes' => 
					[
					'Qty_Tonnes' => 
						[
						'type' => FORM::INPUT_TEXT,
						'columnOptions'=>['colspan'=>2],
						'options' => 
							[
							'disabled' => $readOnly,
							]
						],
					'Product_Category' => 
						[
						'type' => FORM::INPUT_DROPDOWN_LIST,
						'items' => Lookup::items("ORDER_CATEGORY"),
						'columnOptions'=>['colspan'=>2],
						'options' => 
							[
							'disabled' => $readOnly,
							]
						],
					
					
					],
					
				]);
			echo   $form->field($model, 'Percent_ingredients', ['template' => '{input}'])->hiddenInput()->label(false);	
			
			
			
		    $gridColumns = 
		    	[
		    		'product.Product_ID',
			    	'product.Name',
			    	[
						'attribute' => 'Percent_ingredients',
						'label' => 'Ingredient Percent',
        				'pageSummary'=>true,
						'format'=>'raw',
						'hAlign'=>'right',
						'value'=>function ($model) use ($readOnly) {
        					//return $model->ingredient_percent;
        					if($readOnly)
        						{
								return  "<span class='ingredient_percent'>".$model->ingredient_percent."</span>";
								}
							else{
								return "<a class='sap_edit_ingredient_link' ingredientId='".$model->id."'><span class='ingredient_percent'>" . $model->ingredient_percent . '</span></a>';	
								}
        					
    						},
					],
					[
			    		'attribute' => 'price_pT',
			    		'contentOptions' => ['class' => 'pricePerTon'],
			    		'hAlign'=>'right',
			    	],
					[
						'attribute' => 'WeightedCost',
						'hAlign'=>'right',
						'value'=>function ($model) {
        					//return $model->ingredient_percent;
							return  '$'.number_format($model->WeightedCost, 2);
    						},
						'contentOptions' => ['class' => 'weightedCost'],
						'pageSummary' => True,
					],
					//'created_on',
					//'modified_on',
			    	[
			    	'class' => '\kartik\grid\ActionColumn',
			    	'template' => '{delete}',
			    	'hidden' => $readOnly,
					'buttons' =>
						[
						'delete' => function ($url, $model, $key) 
	   						{
           					return Html::a('<span class="glyphicon glyphicon-remove"></span>','#gridTop', 
            					[
                				'class' => 'order_ingredient_delete',
                				'title' => 'Delete',
                				'data-pjax' => '0',
              					]);
							},
						]
			    	
			    	
			    	]
		    	];
		    
		    echo "<A Href='#gridTop' ></A>";
		    echo GridView::widget(
				[
				'id' => 'ingredients',
				'panel'=>[
		        		'type'=>GridView::TYPE_PRIMARY,
		        		'heading'=>"Order Ingredients",
		   		 ],
				'headerRowOptions'=>['class'=>'kartik-sheet-style'],
				'toolbar'=> 
					[
						['content'=>
							($readOnly ? ' ' : Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'Add Product', 'id' => 'add_ingredient_button', 'class'=>'btn btn-success'])). ' '.
							Html::button('<i class="glyphicon glyphicon-repeat"></i>', ['type'=>'button', 'title'=>'Refresh', 'id' => 'refresh_ingredients_grid', 'class'=>'btn btn-success'])
						],
					],
				'dataProvider'=> new yii\data\ActiveDataProvider(['query' => $model->getIngredients()]),
				//'filterModel'=>$searchModel,
				'columns'=>$gridColumns,
				'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
				'headerRowOptions'=>['class'=>'kartik-sheet-style'],
				'filterRowOptions'=>['class'=>'kartik-sheet-style'],
				'pjax'=>true, 
				'pjaxSettings' =>
					[
					'neverTimeout'=>true,
					'options' =>['id' => 'order_ingredient_grid'],
					
					],
		 		'export' => false,
		 		'showPageSummary' => true,
				]);
		    ?>
			
		<? if (User::hasPermission('forceOrderBasePrice') || $model->Price_pT_Base_override > 0) { ?>
			
			<div class='customer_order_subheading'>Manually Set Product Base Price</div>
			<?= Form::widget(
				[
				'model'=>$model,
				'form'=>$form,
			
				'columns'=>1,
				'attributes' => 
					[
					'Price_pT_Base_override' => 
						[
						'type' => FORM::INPUT_TEXT,
						'columnOptions'=>['colspan'=>2],
						'label' => false,
						'fieldConfig' => ['addon' => ['prepend' => ['content'=>'$']]],
						'options' => 
							[
							'disabled' => (!User::hasPermission('forceOrderBasePrice') || $readOnly),
							]
						],
					],
				]); ?>
		<? } ?>
		
		
		
		    
		  <div class='customer_order_subheading'>Pricing Information</div>	
		
		<?= Form::widget(
				[
				'model'=>$model,
				'form'=>$form,
			
				'columns'=>3,
				'attributes' => 
					[
					'Price_pT_Base' => 
						[
						'type'=>Form::INPUT_WIDGET, 
						'widgetClass' => '\kartik\money\MaskMoney',
						
						'options' => ['disabled' => true],
						],
					'Price_production_pT' => 
						[
						'type'=>Form::INPUT_TEXT, 
						'fieldConfig' => ['addon' => ['prepend' => ['content'=>'$']]],
						'options' => 
							[
							'readonly' => $readOnly,
							],
						],
					'Price_transport_pT' =>
						[
						'type'=>Form::INPUT_TEXT, 
						'fieldConfig' => ['addon' => ['prepend' => ['content'=>'$']]],
						'options' => ['readonly' => $readOnly],
						],
					'Price_Sub_Total' =>
						[
						'type'=>Form::INPUT_WIDGET, 
						'widgetClass' => '\kartik\money\MaskMoney',
						
						'options' => ['disabled' => true],
						]
					],
					
				]); ?>
		
		<div class='customer_order_subheading'>Discounts</div>	
		
			<?= Form::widget(
				[
				'model'=>$model,
				'form'=>$form,
				'columns'=>6,
				'attributes' => 
					[
					'Discount_type' => 
						[
						'type' => FORM::INPUT_DROPDOWN_LIST,
						'items' => Lookup::items("DISCOUNT_TYPE"),
						'columnOptions'=>['colspan'=>2],
						'options' => ['disabled' => $readOnly],
						],
					'Discount_pT' =>
						[
						'type' => FORM::INPUT_TEXT,
						'columnOptions'=>['colspan'=>2],
						'options' => ['readonly' => ($model->Discount_type > 1 ? False : True)],
						],
					'Discount_Percent' => 
						[
						'type' => FORM::INPUT_TEXT,
						'columnOptions'=>['colspan'=>2],
						'options' => ['readonly' => true],
						],
					'Discount_notation' =>
						[
						'type' => FORM::INPUT_TEXTAREA,
						'columnOptions'=>['colspan'=>6],
						'options' => ['readonly' => ($model->Discount_type > 1 ? False : True)],
						]
					],
					
				]);	?>		  
		    
		    
		    
		    <?php
				if($debug)
					{
					echo $form->field($model, 'Order_ID')->textInput();	
					echo $form->field($model, 'Status')->textInput();	
					echo $form->field($model, 'Created_By')->textInput();	
					echo $form->field($model, 'Price_Total')->textInput();
					}
				else{
					echo $form->field($model, 'Order_ID')->hiddenInput()->label(false) ;
					echo $form->field($model, 'Status')->hiddenInput()->label(false);	
					echo $form->field($model, 'Created_By')->hiddenInput()->label(false);	
					echo $form->field($model, 'Price_Total')->hiddenInput()->label(false);	
					}
			
		    ?>
		    
    

		
			

	<?php ActiveForm::end(); ?>
	



	
	
	
</div>
<div>
	<?php		
		Modal::begin([
		    'id' => 'activity-modal',
		    'header' => '<h4 class="modal-title">Add Product</h4>',
		    'size' => 'modal-lg',
		    'options' =>
		    	[
				'tabindex' => false,
				]

		]);		?>


		<div id="modal_content">dd</div>

	<?php Modal::end(); ?>
	
</div>




