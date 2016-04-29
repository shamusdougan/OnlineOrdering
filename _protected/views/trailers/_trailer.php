<?
namespace app\models;
use yii\helpers\Html;


/*

	@var - trailer - 				//trailer to be rendered
	@var = trailer_run_num			//The run number that is used for this trailer
	@var - trailer_slot_num			//The trailer slot number
	@var - deliveryCount			//The unique id of the deliveryLoad on the page
	@var - usedBins					//a list of bins that have already been used not included the selected bins  array(trailerbin_id => bin_load)
	@var - selectedBins				//a list of bins that has already selected for this array(trailerbin_id => bin_load)
*/


/**
* 
* 		Trailer Render for a given Trailer details
* 
*/

if(isset($trailer) && !is_int($trailer)) { ?>


<div class='trailer_display_<?= $trailer->id ?> trailer_details' style='width: 350px; padding-left: 5px; margin-right: 30px; float:left;'>


	<input type='hidden' class='delivery_load_trailer_id' trailer_run_num='<?= $trailer_run_num ?>' name='deliveryLoad[<?= $deliveryCount ?>][trailer<?= $trailer_slot_num?>_id]' value='<?= $trailer->id ?>' >
	<input type='hidden' name='deliveryLoad[<?= $deliveryCount ?>][trailer<?= $trailer_slot_num?>_run_num]' value='<?= $trailer_run_num ?>' >
	
	<span class='trailer<?= $trailer_slot_num?>_auger' value='<?= $trailer->Auger ?>'>
	<span class='trailer<?= $trailer_slot_num?>_blower' value='<?= $trailer->Blower ?>'>
	<span class='trailer<?= $trailer_slot_num?>_tipper' value='<?= $trailer->Tipper ?>'>
	
	<div style='width: 100%'>
		<b><?= $trailer->Registration ?> </b>
		
		<?
		if(!count($usedBins))
			{ ?>
				
			
			<a class='remove_trailer_link' 
			deliveryCount='<?= $deliveryCount ?>'
			trailer_slot_num='<?= $trailer_slot_num ?>'
			>(Remove)</a>
		<? } ?>
		<b>
			<? if($trailer_run_num == 2 ) 
				{
				echo "2nd Delivery  Run<br>";
				}
			elseif ($trailer_run_num == 3)
				{
				echo "3rd Delivery Run <br>";
				}
			elseif($trailer_run_num > 3){
				echo $trailer_run_num. "th Delivery Run<br>";
				}
			else{
				echo "<br>";
				}
			?></b>
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
				if(array_key_exists($trailerBin->id, $selectedBins))
					{
					if($selectedBins[$trailerBin->id] < $trailerBin->MaxCapacity)
						{
						$class = 'sap_trailer_partial';
						}
					else{
						$class = 'sap_trailer_full';
						}	
					echo "<div class='".$class."' style='width: ".$binDivWidth."%; border: 1px solid; height: 100%; float: left;  text-align:center;'>";
					echo "Bin: ".$trailerBin->BinNo."<br>(".$trailerBin->MaxCapacity." T)<br>";					
					echo "<input class='trailer_bin_checkbox trailer_cb_id_".$trailer->id." trailer_bin_".$deliveryCount."' 
								trailer_id='".$trailer->id."' 
								trailerbin_id='".$trailerBin->id."' 
								capacity='".$trailerBin->MaxCapacity."' 
								name='deliveryLoadBins[".$deliveryCount."][bins][".$trailerBin->id."]' 
								value='".$selectedBins[$trailerBin->id]."' 
								checked type='checkbox' />";		
					echo "</div>";	
					}
					
				//Trailer bin is being used by another delivery load
				elseif(array_key_exists($trailerBin->id, $usedBins))
					{
					echo "<div class='sap_trailer_used' style='background-color: grey; width: ".$binDivWidth."%; border: 1px solid; height: 100%; float: left;  text-align:center;'>";
					echo "<input type='hidden' class='bin_used_".$deliveryCount." trailer_bin_".$deliveryCount."' value='".$usedBins[$trailerBin->id]."'>";
					echo "Bin: ".$trailerBin->BinNo."<br>(".$trailerBin->MaxCapacity." T)<br>";
					
					echo "</div>";	
					}
				//Trailer bin hasn't been used in this delivery or any other delviery.
				else{
					echo "<div class='sap_trailer_empty' style='width: ".$binDivWidth."%; border: 1px solid; height: 100%; float: left;  text-align:center;'>";
					echo "Bin: ".$trailerBin->BinNo."<br>(".$trailerBin->MaxCapacity." T)<br>";
					echo "<input class='trailer_bin_checkbox trailer_cb_id_".$trailer->id."' 
							trailer_id='".$trailer->id."' 
							trailerbin_id='".$trailerBin->id."' 
							capacity='".$trailerBin->MaxCapacity."' 
							name='deliveryLoadBins[".$deliveryCount."][bins][".$trailerBin->id."]' 
							value='0' 
							type='checkbox' />";	
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
		<div class='select_trailer_button' >
				
				
			<a class='add_trailer_link' 
				title='Add Trailer'
				deliveryCount='<?= $deliveryCount ?>'
				trailer_slot_num='<?= $trailer_slot_num ?>'
				
				><div class='sap_icon_large sap_new_truck'></div></a>
		</div>
	</div>



<? } ?>
			
