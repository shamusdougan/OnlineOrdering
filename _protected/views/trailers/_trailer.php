<?php

print_r($usedTrailerBins);

?>


<div style='width: 350px; margin-right: 30px; float:left;'>
	<div style='width: 100%'>
		Trailer: <b><?= $trailer->Registration ?> </b>
	</div>
	<div style='width: 100%; height: 130px'>
		<div style="width: 25%; height: 100%; float: left; padding-top: 10px;">
			Max: <?= $trailer->Max_Capacity ?><br>
			<?= $trailer->Auger ? "Auger<br>" : "" ?>
			<?= $trailer->Blower ? "Blower<br>" : "" ?>
			<?= $trailer->Tipper ? "Tipper<br>" : "" ?>
			Select All <input class='trailer_bin_select_all' trailer_id='<?= $trailer->id ?>' type='checkbox'>
		
		</div>
		<div style='width: 75%; height: 100%; float: left'>
			<?
			
			$binDivWidth = 100/$trailer->NumBins;
			foreach($trailer->trailerBins as $index => $trailerBin)
				{
					
				
		
				//This checks to see if the Bin has been used in this order, if so mark as used and allow modification
				if($delivery != null && ($binLoad = $delivery->getBinLoad($trailerBin->id)) > 0)
					{
					if($binLoad < $trailerBin->MaxCapacity)
						{
						$class = 'sap_trailer_partial';
						}
					else{
						$class = 'sap_trailer_full';
						}	
						
						
					echo "<div class='".$class."' style='width: ".$binDivWidth."%; border: 1px solid; height: 100%; float: left;  text-align:center;'>";
					echo $trailerBin->BinNo."<br>";						
					echo "<input class='trailer_bin_checkbox trailer_cb_id_".$trailer->id."' trailerbin_id='".$trailerBin->id."' capacity='".$trailerBin->MaxCapacity."' name='truck_load[".$truck_id."][".$trailerBin->id."][]' value='".$binLoad."' checked type='checkbox' />";		
					}
					
				elseif(array_key_exists($trailerBin->id, $usedTrailerBins))
					{
					echo "<div class='".$class."' style='width: ".$binDivWidth."%; border: 1px solid; height: 100%; float: left;  text-align:center;'>";
					echo $trailerBin->BinNo."<br>";						
					echo "<input class='trailer_bin_checkbox trailer_cb_id_".$trailer->id."' trailerbin_id='".$trailerBin->id."' capacity='".$trailerBin->MaxCapacity."' name='truck_load[".$truck_id."][".$trailerBin->id."][]' value='".$binLoad."' checked type='checkbox' disabled/>";		
						
					}
				
					
				//Trailer bin hasn't been used in this delivery or any other delviery.
				else{
					echo "<div class='sap_trailer_empty' style='width: ".$binDivWidth."%; border: 1px solid; height: 100%; float: left;  text-align:center;'>";
					echo $trailerBin->BinNo."<br>";
					echo "<input class='trailer_bin_checkbox trailer_cb_id_".$trailer->id."' trailerbin_id='".$trailerBin->id."' capacity='".$trailerBin->MaxCapacity."' name='truck_load[".$truck_id."][".$trailerBin->id."][]' value='0' type='checkbox' />";	
					}
				
				echo "</div>";
					
				}
			
			
			
			
			
			?>
		</div>
	</div>
	<div style='wdith: 100%; height: 35px'>
		
		<img src='../../images/trailer_outline.png' width='349px'><br>		
	</div>			
			
			
			
			
				
				
</div>
			
