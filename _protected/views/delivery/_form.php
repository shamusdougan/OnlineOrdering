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
use vendor\actionButtons\actionButtonsWidget;
	
/*	model - Delivery Object
*	order - Customeroder
*  
*/	

if(!isset($readOnly)){ $readOnly = False;}
if(!isset($truckList)){ $truckList = array();}


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
			    			
			    			

		
	    </div>
  	 <br>
  
    
		
	
	     <?= $form->errorSummary($model); ?>  
	       
	       
	    <font size='+3'>Delivery Details</font>
	    <div style='width: 100%; border: 1px solid; padding: 10px'>
	    
	    		
	    		
	    			<?= 
	    			Form::widget(
						[
						'model'=>$model,
						'form'=>$form,
					
						'columns'=>3,
						'attributes' =>
							[    
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
	    						],
	    					'load_from_bin_id' =>
	    						[
	    						'type' => FORM::INPUT_TEXT,
	    						]
	    						
	    					],
	    					
	    				]);
	    			
	    			?>
	    	
	    	
	    </div>
		<br>
		
		 <font size='+3'>Delivery Load(s)</font>
		<div style='width: 100%; border: 1px solid; padding: 10px'>
			<div class='row'>
				<div class='col-sm-4'>
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
										
										//'pluginEvents' =>
										//	[
										//	'changeDate' => "function(e) { clearAllLoads(); }",
										//	]
										],
									'pluginOptions' =>
											[
											'autoclose' => true,
											'todayHighlight' => true,
											],
									],
								],
							]);
					?>
				</div>
				<div class='col-sm-4'>
					<button class='add_delivery_load' style='width: 150px; height: 58px'>Add Delivery Load </button>
				</div>
				<div class='col-sm-4'>
					<font size='+3'>Remaining Tons: <span id='remaining_tonnes'></span></font>
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
				
				$deliveryCount = 1;
				foreach($model->deliveryLoad as $deliveryLoad)
					{
					echo $this->render('/delivery-load/_delivery_load_form',
						[
						'deliveryCount' => $deliveryCount,
						'deliveryLoad' => $deliveryLoad,
						'delivery_id' => $model->id,
						]);
					$deliveryCount++;
					}
				?>
			</div>	

		</div>
		
	</div>

	
    <?php ActiveForm::end(); ?>

</div>	


<div>
	<?php		
		Modal::begin([
		    'id' => 'select-modal',
		    'header' => '<h4 class="modal-title">Select</h4>',
		    'size' => 'modal-lg',
		    'options' =>
		    	[
				'tabindex' => false,
				]

		]);		?>


		<div id="modal_content">dd</div>

	<?php Modal::end(); ?>
</div>



<?
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
/**********************************************************
* 
* Delivery Load Functions
* 
* 
**********************************************************/


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
				data: {deliveryCount: next_delivery_count, requestedDate: requestedDate, delivery_id: ".(isset($model->id) ? $model->id : 0 )."  },
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
		
			
		usedTrailers = getSelectedTrailers();
		
				
		$.ajax
	  		({
	  		url: '".yii\helpers\Url::toRoute("delivery/ajax-select-trailers")."',
			data: {requested_date: requestedDate, deliveryCount: next_delivery_count, trailerSlot: 1, selectedTrailers: usedTrailers},
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




$this->registerJs("$(document).on('click', '.remove_delivery_load', function() 
	{	
		delivery_count = $(this).attr('delivery_count');
		$('#delivery_count_' + delivery_count).remove();
		updateOrderRemaining();
	});
	");
	
/********************************************************************************
* 
* Trailer Functions
* 
************************************************************************************/

//Get SelectedTrailers should produce a csv list of the trailers already on the page
$this->registerJs("
function getSelectedTrailers()
{
	return '';
}



// render trailer section
function renderTrailer(deliveryCount, trailerSlot, trailer_id, trailer_run_num)
{

	//get the place the trailer is to be rendered too	
	var target = $('#delivery_count_' + deliveryCount + ' > .delivery-load-trailer' + trailerSlot);

	$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("delivery/ajax-get-delivery-load-trailer")."',
		data: {trailerSlot: trailerSlot, deliveryCount: deliveryCount, trailer_id: trailer_id, trailer_run_num: trailer_run_num, delivery_load_id: ".(isset($model->id) ? $model->id : 0 )."},
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


$this->registerJs("$(document).on('click', '#add_run', function() 
	{	
		table = document.getElementById('trailer_select_table');
		var row = table.insertRow(0);
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);

		cell1.innerHTML = 'NEW CELL1';
		cell2.innerHTML = 'NEW CELL2';
	});
	");


$this->registerJs("$(document).on('click', '#select_trailer_button', function(event) 
	{
	
	
	//First lets check that a trailer has been selected if not alert and return to dialog
	var trailer_id = $('input[name=trailer_row_select]:checked').val();
	if(trailer_id == undefined)
		{
		alert('Please select a Trailer');
		return;
		}
	var deliveryCount = $('input[name=trailer_row_select]:checked').attr('deliveryCount');
	var delivery_run_num = $('input[name=trailer_row_select]:checked').attr('delivery_run_num');
	var trailerSlot = $('input[name=trailer_row_select]:checked').attr('trailerSlot');
		
	$('#select-modal').modal('hide');
	renderTrailer(deliveryCount, trailerSlot, trailer_id, delivery_run_num)

	});
");	

/**
* 
* Add and remove the trailers from the page
* 
*/	
	
$this->registerJs("$(document).on('click', '.remove_trailer_link', function() 
	{
	
	deliveryCount =  $(this).attr('deliveryCount');
	trailer_slot_num = $(this).attr('trailer_slot_num');
	renderTrailer(deliveryCount, trailer_slot_num, 0, 0);
		
	});
	");
	
$this->registerJs("$(document).on('click', '.add_trailer_link', function() 
	{
	
	var deliveryCount =  $(this).attr('deliveryCount');
	var trailer_slot_num = $(this).attr('trailer_slot_num');
	var requestedDate = $('input[name=\"deliveryLoad['+ deliveryCount + '][delivery_on]\"]').attr('value');
	var usedTrailers = getSelectedTrailers();

	
	$.ajax
	  		({
	  		url: '".yii\helpers\Url::toRoute("delivery/ajax-select-trailers")."',
			data: {requested_date: requestedDate, deliveryCount: deliveryCount, trailerSlot: trailer_slot_num, selectedTrailers: usedTrailers},
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



/**********************************************************************
* 
* 			Truck Functions
* 
**********************************************************************/


$this->registerJs("$(document).on('click', '.add_truck_link', function() 
	{
	
	
	var deliveryCount =  $(this).attr('deliveryCount');
	
	var requestedDate = $('input[name=\"deliveryLoad['+ deliveryCount + '][delivery_on]\"]').attr('value');
	var selectedTrucks = getSelectedTrucks();

	
	$.ajax
	  		({
	  		url: '".yii\helpers\Url::toRoute("delivery/ajax-select-truck")."',
			data: {requested_date: requestedDate, deliveryCount: deliveryCount, selectedTrucks: selectedTrucks},
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
	
		


	})");



$this->registerJs("$(document).on('click', '.remove_delivery_load_truck', function() 
	{
	deliveryCount =  $(this).attr('deliveryCount');
	renderTruck(deliveryCount, 0, 0);
	});
	");
	
	
$this->registerJs("$(document).on('click', '#select_truck_button', function(event) 
	{
	
	
	//First lets check that a trailer has been selected if not alert and return to dialog
	var truck_id = $('input[name=truck_row_select]:checked').val();
	if(truck_id == undefined)
		{
		alert('Please select a Truck or close dialog');
		return;
		}
	var deliveryCount = $('input[name=truck_row_select]:checked').attr('deliveryCount');
	var truck_run_num = $('input[name=truck_row_select]:checked').attr('delivery_run_num');



	var max_trailers=$('input[name=truck_row_select]:checked').attr('max_trailers');
	var max_load=$('input[name=truck_row_select]:checked').attr('max_load');
	var auger=$('input[name=truck_row_select]:checked').attr('auger');
	var blower=$('input[name=truck_row_select]:checked').attr('blower');
	var tipper=$('input[name=truck_row_select]:checked').attr('tipper');


		
	$('#select-modal').modal('hide');
	renderTruck(deliveryCount, truck_id, truck_run_num)

	});
");	


$this->registerJs("
function getSelectedTrucks()
{
	
	var selectedTrucks = new Array();
	$('.delivery_load_truck_id').each(function()
		{
		var truck_id = $(this).attr('value');
		var truck_run_num = $(this).attr('truck_run_num');
		
		selectedTrucks.push(truck_id + '_' + truck_run_num);
		});
	selected_trucks = selectedTrucks.join(',');
	

	
	return selected_trucks;
}

















// render truck section
function renderTruck(deliveryCount, truck_id, truck_run_num)
{

	//get the place the trailer is to be rendered too	
	var target = $('#delivery_count_' + deliveryCount + ' > .delivery-load-truck');

	$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("delivery/ajax-get-delivery-load-truck")."',
		data: {deliveryCount: deliveryCount, truck_id: truck_id, truck_run_num: truck_run_num, delivery_load_id: ".(isset($model->id) ? $model->id : 0 )."},
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

