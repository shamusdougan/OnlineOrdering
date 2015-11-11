<?php


/* 	@var $truck  - Truck Object to be rendered
/* 	@var $deliveryCount - target_delivery_load
   	@var $trailer1_id - Trailer 1 ID
	@var $trailer2_id - TRailer2 ID
	@var $delivery_run_num - Delivery Run Number
	@var $delivery_load_id - Delivery_load_id -> may not be defined
*/

if(!isset($delivery_load_id)){$delivery_load_id = null;}
if(!isset($trailer1_id)){$trailer1_id = null;}
if(!isset($trailer2_id)){$trailer2_id = null;}



if($truck == null) { ?>

	<div class='truck_empty_select'>
		<div class='select_truck_button' delivery_count='<?=  $deliveryCount ?>'>
			<a title='Add Truck'><div class='sap_icon_large sap_new_truck'></div></a>
		</div>
		
		
	</div>

<? } else { ?>

	<div class='truck_details' 
			truck_max_trailers='<?= $truck->max_trailers ?>' 
			trailer1_id='<?= $trailer1_id ?>' 
			trailer2_id='<?= $trailer2_id?>' 
			truck_id='<?= $truck->id ?>' 
			delivery_run_num='<?= $delivery_run_num ?>'
			delivery_count='<?=  $deliveryCount ?>'
			delivery_load_id='<?= $delivery_load_id ?>'>
		<input type='hidden' id='delivery_load<?= $deliveryCount ?>_max_trailers' value='<?= $truck->max_trailers ?>' >
		<input type='hidden' id='delivery_load<?= $deliveryCount ?>_trailer1_id' value='<?= $trailer1_id ?>' >
		<input type='hidden' id='delivery_load<?= $deliveryCount ?>_trailer2_id' value='<?= $trailer2_id ?>' >
		<input type='hidden' name='deliveryLoad[<?= $deliveryCount?>][truck_id]' value='<?= $truck->id ?>'>
		<input type='hidden' name='deliveryLoad[<?= $deliveryCount?>][delivery_run_num]' value='<?= $delivery_run_num ?>'>
		
		<b>Truck: <?= $truck->registration." (".$truck->description.")" ?></b><br>
		<? if($delivery_run_num == 2 ) 
				{
				echo "2nd Delivery  Run<br>";
				}
			elseif ($delivery_run_num == 3)
				{
				echo "3rd Delivery Run <br>";
				}
			elseif($delivery_run_num > 3){
				echo $delivery_run_num. "th Delivery Run<br>";
				}
			else{
				echo "<br>";
				}
			?>
		<img src='../../images/truck_outline.png' height='130px'><br>	
		
	</div>
	
<? } ?>