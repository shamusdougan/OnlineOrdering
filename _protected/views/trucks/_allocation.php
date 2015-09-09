<?php 

use yii\helpers\Html;
use yii\helpers\ArrayHelper;


$selectedTrailersIDs = ArrayHelper::map($selectedTrailers, 'id', 'id') ;

?>

<div class='truck_allocation_section' id='truck_allocate_<?= $truck->id ?>' style='border: 1px solid; width: 100%; height: 200px; margin-top: 10px;'>
	<div style='width: 100%; height: 20px; text-align: right '>
		<div style='float: left'><b>Truck: <?= $truck->registration." (".$truck->description.")" ?></b></div>
		<div class='sap_icon_small sap_cross_small close_allocation_link' style='float: right' truck_id='<?= $truck->id ?>'></div>
	</div>
	<div style='width: 100%; height: 195px;'>
		<div style='width: 350px; padding-left: 5px; float: left'>
			<img src='../../images/truck_outline.png' height='100px'><br>			
			Trailer(s): <A class='trailer_select_link' truck_id='<?= $truck->id ?>' selected_trailers='<?= implode($selectedTrailersIDs, ",") ?>'>
			<? 
			
			if(count($selectedTrailers) == 0)
				{
					echo "Select Trailer(s)....";
				}
				
			echo "<ul>";
			foreach($selectedTrailers as $trailer) 
				{
					echo "<li>".$trailer->Registration."</li>";
				}
			echo "</ul>";
			
			?>
				
			</A>
			
		</div>
		
		
	</div>
</div>




