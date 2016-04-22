<?php 
use yii\helpers\Html;

/**
* 
* 
* @var  - $data the list of formated data to display an array with all the truck information
* @var -  $deliveryCount,
* @var - $selectionDate' 
* 
* 
*/


?>

<h2>Available Trucks for <?= $selectionDate ?></h2>

To Select a Truck from the list click on the check box to the right,<Br>
To create an additional delivery Run on the same day, select a Truck and click "create an additional delivery run" button. A new Truck will be added to the top of the list to be selected <br><br>

<div style='width: 1000px; height: 800px; '>

	<div style='float: left; height: 600px; overflow-y: scroll'>
			
	<table style='wdith: 100%' id='trailer_select_table'>
		<tr>
		<th>Truck</th>
		<th>Select</th>
		</tr>
		
		<tr>
			<td colspan='4'>Delivery Run 1</td>
			
			
		</tr>
	<?

	foreach($data as $dataRow)
	{
		echo "<tr>";
		echo "<td>".$dataRow['truck']."</td>";
	
		echo "<td><input type='radio' name='truck_row_select' 
				value='".$dataRow['id']."' 
				delivery_run_num='".$dataRow['delivery_run_num']."' 
				deliveryCount='".$deliveryCount."'
				max_trailers='".$dataRow['max_trailers']."',
				max_load='".$dataRow['max_load']."',
				auger='".$dataRow['Auger']."',
				blower='".$dataRow['Blower']."',
				tipper='".$dataRow['Tipper']."',
				
				  ></td>";
		echo "</tr>";
	}
	
	
	
	?>	
	</table>			
			
						
				
	
	</div>
	<div style='width: 150px; float: left; height: 100%;'>

		<div>
			<button id='select_truck_button' style='width: 100%' deliveryCount='<?= $deliveryCount ?>' >Use Selected Truck</button>
			<button id='add_truck_run'>Create Additional Delivery Run</button>
		</div>
	</div>
</div>

<?

	
	?>