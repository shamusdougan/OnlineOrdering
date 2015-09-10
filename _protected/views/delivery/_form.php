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


if(!isset($readOnly)){ $readOnly = False;};


$trucks = Trucks::getAvailable(time());

/**
* 
* Java script functions
* 
* 
*/

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
				
	remainingQty = 	orderQty - allocatedQty;
	$('#remaining_tonnes').html(remainingQty);
	
	
	
	if(remainingQty <= 0)
		{
		$('.trailer_bin_checkbox').each(function() {
			if(this.checked == false)
				{
				$(this).attr('disabled', true);
				}
			});
		}
	else{
		$('.trailer_bin_checkbox').each(function() {
			$(this).removeAttr('disabled');
			});
		}
	
	
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


 $this->registerJs("$(document).on('click', '.close_allocation_link', function() 
	{
		$('#truck_allocate_' + $(this).attr('truck_id')).remove();
		updateOrderRemaining();	
	});
");
 
 
 
 
$this->registerJs("$(document).on('click', '.trailer_select_link', function() 
	{
	selected_trailers = $(this).attr('selected_trailers');
	requestedDate = $('#".Html::getInputId($model, 'delivery_on')."').val();
	truck_id = $(this).attr('truck_id');
	
	
	$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("delivery/ajax-select-trailers")."',
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
 
 
 
$this->registerJs("$(document).on('click', '.select_trailers_button', function() 
	{
		truck_id = $(this).attr('truck_id');
		selected_trailers  = [];
		$('.trailer_select_' + truck_id).each(function() {
    			if(this.checked)
    				{
					selected_trailers.push($(this).val());
					}
				});
		
		
		$.ajax
	  		({
	  		url: '".yii\helpers\Url::toRoute("delivery/ajax-update-delivery-load")."',
			data: {truck_id: truck_id, selected_trailers: JSON.stringify(selected_trailers)},
			success: function (data, textStatus, jqXHR) 
				{
				$('#truck_allocate_' + truck_id).html(data);
				$('#trailer-select-modal').modal('hide');
				updateOrderRemaining();	
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
			}
		else{
			$(this).attr('value', 0);
			$(this).parent().attr('class', 'sap_trailer_empty');
			}
			
		updateOrderRemaining();
		});
		
	");

$this->registerJs("$(document).on('click', '.trailer_bin_select_all', function()  
	{
	trailer_id = $(this).attr('trailer_id');
	if(this.checked)
		{	
			remainingQty = parseFloat($('#remaining_tonnes').html());
			$('.trailer_cb_id_'+trailer_id).each(function() {
				if(this.checked == false)
					{
					capacity = parseFloat($(this).attr('capacity'));
					if(remainingQty == 0)
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
		}
		
		
		
		
		
		
	else{
		$('.trailer_cb_id_'+trailer_id).each(function() {
				this.checked = false;
				$(this).parent().attr('class', 'sap_trailer_empty');
				$(this).attr('value', 0);
				updateOrderRemaining();		
				});
		}
	
		
		
		
		
		
		
	});
");



$this->registerJs("
	$( document ).ready(function() {
    	updateOrderRemaining();	
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
    
    <div width='100%' style='height: 100px;'>
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
				//'data' => array(0 => 'hello'),
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
	


	
	
	<div id='truck_display'>
		<div id='truck_display_start'>
			<? foreach($model->deliveryLoad as $deliveryLoad)
				{
					$selectedTrailers = $deliveryLoad->getLoadTrailerArray();
					echo $this->render("/trucks/_allocation", [
								'truck' => $deliveryLoad->truck,
								'selectedTrailers' => $selectedTrailers,
								'delivery' => $model,
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
