<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\datePicker;
use kartik\widgets\select2;
use kartik\widgets\DepDrop;
use app\models\Trucks;
use yii\helpers\Url;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
/* @var $model app\models\Delivery */
/* @var $form yii\widgets\ActiveForm */


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

function updateOrderDetails()
{
	var order_id = $(\"#".Html::getInputId($model, 'order_id')."\").val();

	 $.ajax({
        url: '".yii\helpers\Url::toRoute("delivery/ajax-order-details")."',
        dataType: 'json',
        method: 'GET',
        data: {id: order_id},
        success: function (data, textStatus, jqXHR) {
           	$('#orderdetails-orderID').val(data.orderID);
           	$('#orderdetails-customer').val(data.customer);
           	$('#orderdetails-owner').val(data.owner);
           	$('#orderdetails-delivery-date').val(data.deliveryDate);
           	$('#orderdetails-storage').val(data.storage);
           	$('#orderdetails-orderQTY').val(data.orderQTY);
           	$('#orderdetails-order-instructions').html(data.instructions);
           	$('#remaining_tonnes').html(data.orderQTY);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('An error occured!');
            alert('Error in ajax request retriving customer details' );
        }
    });
}


function updateOrderRemaining()
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

function clearBinSelection()
{
	$('.trailer_bin_checkbox').each(function() {
		$(this).attr('checked', false);
		$(this).attr('value', 0);
		$(this).parent().attr('class', 'sap_trailer_empty');
		});
	updateOrderRemaining();
}



function clearAllTrucksTrailers()
{
	$('.truck_allocation_section').each(function ()
		{
		this.remove();
		updateSelectedTrailersInput();
		updateOrderRemaining();
		});
}

function updateSelectedTrailersInput()
{
	var selectedTrailers = new Array();
	$('.remove_trailer_link').each(function() 
		{
		selectedTrailers.push($(this).attr('trailer_id'));
		});
	$('#selected_trailers').val(selectedTrailers.join(',')) ;
}


function updateTrailerAddLink()
{
	
	//Go through and check each deliveryload area to see if more then 2 trucks have been added
	var truckList = new Array();
	$('.remove_trailer_link').each(function() 
		{
		truck_id = $(this).attr('truck_id');
		if(truck_id in truckList)
			{
			truckList[truck_id] = truckList[truck_id] + 1;
			}
		else {
			truckList[truck_id] = 1;
			}
		});
		
	//if there are more then 2 trailers assigned disable the link
	$('.trailer_add_link_id').each(function()
		{
		truck_id = $(this).attr('truck_id');
		if(truckList[truck_id] >= 2)
			{
			$(this).text('Maximum Trailers');
			$(this).attr('class', 'trailer_add_link_id');
			}
		else{
			$(this).text('Add Trailer(s)');
			$(this).attr('class', 'trailer_add_link trailer_add_link_id');
			}
		});

		
		
}

");






/**
* 
* Java script Event Handlers
* 
* 
*/

//Update the order detals on the form according to the selected order from the drop down list
$this->registerJs("$('#".Html::getInputId($model, 'order_id')."').on('change',function(){
	updateOrderDetails();
});");


$this->registerJs("$('#add_truck_button').click(function(event)
	{
		event.preventDefault(); 
		truck_id = $('#truck_selection').val();
	
		

		
		requestedDate = $('#".Html::getInputId($model, 'delivery_on')."').val();
		
		if(jQuery('#truck_allocate_' + truck_id).length)
			{
			alert('Truck has already been allocated to this delivery')	;
			}
		else if(truck_id == null )
			{
			alert('Select a Delivery Date before you select a Truck');
			}
		else if (truck_id == '')
			{
			alert('Please Select a Truck for the Delivery');
			}
		else
			{
			$.ajax
		  		({
		  		url: '".yii\helpers\Url::toRoute("delivery/ajax-add-delivery-load")."',
				data: {truck_id: truck_id, requestedDate: requestedDate},
				success: function (data, textStatus, jqXHR) 
					{
					$('#truck_display_start').append(data);
					updateSelectedTrailersInput();
					updateTrailerAddLink();
					},
		        error: function (jqXHR, textStatus, errorThrown) 
		        	{
		            console.log('An error occured!');
		            alert('Error in ajax request' );
		        	}
				});
				
			
				
				
			}
		
		
	});
");

//need to add ajax here to remove any bins that have been allocated to the order
 $this->registerJs("$(document).on('click', '.close_allocation_link', function() 
	{
		
		
		truck_id = $(this).attr('truck_id');
		delivery_id = $(this).attr('delivery_id');
		
		if(delivery_id != '')
			{
			$.ajax
		  		({
		  		url: '".yii\helpers\Url::toRoute("delivery/ajax-remove-delivery-load")."',
				data: {truck_id: truck_id, delivery_id: delivery_id},

		        error: function (jqXHR, textStatus, errorThrown) 
		        	{
		            console.log('An error occured!');
		            alert('Error in ajax request' );
		        	}
				});
			}
		
		
		$('#truck_allocate_' + $(this).attr('truck_id')).remove();
		updateSelectedTrailersInput();
		updateOrderRemaining();
		

	});
");
 
 
 
 
$this->registerJs("$(document).on('click', '.trailer_add_link', function() 
	{
		
	//This will list the currently selected trailers for this truck
	selected_trailers = $('#selected_trailers').val();
	requestedDate = $('#".Html::getInputId($model, 'delivery_on')."').val();
	truck_id = $(this).attr('truck_id');
	
	
	$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("delivery/ajax-add-trailers")."',
		data: {requested_date: requestedDate, selected_trailers: selected_trailers, truck_id: truck_id},
		success: function (data, textStatus, jqXHR) 
			{
			$('#trailer-select-modal').modal();
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
 
 
 
$this->registerJs("$(document).on('click', '.add_trailer_button', function() 
	{
		truck_id = $(this).attr('truck_id');
		selected_trailer_id = ($('#add_trailer_select').val());
		requestedDate = $('#".Html::getInputId($model, 'delivery_on')."').val();
		
		$.ajax
	  		({
	  		url: '".yii\helpers\Url::toRoute("delivery/ajax-append-trailer")."',
			data: {truck_id: truck_id, selected_trailer_id: selected_trailer_id, requested_date: requestedDate},
			success: function (data, textStatus, jqXHR) 
				{
				$('#trailer_start_' + truck_id).append(data);
				$('#trailer-select-modal').modal('hide');
				updateOrderRemaining();	
				updateSelectedTrailersInput();
				},
	        error: function (jqXHR, textStatus, errorThrown) 
	        	{
	            console.log('An error occured!');
	            alert('Error in ajax request' );
	        	}
			});
		
		
		
	
		
		
		
	});
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

$this->registerJs("
	$( document ).ready(function() {
    	updateOrderRemaining();	
		});
	");
 
 
 
$this->registerJs("$(document).on('click', '.remove_trailer_link', function() 
	{
	delivery_id = $(this).attr('delivery_id');
	trailer_id = $(this).attr('trailer_id');
	truck_id = $(this).attr('truck_id');
		
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
	else{
		requestedDate = $('#".Html::getInputId($model, 'delivery_on')."').val();
		
		//Need to check if this is a delivery that has already been saved.
		//if the delivery_id is blank then this is a new order and the trailer can simply be removed from the interface
		if(delivery_id == '')
			{
			$('.trailer_display_' + trailer_id).remove();	
			updateSelectedTrailersInput();
			updateTrailerAddLink();
			}
		else{
			
		
		
			$.ajax
		  		({
		  		url: '".yii\helpers\Url::toRoute("delivery/ajax-remove-trailer")."',
				data: {truck_id: truck_id, trailer_id: trailer_id, delivery_id: delivery_id},
				success: function (data, textStatus, jqXHR) 
					{
					$('#truck_allocate_' + truck_id).html(data);
					updateSelectedTrailersInput();
					updateTrailerAddLink();
					},
		        error: function (jqXHR, textStatus, errorThrown) 
		        	{
		            console.log('An error occured!');
		            alert('Error in ajax request' );
		        	}
				});
			}
		}
	
 	});
 	
 ");
 
 
 
 
?>



<div class="delivery-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'delivery-form']); ?>

    <?	if(isset($model->order_id))
    		{
			echo   $form->field($model, 'order_id', ['template' => '{input}'])->hiddenInput()->label(false);			
			}
    	else{
			echo Form::widget([
		    	'model'=>$model,
		    	'form'=>$form,
		    	'columns'=>6,
		    	'attributes'=>[
		    		'order_id' =>
		    			[
		    				'type' => Form::INPUT_WIDGET,
		    				'label' => 'Order',
		    				'widgetClass' => '\kartik\widgets\Select2',
		    				'columnOptions'=>['colspan'=>2],
		    				'options'=>
		    					[
		    					'data'=>$submittedOrders,
		    					'options' => ['placeholder' => 'Select from currently submitted orders....', 'selected' => null,],
		    					'disabled' => $readOnly,
		    					],
							
		    			],		
		      		]
		    	]);
			}
    ?>
    
    
    
    
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
    
    <div width='100%' style='height: 80px;'>
    	<div style='wdith: 300px; float: left'>
    		
    		<div style='width: 100%;'>
    			<?=  $form->field($model, 'delivery_on')->widget(DateControl::classname(), 
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
								],
							'pluginEvents' =>
								[
								'changeDate' => "function(e) { clearAllTrucksTrailers(); }",
								
								
								]
								
							]
						]);
    			?>
    		</div>
    	</div>
    	<div style='padding-left: 10px; width: 400px; float: left'>
    		<div style='width: 100%;'><b>Truck</b></div>
			<div style='width: 100%; padding-top: 5px;'>
		    <?= DepDrop::widget([
		    	'name' => 'TruckSelect',
				'type'=>DepDrop::TYPE_SELECT2,
				'id' => 'truck_selection',
			    'select2Options'=>
			    	[
			    	'pluginOptions'=>
			    		[
			    		'allowClear'=>true,
			    		]
			    	],
				'pluginOptions'=>[
					'depends'=>[Html::getInputId($model, 'delivery_on')],
					'url'=>Url::to(['/delivery/ajax-available-trucks']),
					'placeholder'=>'Select Truck to add....',
					],
				'data' => $truckList,
				]);	
			?>	
			</div> 
    	</div>
    	<div style='padding-left: 10px; width: 400px; float: left'>
    		<div style='width: 100%;'>&nbsp</div>
			<div style='width: 100%; padding-top: 5px;'>
		   		<button id='add_truck_button' style='height: 40px; width: 75px'>Add</button>
			</div> 
    	</div>
    	
	</div>
	
	<div style='width: 100%; border: 1px solid; height: 30px; padding-left: 10px; padding-top: 2px;'>
		Select Fill Method 
		<select id='fill_method'>
			<option value='fill_on_selection'>Fill Bin On Selection</option>
			<option value='select_first'>Select Bins First then Allocate</option>
		</select>
		<button id='fill_selected_bins' hidden>Fill Selected Bins</button>
	</div>

	<input type='hidden' id='selected_trailers' value='<?= $model->getTrailersUsedArrayString() ?>'>
	
	<div id='truck_display'>
		<div id='truck_display_start'>
			<? foreach($model->deliveryLoad as $deliveryLoad)
				{
					$selectedTrailers = $deliveryLoad->getLoadTrailerArray();
					echo $this->render("/trucks/_allocation", [
								'truck' => $deliveryLoad->truck,
								'selectedTrailers' => $selectedTrailers,
								'delivery' => $model,
								'usedTrailerBins' => $usedTrailerBins,
								]);
				}
			?>
			
			
			
			
		</div>
	</div>

	
    <?php ActiveForm::end(); ?>

	


<div>
	<?php		
		Modal::begin([
		    'id' => 'trailer-select-modal',
		    'header' => '<h4 class="modal-title">Select Trailers</h4>',
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
