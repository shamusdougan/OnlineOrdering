<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use kartik\widgets\select2;

/**
* 
* @var $data -> array of trailers to display
* @var $target_delivery_load -> the delivery Load to update the trailer info on
*	@var $trailer_slot_num -> the trailer slot the in the target delivery_load to update,
* 
*/


?>

<div style='height: 80px;'>
<div style='width: 350px; float: left'>
<select id='add_trailer_select'>
	<?
	foreach($data as $trailer_id => $trailerName)
		{
		echo "<option value='".$trailer_id."'>".substr($trailerName, 0, 35)."</option>";	
		}
	?>	
</select>
</div>

	<div style='float: right'>
		<button class='add_trailer_button' 
			target_delivery_load='<?= $target_delivery_load ?>'
			trailer_slot_num='<?= $trailer_slot_num ?>'
			>
		Add Selected</button>
	</div>
</div>