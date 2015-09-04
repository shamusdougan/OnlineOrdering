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
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('An error occured!');
            alert('Error in ajax request retriving customer details' );
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
		  		url: '".yii\helpers\Url::toRoute("delivery/ajax-add-truck")."',
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
	});
");
 


?>



<div class="delivery-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'delivery-form']); ?>

    <? 
    	if(isset($model->order_id))
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
		<div id='truck_display_start'></div>
	
	
	</div>
	
	
	
    <?php ActiveForm::end(); ?>

</div>
