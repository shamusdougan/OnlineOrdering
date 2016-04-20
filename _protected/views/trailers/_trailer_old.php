<?
namespace app\models;
use yii\helpers\Html;


/*

	@var - $trailer - trailer to be rendered
	@var - $delivery_run_num - The delivery run this is for
	@var - $target_delivery_load - the delivery load that his trailer slot sits in
	@var - $trailer_slot_num - the trailer slot that this is being rendered for.
	@var = $delivery_load_id - the Delivery Load this trailer is to be rendered for
	@var - $requestedDate - the date the delivery load is set for - used to get of list of bins already used
	
*/


/**
* 
* 		Trailer Render for a given Trailer details
* 
*/

if(isset($deliveryLoadTrailer)) {  


//get a list of the bins used//
//$usedTrailerOtherLoads = $trailer->getUsedBinsOtherLoads($delivery_run_num, $requestedDate, $delivery_load_id);

$deliveryLoadBins = Trailers::getDeliveryLoadBins($delivery_load_id);



$otherDeliveryLoadsBins = Trailers::getUsedBinsOtherLoads($delivery_run_num, $requestedDate, $delivery_load_id);


?>
<div class='trailer_display_<?= $trailer->id ?> trailer_details' style='width: 350px; margin-right: 30px; float:left;'
	trailer_id='<?= $trailer->id ?>' 
	delivery_run_num='<?= $delivery_run_num ?>'
	target_delivery_num='<?= $target_delivery_load ?>'
	trailer_slot_num='<?= $trailer_slot_num ?>'
	>
	
	<div style='width: 100%'>
		<b><?= $trailer->Registration ?> </b>
		<a class='remove_trailer_link' 
			target_delivery_load='<?= $target_delivery_load ?>'
			trailer_slot_num='<?= $trailer_slot_num ?>'
			trailer_id='<?= $trailer->id ?>'
			>(Remove)</a>
		
		
		
	</div>
	<div style='width: 100%; height: 130px'>
		<div style="width: 25%; height: 100%; float: left; padding-top: 10px;">
			Max: <?= $trailer->Max_Capacity ?><br>
			<?= $trailer->Auger ? "Auger<br>" : "" ?>
			<?= $trailer->Blower ? "Blower<br>" : "" ?>
			<?= $trailer->Tipper ? "Tipper<br>" : "" ?>
			Select All <input id='trailer_bin_select_all_<?= $trailer->id ?>' class='trailer_bin_select_all' trailer_id='<?= $trailer->id ?>' type='checkbox'>
		
		</div>
		<div style='width: 75%; height: 100%; float: left'>
			<input type='hidden' name='deliveryLoad[<?= $target_delivery_load ?>][trailers][]' value='<?= $trailer->id ?>'>
			<?
			
			$binDivWidth = 100/$trailer->NumBins;
			$count = 1;
			foreach($trailer->trailerBins as  $trailerBin)
				{
					
				//in case too many bins have been specified for the trailer
				if($count > $trailer->NumBins)
					{
					exit;
					}
				
				
				//Trailer has been used in this delivery
				if(array_key_exists($trailerBin->id, $deliveryLoadBins))
					{
					if($deliveryLoadBins[$trailerBin->id] < $trailerBin->MaxCapacity)
						{
						$class = 'sap_trailer_partial';
						}
					else{
						$class = 'sap_trailer_full';
						}	
					echo "<div class='".$class."' style='width: ".$binDivWidth."%; border: 1px solid; height: 100%; float: left;  text-align:center;'>";
					echo "Bin: ".$trailerBin->BinNo."<br>(".$trailerBin->MaxCapacity." T)<br>";					
					echo "<input class='trailer_bin_checkbox trailer_cb_id_".$trailer->id."' trailer_id='".$trailer->id."' trailerbin_id='".$trailerBin->id."' capacity='".$trailerBin->MaxCapacity."' name='deliveryLoad[".$target_delivery_load."][truck_load][".$trailer->id."][".$trailerBin->id."][]' value='".$deliveryLoadBins[$trailerBin->id]."' checked type='checkbox' />";		
					echo "</div>";	
					}
					
				//Trailer bin is being used by another delivery load
				elseif(array_key_exists($trailerBin->id, $otherDeliveryLoadsBins))
					{
					echo "<div class='sap_trailer_used' style='background-color: grey; width: ".$binDivWidth."%; border: 1px solid; height: 100%; float: left;  text-align:center;'>";
					echo "<input type='hidden' class='trailer_cb_id_".$trailer->id."' value='1'>";
					echo "Bin: ".$trailerBin->BinNo."<br>(".$trailerBin->MaxCapacity." T)<br>";
					
					echo "</div>";	
					}
				//Trailer bin hasn't been used in this delivery or any other delviery.
				else{
					echo "<div class='sap_trailer_empty' style='width: ".$binDivWidth."%; border: 1px solid; height: 100%; float: left;  text-align:center;'>";
					echo "Bin: ".$trailerBin->BinNo."<br>(".$trailerBin->MaxCapacity." T)<br>";
					echo "<input class='trailer_bin_checkbox trailer_cb_id_".$trailer->id."' trailer_id='".$trailer->id."' trailerbin_id='".$trailerBin->id."' capacity='".$trailerBin->MaxCapacity."' name='deliveryLoad[".$target_delivery_load."][truck_load][".$trailer->id."][".$trailerBin->id."][]' value='0' type='checkbox' />";	
					echo "</div>";
					}
				
				
	
				
				
				$count++;
				}
			
			
			
			
			
			?>
		</div>
	</div>
	<div style='width: 100%; height: 35px'>
		
		<img src='../../images/trailer_outline.png' width='350px'><br>		
	</div>			
</div>

<?
/**
* 
* 		Trailer Render for an available trailer select
* 
*/
} else { ?>


	<div class='trailer_empty_select'>
		<div class='select_trailer_button' 
				target_delivery_load='<?= $target_delivery_load ?>'
				trailer_slot_num='<?= $trailer_slot_num ?>'
				delivery_run_num='<?= $delivery_run_num ?>'>
			<a title='Add Trailer'><div class='sap_icon_large sap_new_truck'></div></a>
		</div>
	</div>



<? } ?>
			
<?php

?>