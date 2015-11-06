<?php

use yii\helpers\Html;


	
	
	
	
/* @var $this yii\web\View */
/* @var $deliveryLoad */
/* @var $deliveryCount */
?>

<div class="delivery-load-form" id='delivery_count_<?= $deliveryCount ?>' delivery_count='<?= $deliveryCount ?>'>
	
	<div class='delivery-load-truck'>
		<?
		echo $this->render('/Trucks/_truck', [
			'truck' => $deliveryLoad->truck,
			'deliveryCount' => $deliveryCount,
	    	]);	
		?>
		
	</div>

	<div class='delivery-load-trailer1'>
		
		
		
	</div>
	<div class='delivery-load-trailer2'>
		
		
		
	</div>

	<div class='delivery-load-action'>
		<a title='Remove Load'>
			<div class='sap_icon_small sap_cross_small remove_delivery_load' delivery_count='<?= $deliveryCount ?>'></div>
		</a>
	</div>

</div>
