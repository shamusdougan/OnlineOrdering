<?php


/* 	@var $truck  - 			Truck Object to be rendered
/* 	@var $deliveryCount - 	target_delivery_load
	@var $truck_run_num - 	Delivery Run Number

*/





if($truck == null) { ?>

	<div class='truck_empty_select'>
		<div class='select_truck_button' deliveryCount='<?=  $deliveryCount ?>'>
			<a title='Add Truck'><div class='sap_icon_large sap_new_truck'></div></a>
		</div>
		
		
	</div>

<? } else { ?>

	<div class='truck_details'>
			
		<input type='hidden' name='deliveryLoad[<?= $deliveryCount ?>][truck_id]'  value='<?= $truck->id ?>' >
		<input type='hidden' name='deliveryLoad[<?= $deliveryCount ?>][truck_run_num]'  value='<?= $truck_run_num ?>' >
	
		
		<b>Truck: <?= $truck->registration." (".$truck->description.")" ?></b><br>
		<? if($truck_run_num == 2 ) 
				{
				echo "2nd Delivery  Run<br>";
				}
			elseif ($truck_run_num == 3)
				{
				echo "3rd Delivery Run <br>";
				}
			elseif($truck_run_num > 3){
				echo $truck_run_num. "th Delivery Run<br>";
				}
			else{
				echo "<br>";
				}
			?>
		<img src='../../images/truck_outline.png' height='130px'><br>	
		
	</div>
	
<? } ?>