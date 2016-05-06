<?php

use yii\helpers\Html;
use app\models\Trailers;


	
/*	
*	@var deliveryCount - the unique reference to this delivery load form on the page, usual numbers 1 -> x for each delivery load down the page.
*   @var deliveryLoad - DeliveryLoad object being rendered in this page
*	@var delivery_id - The Id of the parent delivery object
*	@var readonly

*/

//The Used bin array is a list of all the used bins on a given date.
//This used bins array also need to exclude any bins that have been used by this deliveryLoad, this allows removing the trailer and readding in the same page
//$usedBins = TrailerBins::getUsedBins($deliveryLoad->delivery_on, $delivery_id);

if(!isset($readonly)){ $readonly = false;}	

?>

<div class="delivery-load-form" id='delivery_count_<?= $deliveryCount ?>' delivery_count='<?= $deliveryCount ?>'>

	<div style='width: 100%; height:20px; padding-left: 10px'>
		<div style='width: calc(100% - 30px); float: left; '>
			<b>Delivery Date: <?= date("d M Y" ,strtotime($deliveryLoad->delivery_on)) ?></b>	
		</div>
		<div style='width: 26px;  float: left; '>
		<? if (!$readonly) { ?>
			
		
		<a title='Remove Load'>
			<div class='sap_icon_small sap_cross_small remove_delivery_load' delivery_count='<?= $deliveryCount ?>'></div>
		</a>
		<? } ?>
		</div>
	</div>
	<div class='delivery_load_alert_<?= $deliveryCount ?>' style='padding-left: 5px;border-radius: 10px; box-shadow: 0 10px 6px -6px #777; width: 100%; background-color: #f96464; padding-left: 5px'>
		
		
	</div>
	<input type='hidden' name='deliveryLoad[<?= $deliveryCount ?>][id]' value='<?= $deliveryLoad->id ?>'>
	<input type='hidden' name='deliveryLoad[<?= $deliveryCount ?>][delivery_on]' value='<?= $deliveryLoad->delivery_on ?>'>
	<input type='hidden' name='deliveryLoad[<?= $deliveryCount ?>][delivery_id]' value='<?= $deliveryLoad->delivery_id ?>'>
	<div style='height: 200px;'>
		<div class='delivery-load-truck delivery-load-truck<?= $deliveryCount ?>' delivery_load_truck_id=''>
			<?
			
			echo $this->render('/Trucks/_truck', [
				'deliveryCount' => $deliveryCount,
				'truck' => $deliveryLoad->truck,
				'truck_run_num' => $deliveryLoad->truck_run_num,
				'readonly' => $readonly,
		    	]);	
			?>
			
		</div>

		<div class='delivery-load-trailer<?= $deliveryCount ?>_1 delivery-load-trailer1'>
			
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
					'readonly' => $readonly,
					]
				
			)
			
			?>
			
			
		</div>
		<div class='delivery-load-trailer<?= $deliveryCount ?>_2 delivery-load-trailer2'>
			
			<?
			echo $this->render('/Trailers/_trailer',
					[
					'trailer_slot_num' => 2,
					'deliveryCount' => $deliveryCount, 
					'trailer' => $deliveryLoad->trailer2,
					'trailer_run_num' => $deliveryLoad->trailer2_run_num,
					'usedBins' => $usedBins,
					'selectedBins' => $deliveryLoad->getSelectedBins(),
					'readonly' => $readonly,
					]
				
			)
			
			?>
			
		</div>
	</div>
	

</div>
