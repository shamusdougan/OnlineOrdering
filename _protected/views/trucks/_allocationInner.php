<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;



if(!isset($delivery)){ $delivery = null;};
?>


<div style='width: 100%; text-align: right '>

		<div class='sap_icon_small sap_cross_small close_allocation_link' style='float: right' delivery_id='<?= $delivery == null ? "" : $delivery->id ?>' truck_id='<?= $truck->id ?>'></div>
	</div>
	<div style='width: 100%; height: 195px;'>
		<div style='width: 250px; padding-left: 5px; float: left'>
			<input type='hidden' name='truck_id[]' value='<?= $truck->id ?>'/>
			<b>Truck: <?= $truck->registration." (".$truck->description.")" ?></b><br>
			
		
			Trailer(s): <A class='trailer_add_link trailer_add_link_id' delivery_id='<?= $delivery != null ? $delivery->id : "" ?>' truck_id='<?= $truck->id ?>' >Add Trailer(s)</A>		
		
				
	
			
			<img src='../../images/truck_outline.png' height='150px'><br>			
			
		</div>
		<div id='trailer_start_<?= $truck->id?>'>
		<? 
	
		foreach($selectedTrailers as $trailer)
			{ 
			echo $this->render("/Trailers/_trailer", [
				'trailer' => $trailer,
				'truck_id' => $truck->id,
				'delivery' => $delivery,
				'usedTrailerBins' => $usedTrailerBins,
				
				]);
			}
		?>
		</div>
		
	</div>	
		
</div>