<?php


/* @var $truck */
/* @var $deliveryCount */


if($truck == null) { ?>

	<div class='truck_empty_select'>
		<div class='truck_add_button' delivery_count='<?=  $deliveryCount ?>'>
			<a title='Add Truck'><div class='sap_icon_large sap_new_truck'></div></a>
		</div>
		
		
	</div>

<? } else { ?>

	<div class='truck_details' truck_id='<?= $truck->id ?>'>
		
		This is a truck
	</div>
	
<? } ?>