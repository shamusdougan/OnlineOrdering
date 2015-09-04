

<div class='truck_allocation_section' id='truck_allocate_<?= $truck->id ?>' style='border: 1px solid; width: 100%; height: 200px; margin-top: 10px;'>
	<div style='width: 100%; height: 20px; text-align: right '>
		<div style='float: left'><b>Truck: <?= $truck->registration." (".$truck->description.")" ?></b></div>
		<div class='sap_icon_small sap_cross_small close_allocation_link' style='float: right' truck_id='<?= $truck->id ?>'></div>
	</div>
	<div style='width: 100%'>
		<div style='width: 200px; padding-left: 5px'>
			<img src='../../images/truck_outline.png' height='150px'>	
			Select trailers
		</div>
		
	</div>
</div>




