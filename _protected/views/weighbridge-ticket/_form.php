<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;


/* @var $this yii\web\View */
/* @var $model app\models\WeighbridgeTicket */
/* @var $form yii\widgets\ActiveForm */




$this->registerJs("

function updateDeliveryDetails()
{
	var delivery_id = $(\"#".Html::getInputId($model, 'delivery_id')."\").val();
	

	 $.ajax({
        url: '".yii\helpers\Url::toRoute("weighbridge-ticket/ajax-delivery-details")."',
        dataType: 'json',
        method: 'GET',
        data: {delivery_id: delivery_id},
        success: function (data, textStatus, jqXHR) {
           	$('#weighbridge-date').val(data.date);
           	$('#weighbridge-truck').val(data.truck);
           	$('#weighbridge-address').val(data.address);
           	$('#weighbridge-orderinfo').val(data.orderinfo);
           	$('#weighbridge-nearest-town').val(data.nearest_town);
           	$('#weighbridge-delivery_directions').val(data.delivery_directions);
           	
           	$(\"#".Html::getInputId($model, 'date')."\").val(data.date);
           	$(\"#".Html::getInputId($model, 'truck_id')."\").val(data.truck_id);
           	
       
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('An error occured!');
            alert('Error in ajax request retriving customer details' );
        }
    });
}


");


$this->registerJs("
	$( document ).ready(function() {
    	updateDeliveryDetails();	
		});
	");


$this->registerJs("$('#".Html::getInputId($model, 'delivery_id')."').on('change',function(){
	updateDeliveryDetails();
});");



?>

<div class="weighbridge-ticket-form">

       <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'weighbridge-form']); 
       
       
		echo $form->field($model, 'ticket_number',  ['template' => '{input}'])->hiddenInput()->label(false);
		//echo $form->field($model, 'date',  ['template' => '{input}'])->hiddenInput()->label(false);
       echo $form->field($model, 'date');
       echo $form->field($model, 'ticket_number');
       echo $form->field($model, 'truck_id');
   
    
    
    
    
    //if the delivery has already been set then just hide the input field for the delivery otherwise display the selet widget to choose the Delivery
    if ($delivery != null)
    	{
		echo   $form->field($model, 'delivery_id', ['template' => '{input}'])->hiddenInput()->label(false);			
		}
    else{
		
		echo Form::widget([
	    	'model'=>$model,
	    	'form'=>$form,
	    	'columns'=>1,
	    	'attributes'=>[
	    		'delivery_id' =>
	    			[
	    				'type' => Form::INPUT_WIDGET,
	    				'label' => 'Delivery',
	    				'widgetClass' => '\kartik\widgets\Select2',
	    				
	    				'options'=>
	    					[
	    					'data'=>$deliveryList,
	    					'options' => ['placeholder' => 'Select from deliveies....', 'selected' => null,],
	    					
	    					],
						
	    			],		
	      		]
	    	]);
	
		}

   ?>
   
   
   
   <TABLE width='100%' border=1>
   		<TR>
   				<TD width='33%' style='padding-right: 5px; padding-left: 5px;' valign='top' ><font size='+1'>Delivery Information</font>
   				
   				
   				<br>
   					<div class='order_info'>
		    			<b>Load Date:</b> <input type='text' id='weighbridge-date' class='infoInputDetails' readonly> 
		    		</div>
		    		<div class='order_info'>
		    			<b>Truck: </b><input type='text' id='weighbridge-truck' readonly class='infoInputDetails'> 
		    		</div>
		    		<div class='order_info'>
		    			<b>Address: </b><input type='text' id='weighbridge-address' readonly class='infoInputDetails'> 
		    		</div>
		    		<div class='order_info'>
		    			<b>Nearest Town: </b><input type='text' id='weighbridge-nearest-town' readonly class='infoInputDetails'> 
		    		</div>
		    		
		    		
		    		<div class='order_info'>
		    			<b>Delivery Directions: </b><input type='text' id='weighbridge-delivery_directions' readonly class='infoInputDetails'> 
		    		</div>
   				<div class='order_info'>
		    			<b>Order Instructions: </b><input type='text' id='weighbridge-orderinfo' readonly class='infoInputDetails'> 
		    		</div>
   				
   				
   				</TD>
   				<TD width='33%' style='padding-right: 5px; padding-left: 5px;' valign="top"><font size='+1'>Load Information</font>
   				<?php 
   				
   				echo FORM::widget([
	   				'model'=>$model,
		    		'form'=>$form,
		    		'columns' => 2,
		    		
		    		'attributes' =>
		    			[
		    			'gross' =>
			    			[
		    				'type' => Form::INPUT_TEXT,
							'columnOptions'=>['colspan'=>2],
			    			],		
		    			'tare' =>
			    			[
		    				'type' => Form::INPUT_TEXT,
							'columnOptions'=>['colspan'=>2],			
			    			],
			    		'net' =>
			    			[
			    			'type' => Form::INPUT_TEXT,
			    			'columnOptions'=>['colspan'=>2],
			    			]	
		    			]
   				
   				
   				
   				])
   				
   				?>
   				
   				</TD>
   				<TD width='33%' style='padding-right: 5px; padding-left: 5px;'><font size='+1'>Order Info</font>
   				
   				<?php echo FORM::widget([
	   				'model'=>$model,
		    		'form'=>$form,
		    		'columns' => 2,
		    		
		    		'attributes' =>
		    			[
		    			'Moisture' =>
			    			[
			    			'label' => 'MOGR',
		    				'type' => Form::INPUT_TEXT,
							'columnOptions'=>['colspan'=>2],
			    			],		
		    			'Protein' =>
			    			[
			    			'label' => 'PRGR',
		    				'type' => Form::INPUT_TEXT,
							'columnOptions'=>['colspan'=>2],			
			    			],
			    		'testWeight' =>
			    			[
			    			'label' => 'TWT',
			    			'type' => Form::INPUT_TEXT,
			    			'columnOptions'=>['colspan'=>2],
			    			],
						'screenings' =>
			    			[
			    			'label' => 'SCRN',
			    			'type' => Form::INPUT_TEXT,
			    			'columnOptions'=>['colspan'=>2],
			    			]	
		    			]
   				
   				
   				
   				])
   				
   				
   				
   				?>
   				
   				</TD>
   			
   			
   			
   			
   		</TR>
   		<tr >
   			<td colspan='3' style='padding-right: 5px; padding-left: 5px;'>
   				<?= FORM::widget([
	   				'model'=>$model,
		    		'form'=>$form,
		    		'columns' => 1,
		    		
		    		'attributes' =>
		    			[
		    			'Notes' =>
		    				[
		    				'type' => Form::INPUT_TEXTAREA,
		    				'label' => 'Delivery Notes',
		    				]
   						]
   					]);
   				?>
   				
   			</td>
   			
   		</tr>
   	
   </TABLE>

   

    <?php ActiveForm::end(); ?>

</div>
