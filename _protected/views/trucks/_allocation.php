<?php 

use yii\helpers\Html;

?>

<div class='truck_allocation_section' id='truck_allocate_<?= $truck->id ?>' style='border: 1px solid; width: 100%; height: 200px; margin-top: 10px;'>
	<div style='width: 100%; height: 20px; text-align: right '>
		<div style='float: left'><b>Truck: <?= $truck->registration." (".$truck->description.")" ?></b></div>
		<div class='sap_icon_small sap_cross_small close_allocation_link' style='float: right' truck_id='<?= $truck->id ?>'></div>
	</div>
	<div style='width: 100%; height: 195px;'>
		<div style='width: 300px; padding-left: 5px; float: left'>
			<img src='../../images/truck_outline.png' height='180px'>	
		</div>
		<div style='width: 300px; height: 179px; float: left; overflow-y: scroll;'>
			<?= Html::checkboxList('truck_trailer_select_'.$truck->id, null, $trailerList, array('template'=>'<tr><td >{label}</td><td>{input}</td></tr>')); ?>
			
		</div>
		
	</div>
</div>




