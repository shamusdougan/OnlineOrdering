<?php


/* 	@var $truck  - 			Truck Object to be rendered
/* 	@var $deliveryCount - 	target_delivery_load
	@var $truck_run_num - 	Delivery Run Number

*/





if($truck == null || is_int($truck)) { ?>

	<div class='truck_empty_select'>
		<div class='add_truck_link' deliveryCount='<?=  $deliveryCount ?>'>
			<a title='Add Truck'><div class='sap_icon_large sap_new_truck'></div></a>
		</div>
		
		
	</div>

<? } else { ?>

	<div class='truck_details'>
			
		<input type='hidden' class='delivery_load_truck_id' truck_run_num='<?= $truck_run_num ?>' name='deliveryLoad[<?= $deliveryCount ?>][truck_id]'  value='<?= $truck->id ?>' >
		<input type='hidden' name='deliveryLoad[<?= $deliveryCount ?>][truck_run_num]'  value='<?= $truck_run_num ?>' >
	
		
		
		<div style='width: 100%; height: 20px;'>
			<div style='padding-left: 5px; width: calc(100% - 30px); height:40px;float: left; overflow: hidden;'>
				<b><?= substr($truck->registration." (".$truck->description.")", 0 , 40) ?></b><br>	
				<?= $truck->getTruckTypeString()?>
			</div>
			<div style='width: 30px; height:100%; float: left'>
				<div class='sap_icon_small sap_cross_small remove_delivery_load_truck' deliveryCount='<?= $deliveryCount ?>'></div>
			</div>
			<div style='width: 100%; height: 20px; float: left;'><b>
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
			?></b>
		</div>
		</div>
		
		
		<img src='../../images/truck_outline.png' height='120px'><br>	
		
	</div>
	
<? } ?>