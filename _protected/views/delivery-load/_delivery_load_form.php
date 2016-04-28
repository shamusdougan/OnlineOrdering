<?php

use yii\helpers\Html;
use app\models\Trailers;


	
/*	
*	@var deliveryCount - the unique reference to this delivery load form on the page, usual numbers 1 -> x for each delivery load down the page.
*   @var deliveryLoad - DeliveryLoad object being rendered in this page
*	@var delivery_id - The Id of the parent delivery object

*/

//The Used bin array is a list of all the used bins on a given date.
//This used bins array also need to exclude any bins that have been used by this deliveryLoad, this allows removing the trailer and readding in the same page
//$usedBins = TrailerBins::getUsedBins($deliveryLoad->delivery_on, $delivery_id);

	

?>

<div class="delivery-load-form" id='delivery_count_<?= $deliveryCount ?>' delivery_count='<?= $deliveryCount ?>'>

	<div style='width: 100%; padding-left: 10px'>
		<div style='width: calc(100% - 30px); float: left; '>
			<b>Delivery Date: <?= date("d M Y" ,strtotime($deliveryLoad->delivery_on)) ?></b>	
		</div>
		<div style='width: 26px;  float: left; '>
		<a title='Remove Load'>
			<div class='sap_icon_small sap_cross_small remove_delivery_load' delivery_count='<?= $deliveryCount ?>'></div>
		</a>
		</div>
	
	</div>
	<input type='hidden' name='deliveryLoad[<?= $deliveryCount ?>][id]' value='<?= $deliveryLoad->id ?>'>
	<input type='hidden' name='deliveryLoad[<?= $deliveryCount ?>][delivery_on]' value='<?= $deliveryLoad->delivery_on ?>'>
	<input type='hidden' name='deliveryLoad[<?= $deliveryCount ?>][delivery_id]' value='<?= $deliveryLoad->delivery_id ?>'>
	<div class='delivery-load-truck' delivery_load_truck_id=''>
		<?
		
		echo $this->render('/Trucks/_truck', [
			'deliveryCount' => $deliveryCount,
			'truck' => $deliveryLoad->truck,
			'truck_run_num' => $deliveryLoad->truck_run_num,
	    	]);	
		?>
		
	</div>

	<div class='delivery-load-trailer1'>
		
		<?
		
	
		
		
		$usedBins = Trailers::getUsedBins($deliveryLoad->trailer1_id, $deliveryLoad->trailer1_run_num, $deliveryLoad->delivery_on, $deliveryLoad->id);
		
		
		
		
		echo $this->render('/Trailers/_trailer',
				[
				'trailer_slot_num' => 1,
				'deliveryCount' => $deliveryCount, 
				'trailer' => $deliveryLoad->trailer1,
				'trailer_run_num' => $deliveryLoad->trailer1_run_num,
				'usedBins' => $usedBins,
				'selectedBins' => $deliveryLoad->getSelectedBins(),
				]
			
		)
		
		?>
		
		
	</div>
	<div class='delivery-load-trailer2'>
		
		<?
		echo $this->render('/Trailers/_trailer',
				[
				'trailer_slot_num' => 2,
				'deliveryCount' => $deliveryCount, 
				'trailer' => $deliveryLoad->trailer2,
				'trailer_run_num' => $deliveryLoad->trailer2_run_num,
				'usedBins' => $usedBins,
				'selectedBins' => $deliveryLoad->getSelectedBins(),
				]
			
		)
		
		?>
		
	</div>

	

</div>
