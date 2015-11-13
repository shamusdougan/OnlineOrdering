<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\datePicker;
use kartik\widgets\select2;
use kartik\widgets\DepDrop;
use app\models\Trucks;
use app\models\DeliveryLoad;
use yii\helpers\Url;
use yii\bootstrap\Modal;



	
/*	model - Delivery Object
*	order - Customeroder
*  
*/	

if(!isset($readOnly)){ $readOnly = False;}
if(!isset($truckList)){ $truckList = array();}




/**
* 
* Java script functions
* 
* 
*/

//Used to initalize the tooltips in the form
$this->registerJs("$(function () { 
    $(\"[data-toggle='tooltip']\").tooltip(); 
	});
");

$this->registerJs("
	$( document ).ready(function() {
    	updateOrderRemaining();	
 
		});
	");
 

/*************************************************************
* 
* Page Operation Functions
* 
*************************************************************/


$this->registerJs("

function refreshTrailers(update_target_delivery_load, update_trailer_slot_num)
	{
	var order_id = $(\"#".Html::getInputId($model, 'order_id')."\").val();		
	var requestedDate = $('#".Html::getInputId($model, 'delivery_on')."').val();
		
	$('.delivery-load-form').each(function() 
		{
		target_delivery_load = $(this).attr('delivery_count');
		
		if(update_target_delivery_load == 0 || update_target_delivery_load == target_delivery_load)
			{
			
			truck_id = $(this).find('.truck_details:first').attr('truck_id');
			truck_max_trailers = parseFloat($(this).find('.truck_details:first').attr('truck_max_trailers'));
			trailer1_id = $(this).find('.truck_details:first').attr('trailer1_id');
			trailer2_id = $(this).find('.truck_details:first').attr('trailer2_id');
			delivery_run_num = $(this).find('.truck_details:first').attr('delivery_run_num');
			delivery_load_id = $(this).find('.truck_details:first').attr('delivery_load_id');

			
			
			target = $('#delivery_count_' + target_delivery_load + ' > .delivery-load-trailer1');
			if(update_trailer_slot_num == 0 || update_trailer_slot_num == 1)
				{
				getTrailerRender(trailer1_id, delivery_run_num, requestedDate, target, target_delivery_load, 1, delivery_load_id);		
				}
		 	
		 	if(update_trailer_slot_num == 0 || update_trailer_slot_num == 2)
		 		{
				//If the truck can only use 1 trailer disable the second slot
			 	target = $('#delivery_count_' + target_delivery_load + ' > .delivery-load-trailer2');
			 
			 	
			 	if(truck_max_trailers < 2)
			 		{
					target.html('<div class=\"trailer_slot_disabled\"></div>');
					}
			 	else{
					getTrailerRender(trailer2_id, delivery_run_num, requestedDate, target, target_delivery_load, 2, delivery_load_id);
					}		
				}
			}
		});	
		
		
		
	}


function getTrailerRender(trailer_id, delivery_run_num, requestedDate, target, target_delivery_load, trailer_slot_num, delivery_load_id)
	{
		
		
		$.ajax
	  		({
	  		url: '".yii\helpers\Url::toRoute("delivery/ajax-get-trailer")."',
			data: {trailer_id: trailer_id, delivery_run_num: delivery_run_num, requestedDate: requestedDate, target_delivery_load: target_delivery_load, trailer_slot_num: trailer_slot_num, delivery_load_id: delivery_load_id},
			success: function (data, textStatus, jqXHR) 
				{
				target.html(data);;
				},
	        error: function (jqXHR, textStatus, errorThrown) 
	        	{
	            console.log('An error occured!');
	            alert('Error in ajax request' );
	        	}
			});
	}



");

/**********************************************************
* 
* Delivery Load Functions
* 
* 
**********************************************************/

$this->registerJs("

function  clearAllLoads()
	{
		$('#delivery_load_section').html('');
	}


");


$this->registerJs("$('.add_delivery_load').click(function(event)
	{
		event.preventDefault(); 
		
		var requestedDate = $('#".Html::getInputId($model, 'delivery_on')."').val();
		
		if(requestedDate == ''){
			alert('Please select a Date for the delivery first');
			return;
		}
		
		var last_delivery_count = 0;
		$('.delivery-load-form').each(function() 
			{
			last_delivery_count = $(this).attr('delivery_count');
			});
		next_delivery_count = parseFloat(last_delivery_count) + 1;
				
		$.ajax
		  		({
		  		url: '".yii\helpers\Url::toRoute("delivery/ajax-add-delivery-load")."',
				data: {deliveryCount: next_delivery_count, requestedDate: requestedDate},
				success: function (data, textStatus, jqXHR) 
					{
					$('#delivery_load_section').append(data);
					},
		        error: function (jqXHR, textStatus, errorThrown) 
		        	{
		            console.log('An error occured!');
		            alert('Error in ajax request' );
		        	}
				});
		
	});
	");




$this->registerJs("$(document).on('click', '.remove_delivery_load', function() 
	{	
		delivery_count = $(this).attr('delivery_count');
		$('#delivery_count_' + delivery_count).remove();
		updateOrderRemaining();
	});
	");
	
	
	
$this->registerJs("$(document).on('click', '.select_truck_button', function() 
	{	
		delivery_count = $(this).attr('delivery_count');
		requestedDate = $('#".Html::getInputId($model, 'delivery_on')."').val();
		
		
		
		//Check the date has been chosen before displaying a list of trucks
		
		
		//Check to see if any of the truck 2nd runs have been used
		var usedTrucks = new Array();
		$('.truck_details').each(function() 
			{
			used_truck_id = $(this).attr('truck_id');
			used_delivery_run_num = $(this).attr('delivery_run_num');

			if(used_delivery_run_num > 1)
				{
				usedTrucks.push(used_truck_id + '_' + used_delivery_run_num);	
				}
			});
		usedTrucks = usedTrucks.join(',');
		
		
		$.ajax
	  		({
	  		url: '".yii\helpers\Url::toRoute("delivery/ajax-select-truck")."',
			data: {requested_date: requestedDate, target_delivery_load: delivery_count, extra_used_trucks: usedTrucks},
			success: function (data, textStatus, jqXHR) 
				{
				$('#select-modal').modal();
				$('.modal-body').html(data);
				},
	        error: function (jqXHR, textStatus, errorThrown) 
	        	{
	            console.log('An error occured!');
	            alert('Error in ajax request' );
	        	}
			});
		
		
		
		
	});
	");
		
/**********************************************************
* 
* Add Truck Functions
* 
* 
**********************************************************/


$this->registerJs("$(document).on('click', '#add_truck_use_addtional_run', function(event) 
	{
	event.preventDefault(); 	
	
	
	selected_truck_id = $('#available_trucks_control').val();
		
	if(selected_truck_id == null)
		{
		alert('Select Truck to add additional Delivery Run onto');
		return;
		}

	//split the id into the 2 components
	selected_truck_array = selected_truck_id.split('_');
	truck_id = selected_truck_array[0]
	loadrun_id = parseFloat(selected_truck_array[1]);
	
	
	//check to see if the truck has already had another delivery run created.
	if($('#available_trucks_control option[value=\'' + truck_id + '_' + (loadrun_id + 1) + '\']').html() != null)
		{
		alert('Truck already in next delivery run');
		return;
		}
	
	//check to see if they want to create antoher delivery run
	if(!confirm('Do you want to create an additional Delivery Run for this truck today?'))
		{
		return;	
		}
	
	//check to see if the option group exists if it doesn't create it first'
	optgroupLabel = 'Delivery Run ' + (loadrun_id + 1);
	if($('#available_trucks_control optgroup[label=\'' + optgroupLabel + '\']').html() == null)
		{
		$('#available_trucks_control').append('<optgroup label=\'' + optgroupLabel + '\'></optgroup>');
		}	
	
	//add the Truck to the delivery run
	selected_truck_name = $('#available_trucks_control option:selected').text();		
	var option = option = $('<option></option>');
	option.val(truck_id + '_' + (loadrun_id + 1));
	option.text(selected_truck_name);
            
	$('#available_trucks_control optgroup[label=\'' + optgroupLabel + '\']').append(option);
	
	
	});


");


$this->registerJs("$(document).on('click', '#add_truck_use', function(event) 
	{

		event.preventDefault(); 
		selected_truck_array = $('#available_trucks_control').val().split('_');
		truck_id = selected_truck_array[0];
		delivery_run_num = selected_truck_array[1];
		requestedDate = $('#".Html::getInputId($model, 'delivery_on')."').val();
		target_delivery_load = $(this).attr('target_delivery_load');

		//first check that the truck and delivery_run_num combination havent already been selected in this delivery
		//List the trucks already put in the order
		
		var truckUsed = false;
		$('.truck_details').each(function() 
			{
			used_truck_id = $(this).attr('truck_id');
			used_delivery_run_num = $(this).attr('delivery_run_num');

			if(used_truck_id == truck_id && used_delivery_run_num == delivery_run_num)
				{
				alert('Truck already used in this Delivery');
				truckUsed = true;
				}
			});

		if(truckUsed)
			{
			return;
			}


		//Check the already selected trailers for this load so far, note these trailers are not saved in the database but are only
		//on the page so far. This is to stop trailers being duplicated if there is an overlap of default trailers.
		var usedTrailers = new Array();
		$('.trailer_details').each(function() 
			{
			used_trailer_id = $(this).attr('trailer_id') + '_' + $(this).attr('delivery_run_num');
			usedTrailers.push(used_trailer_id);	
			});
		usedTrailers = usedTrailers.join(',');
		
	
		$.ajax
	  		({
	  		url: '".yii\helpers\Url::toRoute("delivery/ajax-add-truck")."',
			data: {target_delivery_load: target_delivery_load, truck_id: truck_id, delivery_run_num: delivery_run_num, requestedDate: requestedDate, usedTrailers: usedTrailers},
			success: function (data, textStatus, jqXHR) 
				{
				$('#delivery_count_' + target_delivery_load + ' > .delivery-load-truck').html(data);
				$('#select-modal').modal('hide');
				refreshTrailers(target_delivery_load, 0);
				},
	        error: function (jqXHR, textStatus, errorThrown) 
	        	{
	            console.log('An error occured!');
	            alert('Error in ajax request' );
	        	}
			});
	});
");




/**********************************************************
* 
* Add Trailer Functions
* 
* 
**********************************************************/


$this->registerJs("$(document).on('click', '.select_trailer_button', function(event) 
	{
	target_delivery_load = $(this).attr('target_delivery_load');
	trailer_slot_num = $(this).attr('trailer_slot_num');
	delivery_run_num = $(this).attr('delivery_run_num');
	requestedDate = $('#".Html::getInputId($model, 'delivery_on')."').val();

	var usedTrailers = new Array();
	$('.trailer_details').each(function() 
		{
		used_trailer_id = $(this).attr('trailer_id') + '_' + $(this).attr('delivery_run_num');
		usedTrailers.push(used_trailer_id);	
		});
	usedTrailers = usedTrailers.join(',');


	$.ajax
	  		({
	  		url: '".yii\helpers\Url::toRoute("delivery/ajax-select-trailers")."',
			data: {target_delivery_load: target_delivery_load, delivery_run_num: delivery_run_num, requestedDate: requestedDate, usedTrailers: usedTrailers, trailer_slot_num: trailer_slot_num},
			success: function (data, textStatus, jqXHR) 
				{
				
				$('#select-modal').modal();
				$('.modal-body').html(data);
				},
	        error: function (jqXHR, textStatus, errorThrown) 
	        	{
	            console.log('An error occured!');
	            alert('Error in ajax request' );
	        	}
			});



	});
	
	
");

$this->registerJs("$(document).on('click', '.add_trailer_button', function(event) 
	{
	event.preventDefault(); 
	
	
	target_delivery_load = $(this).attr('target_delivery_load');
	trailer_slot_num = $(this).attr('trailer_slot_num');
	selected_trailer = $('#add_trailer_select').val();
	
	$('#delivery_count_' + target_delivery_load + ' > .delivery-load-truck > .truck_details').attr('trailer' + trailer_slot_num + '_id', selected_trailer);
	$('#select-modal').modal('hide');
	
	refreshTrailers(target_delivery_load, trailer_slot_num );
		
	});

");



$this->registerJs("$(document).on('click', '.remove_trailer_link', function() 
	{
	target_delivery_load = $(this).attr('target_delivery_load');
	trailer_slot_num = $(this).attr('trailer_slot_num');
	trailer_id = $(this).attr('trailer_id');
		
	binsUsed = 0;
	$('.trailer_cb_id_'+trailer_id).each(function() {
    			if(this.value > 0)
    				{
					binsUsed = binsUsed + 1;	
					}
				});
	if(binsUsed > 0)
		{
		alert('Please remove all existing orders from the trailer first');
		}	
		
	$('#delivery_count_' + target_delivery_load + ' > .delivery-load-truck > .truck_details').attr('trailer' + trailer_slot_num + '_id', '');
	refreshTrailers(target_delivery_load, trailer_slot_num );	
		
	});
	");


/****************************************************************************
* 
* Trailer selection function
* 
******************************************************************************/
$this->registerJs("function updateOrderRemaining()
{
	allocatedQty = 0
	orderQty = parseFloat($('#orderdetails-orderQTY').val());
	
	$('.trailer_bin_checkbox').each(function() {
    			if(this.checked)
    				{
					allocatedQty = allocatedQty + parseFloat($(this).val());
					}
				});
				
	remainingQty = 	Math.round(orderQty - allocatedQty);
	$('#remaining_tonnes').html(remainingQty);
	
	
	//if there is no more to allocate to the trailers then disable all the remaining checkboxes
	if(remainingQty <= 0)
		{
		$('.trailer_bin_checkbox').each(function() {
			if(this.checked == false)
				{
				$(this).attr('disabled', true);
				}
				
			//make sure the select all is ticketed if there are any bins ticketed
			else{
				trailer_id = $(this).attr('trailer_id');
				$('#trailer_bin_select_all_' + trailer_id).attr('checked', true);
				}
			});
		}
		
	//If there is an ammount to allocate make sure that the other checkboxes can be used
	else{
		$('.trailer_bin_checkbox').each(function() {
			$(this).removeAttr('disabled');
			});
		}
	
	
}
");

$this->registerJs("$(document).on('click', '.trailer_bin_checkbox', function()  
 		{
		remainingQty = parseFloat($('#remaining_tonnes').html());
		capacity = parseFloat($(this).attr('capacity'));
		fillMethod = $('#fill_method').val();

		if(fillMethod == 'fill_on_selection')
			{
				
			
			if(this.checked)
				{
				if(remainingQty < capacity)
					{
					$(this).attr('value', remainingQty);
					$(this).parent().attr('class', 'sap_trailer_partial');
					}
				else{
					$(this).attr('value', capacity);
					$(this).parent().attr('class', 'sap_trailer_full');
					}
				updateOrderRemaining();
				}
			else{
				$(this).attr('value', 0);
				$(this).parent().attr('class', 'sap_trailer_empty');
				updateOrderRemaining();
				}
			}
			
		if(fillMethod == 'select_first')
			{
			if(this.checked == false)
				{
				$(this).attr('value', 0);
				$(this).parent().attr('class', 'sap_trailer_empty');
				updateOrderRemaining();	
				}
			}
		});
		
	");

$this->registerJs("$('#fill_method').on('change', function()
		{
		if(this.value == 'fill_on_selection')
			{
			$('#fill_selected_bins').hide();
			clearBinSelection();
			}
		else if(this.value == 'select_first')
			{
			$('#fill_selected_bins').show();
			clearBinSelection();
			}
		
		});
		
		
	function clearBinSelection()
	{
	$('.trailer_bin_checkbox').each(function() {
		$(this).attr('checked', false);
		$(this).attr('value', 0);
		$(this).parent().attr('class', 'sap_trailer_empty');
		});
	updateOrderRemaining();
	}
		
		
		
	");


$this->registerJs("$(document).on('click', '.trailer_bin_select_all', function()  
	{
	trailer_id = $(this).attr('trailer_id');
	if(this.checked)
		{	
		
			//First check to see what type of filling method has been selected
			// Fill bin on selection - fills the bins to capacity from left to right
			// Select Bins first then allocate - Selects all of the bins in the trailer
			
			fillMethod = $('#fill_method').val();
			
			//Fill bin on selection - select the bins from left to right until the entire order has been allocated
			if(fillMethod == 'fill_on_selection')
				{
				remainingQty = parseFloat($('#remaining_tonnes').html());
				$('.trailer_cb_id_'+trailer_id).each(function() {
					if(this.checked == false)
						{
						capacity = parseFloat($(this).attr('capacity'));
						if(isNaN(capacity))
							{
							
							}
						else if(remainingQty == 0)
							{
							updateOrderRemaining();		
							}
						else if(remainingQty < capacity)
							{
							this.checked = true;
							$(this).attr('value', remainingQty);
							$(this).parent().attr('class', 'sap_trailer_partial');
							remainingQty = 0;
							updateOrderRemaining();	
							}
						else{
							this.checked = true;
							$(this).attr('value', capacity);
							$(this).parent().attr('class', 'sap_trailer_full');
							remainingQty = remainingQty - capacity;
							}
						}
					});
				updateOrderRemaining();
				}
				
				
			//Select the bins first then allocate the load eveningly across the bins
			else if(fillMethod == 'select_first')
				{
				$('.trailer_cb_id_'+trailer_id).each(function() 
					{
					if($(this).is(':disabled') == false)
						{
						this.checked = true;		
						}
					});
				updateOrderRemaining();
				}
			
		}
		
		
		
		
		
	//unticking the checkbox will clear all of the selected bins regardless of the selection method	
	else{
		$('.trailer_cb_id_'+trailer_id).each(function() {
				
				capacity = parseFloat($(this).attr('capacity'));
				if(!isNaN(capacity))
					{
					this.checked = false;
					$(this).parent().attr('class', 'sap_trailer_empty');
				$(this).attr('value', 0);
					}
				
				updateOrderRemaining();		
				});
		}
	
		
		
		
		
		
		
	});
");


$this->registerJs("$(document).on('click', '#fill_selected_bins', function(event) 
		{
			event.preventDefault(); 
			
			//Get the order amount in the order
			orderQty = parseFloat($('#orderdetails-orderQTY').val());
			
			//go through each of the checkboxes and check how much has been allocated, need to make sure that
			// there is enough room for the order. If there is more room then needed then it will spread the order out across
			// all of the selected bins.	
			selectedBinCapacity = 0;		
			$('.trailer_bin_checkbox').each(function() {
    			if(this.checked)
    				{
					selectedBinCapacity = selectedBinCapacity + parseFloat($(this).attr('capacity'));
					}
				});
			
			//check to see enough bins have been selected
			if (selectedBinCapacity < orderQty)
				{
				alert('Not enough bins selected for Order, only enough bins selected for ' + selectedBinCapacity + ' tonnes');
				}
			else
				{
					
				//work out the percentage of each bin
				fillPercent = 	orderQty/selectedBinCapacity;
				$('.trailer_bin_checkbox').each(function() {
	    			if(this.checked)
	    				{
	    				binCapacity = $(this).attr('capacity');
						$(this).attr('value', fillPercent * binCapacity);
						$(this).parent().attr('class', 'sap_trailer_partial');
						}
					});	
					
				updateOrderRemaining();		
				}
			
			
		});


");



$this->registerJs("$('.sap_print').on('click',function(){
	
	var windowSizeArray = [ 'width=200,height=200',
                            'width=300,height=400,scrollbars=yes' ];

	var url = '".yii\helpers\Url::toRoute(["delivery/print-additive-loader-pdf", 'id' => $model->id])."';
    var windowName = 'Weigh Bridge Ticket';
    var windowSize = windowSizeArray[$(this).attr('rel')];

    window.open(url, windowName, windowSize);

   

	
	});
");



/********************************************************************
* 
* Batch Size calculations
* 
********************************************************************/


$this->registerJs("$('#".Html::getInputId($model, 'num_batches')."').on('change', function()
		{
		var num_batches = parseFloat($(this).val());
		var	orderQty = parseFloat($('#orderdetails-orderQTY').val());


		var batchSize = (orderQty / num_batches).toFixed(3);;
		$('#".Html::getInputId($model, 'batchSize')."').val(batchSize)
	
		
		});

");
?>

<div class="delivery-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'delivery-form']); ?>

    <?=	$form->field($model, 'order_id', ['template' => '{input}'])->hiddenInput()->label(false); ?>
    
    
    
    
	   <div class='delivery-order-info'> 
	    <fieldset ><legend class='sapDeliveryFieldSetLegend'>Order Details</legend>		    
			    		<table width='100%'>
			    			<tr>
			    				<td width='33%'><b>Customer: </b><input type='text' id='orderdetails-customer' readonly class='infoInput' value='<?= isset($order->client) ? $order->client->Company_Name: "" ?>'></td>
			    				<td width='33%'><b>Order ID:</b> <input type='text' id='orderdetails-orderID' class='infoInput' readonly value='<?= $order->Order_ID ?>'> </td>
			    				<td width='33%'><b>Order Qty:</b> <input type='text' id='orderdetails-orderQTY' class='infoInput' readonly value='<?= $order->Qty_Tonnes ?>'> </td>
			    			</tr>
			    			<tr>
			    				<td width='33%'><b>Order Owner: </b><input type='text' id='orderdetails-owner' readonly class='infoInput' value='<?= isset($order->createdByUser) ? $order->createdByUser->fullname : "" ?>'> </td>
			    				<td width='33%'><b>Requested Delivery By Date:</b> <input type='text' id='orderdetails-delivery-date' class='infoInput' readonly value='<?= isset($order->Requested_Delivery_by) ? date("D d-M-Y", strtotime($order->Requested_Delivery_by)): "" ?>'></td>
			    				<td width='33%'><b>Delivered to Onsite Storage: </b><input type='text' id='orderdetails-storage' readonly class='infoInputLarge' value='<?= isset($order->storage) ? $order->storage->Description : "" ?>'> </td>
			    			</tr>
			    			<tr>
			    				<td colspan='3' style='vertical-align:top;'>
			    					 <b>Order Notes:</b><textarea rows='1' style='width:100%;' id='orderdetails-order-instructions' readonly><?= $order->Order_instructions ?></textarea>
			    				</td>		    			
			    			</tr>
			    		</table>
			    			
			    			

		</fieldset>
	    </div>
  	 <br>
  
    
		<div style='border: 1px solid; width: 100%; height: 50px;'>
			<font size='+3'>Unallocated Order (Tonnes): <span id='remaining_tonnes'></span></font>
		</div>
		<br>
	     <?= $form->errorSummary($model); ?>  
	    <div width='100%' style='height: 100px;'>
	    	<div style='width: 100%; float: left'>
	    		
	    		<div style='width: 800px; margin: auto;'>
	    			<?= 
	    			Form::widget(
						[
						'model'=>$model,
						'form'=>$form,
					
						'columns'=>3,
						'attributes' =>
							[    
	    					'delivery_on' =>
	    						[
	    					
								'type' => Form::INPUT_WIDGET,
								'widgetClass' => DateControl::classname(),
								//'placeholder' => "Requested Delivery Date...",
								'options' =>
									[
									'pluginOptions' =>
										[
										'autoclose' => true,
										'todayHighlight' => true,
										],
									'pluginEvents' =>
										[
										'changeDate' => "function(e) { clearAllLoads(); }",
										]
									]
								],
							'num_batches' =>
	    						[
	    						'type' => Form::INPUT_TEXT,
	    						],
	    					'batchSize' =>
	    						[
	    						'type' => FORM::INPUT_TEXT,
	    						'options'=>
	    							[
	    							'disabled' => True,
	    							]
	    						]
	    						
	    					],
	    					
	    				]);
	    			
	    			?>
	    	
							
				
	    			
	    			
	    			
	    		</div>
	    		
	    		
	    	</div>
	    </div>
	
		<div style='width: 100%; border: 1px solid'>
			<div style='width:500px; margin: auto; height: 30px; padding-left: 10px; padding-top: 2px;'>
				Select Fill Method 
				<select id='fill_method'>
					<option value='fill_on_selection'>Fill Bin On Selection</option>
					<option value='select_first'>Select Bins First then Allocate</option>
				</select>
				<button id='fill_selected_bins' hidden>Fill Selected Bins</button>
			</div>

		
		


			<div id='delivery_load_section'>
				<?
				
				

					foreach($model->deliveryLoad as $index => $deliveryLoadObject)
						{
						echo $this->render('/delivery-load/_form', [
		        			'deliveryLoad' => $deliveryLoadObject,
		        			'deliveryCount' => ($index + 1),
					    	]);
						}

				
				
				?>
				
				
				
			</div>	
			<div style='width: 150px; margin: auto; padding-top: 24px; padding-left: 15px'>
	    			<button class='add_delivery_load' style='width: 150px; height: 39px;'>Add Delivery Load</button>	
	    	</div>
			
		
		</div>
		
	</div>

	
    <?php ActiveForm::end(); ?>

	


<div>
	<?php		
		Modal::begin([
		    'id' => 'select-modal',
		    'header' => '<h4 class="modal-title">Select</h4>',
		    'size' => 'modal-md',
		    'options' =>
		    	[
				'tabindex' => false,
				]

		]);		?>


		<div id="modal_content">dd</div>

	<?php Modal::end(); ?>
</div>


</div>
