<?php 
use yii\helpers\Html;
/**
* 
* 
* var $truckList -> list of al the active tucks
* var $truckLoads -> list of all the current loads on the given date
* 
* 
* 
* 
*/


?>
<div style='width: 400px; height: 800px'>
	<div style='float: left'>
			
			<?= Html::listbox('available_trucks_lists', null, 
					$data,
					
					[
					'multiple'=>false,
					'size'=>20, 
					'style' => 'width:200px; height: 600px',
					'id' => 'available_trucks_control',
					
					]
				
				
				
				); ?>
	</div>
	<div style='width: 150px; float: left; height: 100%;'>

		<div>
			<button id='add_truck_use' style='width: 100%' target_delivery_load='<?= $target_delivery_load ?>'>Use Selected Truck</button>
			<button id='add_truck_use_addtional_run'>Create Additional Delivery Run For Truck</button>
		</div>
	</div>
</div>