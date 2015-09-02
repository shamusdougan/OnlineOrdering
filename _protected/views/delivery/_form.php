<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\datePicker;


/* @var $this yii\web\View */
/* @var $model app\models\Delivery */
/* @var $form yii\widgets\ActiveForm */


if(!isset($readOnly)){ $readOnly = False;};


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
		    				<td width='33%'><b>Order ID:</b> <input type='text' id='orderdetails-orderID' class='infoInput' readonly value='<?= $order->Order_ID ?>'> </td>
		    				<td width='33%'><b>Customer: </b><input type='text' id='orderdetails-customer' readonly class='infoInput' value='<?= $order->client->Company_Name ?>'></td>
		    				<td width='33%'><b>Order Owner: </b><input type='text' id='orderdetails-customer' readonly class='infoInput'> </td>
		    			</tr>
		    			<tr>
		    				<td width='33%'><b>Requested Delivery Date:</b> <input type='text' id='orderdetails-orderID' class='infoInput' readonly></td>
		    				<td width='33%'><b>Delivered to Onsite Storage: </b><input type='text' id='orderdetails-customer' readonly class='infoInput'> </td>
		    			</tr>
		    			<tr>
		    				<td colspan='3'>
		    					<b>Order Notes:</b> <input type='text' id='orderdetails-orderID' class='infoInput' readonly> 
		    					
		    				</td>		    			
		    			</tr>
		    		</table>
		    			
		    			

	</fieldset>
    </div>
    
    <?
    echo Form::widget([
    	'model'=>$model,
    	'form'=>$form,
    	'columns'=>6,
    	'attributes'=>[
    		'delivery_on' =>
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
    			],			 
      		]
    	]);
    
    
    	

	?>

    <?php ActiveForm::end(); ?>

</div>
