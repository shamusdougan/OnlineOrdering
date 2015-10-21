<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use kartik\widgets\select2;

?>

<div style='height: 80px;'>
<div style='width: 350px; float: left'>
<select id='add_trailer_select'>
	
	

	<?
	foreach($trailerList as $trailer)
		{
			//only list the trailers that are not already on the list
			if(array_search($trailer->id, $selected_trailers) === false){
				
				$remainingSpace = $trailer->Max_Capacity;
				if(array_key_exists($trailer->id, $trailersUsed))
					{
					$remainingSpace -= $trailersUsed['used_space'];
					}
					
				echo "<option value='".$trailer->id."'>".substr($trailer->Registration, 0, 35)." (Remaining: ".$remainingSpace.")</option>";	
			}
		
		
			

		}	
	?>	
</select>
</div>

	<div style='float: right'>
		<button class='add_trailer_button' truck_id='<?= $truck_id ?>'>Add Selected</button>
	</div>
</div>