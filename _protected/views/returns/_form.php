<?php

use yii\helpers\Html;
use app\models\Lookup;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;


/* @var $this yii\web\View */
/* @var $model app\models\Returns */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="returns-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'return-form']); ?>

    <?=	$form->field($model, 'delivery_id', ['template' => '{input}'])->hiddenInput()->label(false); ?>

   

     <div class='delivery-order-info'> 
	    <fieldset ><legend class='sapDeliveryFieldSetLegend'>Order Details</legend>		    
			    		<table width='100%'>
			    			<tr>
			    				<td width='33%'><b>Customer: </b><input type='text' id='orderdetails-customer' readonly class='infoInput' value='<?= isset($delivery->customerOrder->client) ? $delivery->customerOrder->client->Company_Name: "" ?>'></td>
			    				<td width='33%'><b>Order ID:</b> <input type='text' id='orderdetails-orderID' class='infoInput' readonly value='<?= $delivery->customerOrder->Order_ID ?>'> </td>
			    				<td width='33%'><b>Order Qty:</b> <input type='text' id='orderdetails-orderQTY' class='infoInput' readonly value='<?= $delivery->customerOrder->Qty_Tonnes ?>'> </td>
			    			</tr>
			    			<tr>
			    				<td width='33%'><b>Order Owner: </b><input type='text' id='orderdetails-owner' readonly class='infoInput' value='<?= isset($delivery->customerOrder->createdByUser) ? $delivery->customerOrder->createdByUser->fullname : "" ?>'> </td>
			    				<td width='33%'><b>Requested Delivery By Date:</b> <input type='text' id='orderdetails-delivery-date' class='infoInput' readonly value='<?= isset($delivery->customerOrder->Requested_Delivery_by) ? date("D d-M-Y", strtotime($delivery->customerOrder->Requested_Delivery_by)): "" ?>'></td>
			    				<td width='33%'><b>Delivered to Onsite Storage: </b><input type='text' id='orderdetails-storage' readonly class='infoInputLarge' value='<?= isset($delivery->customerOrder->storage) ? $delivery->customerOrder->storage->Description : "" ?>'> </td>
			    			</tr>
			    			<tr>
			    				<td colspan='3' style='vertical-align:top;'>
			    					 <b>Order Notes:</b><textarea rows='1' style='width:100%;' id='orderdetails-order-instructions' readonly><?= $delivery->customerOrder->Order_instructions ?></textarea>
			    				</td>		    			
			    			</tr>
			    		</table>
			    			
			    			

		</fieldset>
	    </div>
	    
	    <br>
	     <div class='delivery-order-info'> 
	    <fieldset ><legend class='sapDeliveryFieldSetLegend'>Delivery </legend>		    
			    		<table width='100%'>
			    			<tr>
			    				<td width='33%'><b>Delivery On: </b><input type='text' readonly class='infoInput' value='<?= date("d M Y", strtotime($delivery->delivery_on)) ?>'></td>
			    				<td width='33%'><b>Delivery Status: </b><input type='text' readonly class='infoInput' value='<?= Lookup::item($delivery->status, "DELIVERY_STATUS") ?>'></td>
			    			</tr>
			    			<tr>
			    				<td width='33%'><b>Weigh Bridge Ticket: </b><input type='text' readonly class='infoInput' value='<?= $delivery->weighbridgeTicket->ticket_number ?>'></td>
			    			</tr>
			    		</table>
		</fieldset>
	    </div>
	    
	<h2>Return Amount</h2>
 <?= 
	Form::widget(
			[
			'model'=>$model,
			'form'=>$form,
			
			'columns'=>1,
			'attributes' =>
				[    
				'amount' =>
					[
					'type' => Form::INPUT_TEXT,
					'label' => false,
					],
				],
			
		]); ?>
	    			
	    			
    <?php ActiveForm::end(); ?>

</div>
