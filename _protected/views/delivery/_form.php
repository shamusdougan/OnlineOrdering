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

/*************************************************************
* 
* Page Operation Functions
* 
*************************************************************/


$this->registerJs("

function refreshTrailers()
	{
	$('.delivery-load-form').each(function() 
		{
		target_Delivery_load = $(this).attr('delivery_count');
		truck_id = $(this).find('.truck_details:first').attr('truck_id');
		truck_max_trailers = parseFloat($(this).find('.truck_details:first').attr('truck_max_trailers'));
		trailer1_id = $(this).find('.truck_details:first').attr('trailer1_id');
		trailer2_id = $(this).find('.truck_details:first').attr('trailer2_id');

		$('#delivery_count_' + target_delivery_load + ' > .delivery-load-trailer1').html(trailer1_id);
		$('#delivery_count_' + target_delivery_load + ' > .delivery-load-trailer2').html(trailer2_id);
		
			
		});	
		
		
		
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
		
		var last_delivery_count = 0;
		$('.delivery-load-form').each(function() 
			{
			last_delivery_count = $(this).attr('delivery_count');
			});
		next_delivery_count = parseFloat(last_delivery_count) + 1;
				
		$.ajax
		  		({
		  		url: '".yii\helpers\Url::toRoute("delivery/ajax-add-delivery-load")."',
				data: {deliveryCount: next_delivery_count},
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
	});
	");
	
$this->registerJs("$(document).on('click', '.select_truck_button', function() 
	{	
		delivery_count = $(this).attr('delivery_count');
		requestedDate = $('#".Html::getInputId($model, 'delivery_on')."').val();
		
		
		
		//Check the date has been chosen before displaying a list of trucks
		if(requestedDate == ''){
			alert('Please select a Date for the delivery first');
			return;
		}
		
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

		
		$.ajax
	  		({
	  		url: '".yii\helpers\Url::toRoute("delivery/ajax-add-truck")."',
			data: {target_delivery_load: target_delivery_load, truck_id: truck_id, delivery_run_num: delivery_run_num, requestedDate: requestedDate},
			success: function (data, textStatus, jqXHR) 
				{
				$('#delivery_count_' + target_delivery_load + ' > .delivery-load-truck').html(data);
				$('#select-modal').modal('hide');
				refreshTrailers();
				},
	        error: function (jqXHR, textStatus, errorThrown) 
	        	{
	            console.log('An error occured!');
	            alert('Error in ajax request' );
	        	}
			});
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
    
    <div width='100%' style='height: 80px;'>
    	<div style='width: 100%; float: left'>
    		
    		<div style='width: 400px; float: left;'>
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
								],
							'pluginEvents' =>
								[
								'changeDate' => "function(e) { alert('need to clear al the delivery loads'); }",
								
								
								]
								
							]
						]);
    			?>
    			
    			
    		</div>
    		<div style='width: 400px; float: left; padding-top: 24px; padding-left: 15px'>
    			<button class='add_delivery_load' style='width: 150px; height: 39px;'>Add Delivery Load</button>	
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

	
	


		<div id='delivery_load_section'>
			<?
			//check to see if a delivery load has already been created if not put a blank one in
			
			if(count($model->deliveryLoad) == 0)
				{
				$deliveryLoad = new DeliveryLoad();
				$deliveryLoad->delivery_id = $model->id;
				
				echo $this->render('/delivery-load/_form', [
        			'deliveryLoad' => $deliveryLoad,
        			'deliveryCount' => 1,
			    	]);
			    
			    
				}
			else{
				
				foreach($model->deliveryLoad as $index => $deliveryLoadObject)
					{
					echo $this->render('/delivery-load/_form', [
	        			'deliveryLoad' => $deliveryLoad,
	        			'deliveryCount' => $index,
				    	]);
					}
				}
				
			
			
			?>
			
			
			
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
