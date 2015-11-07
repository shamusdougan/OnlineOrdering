<?php


/* @var $truck */
/* @var $deliveryCount */
if(!isset($trailer1_id)){$trailer1_id = null;}
if(!isset($trailer2_id)){$trailer2_id = null;}



if($truck == null) { ?>

	<div class='truck_empty_select'>
		<div class='select_truck_button' delivery_count='<?=  $deliveryCount ?>'>
			<a title='Add Truck'><div class='sap_icon_large sap_new_truck'></div></a>
		</div>
		
		
	</div>

<? } else { ?>

	<div class='truck_details' truck_id='<?= $truck->id ?>' delivery_count='<?=  $deliveryCount ?>'>
		<input type='hidden' id='delivery_load<?= $deliveryCount?>_max_trailers' value='<?= $truck->max_trailers ?>' ?>
		<input type='hidden' id='delivery_load<?= $deliveryCount?>_trailer1_id' value='<?= $trailer1_id ?>' ?>
		<input type='hidden' id='delivery_load<?= $deliveryCount?>_trailer2_id' value='<?= $trailer2_id ?>' ?>
		
		<b>Truck: <?= $truck->registration." (".$truck->description.")" ?></b><br>
		<img src='../../images/truck_outline.png' height='150px'><br>	
		
	</div>
	
<? } ?>