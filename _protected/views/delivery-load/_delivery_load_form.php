<?php

use yii\helpers\Html;


	
/*	truck - Truck Object
*	deliveryCount - target_delivery_load
*   deliveryLoad - DeliveryLoad object being rendered in this page


*	delivery_run_num - The Delivery Run Number Var
*/	
	

?>

<div class="delivery-load-form" id='delivery_count_<?= $deliveryCount ?>' delivery_count='<?= $deliveryCount ?>'>

	<div style='width: 100%; padding-left: 10px'><?= "(".$deliveryCount.")" ?> Delivery Date: <?= date("d M Y" ,strtotime($deliveryLoad->delivery_on)) ?></div>
	<div class='delivery-load-truck' delivery_load_truck_id=''>
		<?
		//echo $this->render('/Trucks/_truck', [
		//	'truck' => $deliveryLoad->truck,
		//	'deliveryCount' => $deliveryCount,
		//	'delivery_run_num' => $deliveryLoad->delivery_run_num,
		//	'trailer1_id' => $deliveryLoad->getTrailerID(0),
		//	'trailer2_id' => $deliveryLoad->getTrailerID(1),
		//	'delivery_load_id' => $deliveryLoad->id,
	    //	]);	
		?>
		
	</div>

	<div class='delivery-load-trailer1'>
		
		<?
		echo $this->render('/Trailers/_trailer',
				[
				'deliveryLoadtrailer' => $deliveryLoad->deliveryLoadTrailer1,
				'trailer_slot_num' => 1,
				'deliveryCount' => $deliveryCount, 
				]
			
		)
		
		?>
		
		
	</div>
	<div class='delivery-load-trailer2'>
		
		<?
		
		?>
		
	</div>

	<div class='delivery-load-action'>
		<a title='Remove Load'>
			<div class='sap_icon_small sap_cross_small remove_delivery_load' delivery_count='<?= $deliveryCount ?>'></div>
		</a>
	</div>

</div>
