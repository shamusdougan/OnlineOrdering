<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;


$selectedTrailersIDs = ArrayHelper::map($selectedTrailers, 'id', 'id') ;
if(!isset($delivery)){ $delivery = null;};
?>


<div style='width: 100%; text-align: right '>

		<div class='sap_icon_small sap_cross_small close_allocation_link' style='float: right' truck_id='<?= $truck->id ?>'></div>
	</div>
	<div style='width: 100%; height: 195px;'>
		<div style='width: 250px; padding-left: 5px; float: left'>
			<input type='hidden' name='truck_id[]' value='<?= $truck->id ?>'/>
			<b>Truck: <?= $truck->registration." (".$truck->description.")" ?></b><br>
			Trailer(s): <A class='trailer_select_link' truck_id='<?= $truck->id ?>' selected_trailers='<?= implode($selectedTrailersIDs, ",") ?>'>Change Trailer(s)</A>
			<img src='../../images/truck_outline.png' height='150px'><br>			
			
		</div>
		
		<? 
		
		foreach($selectedTrailers as $trailer)
			{ 
			echo $this->render("/Trailers/_trailer", [
				'trailer' => $trailer,
				'truck_id' => $truck->id,
				'delivery' => $delivery,
				
				]);
			}
		?>
		
		
	</div>	
		
</div>