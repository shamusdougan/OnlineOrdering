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

<div style='width: 800px; height: 800px; '>

	<div style='float: left; width: 60%; height: 500px; margin-right: 5px; overflow-y: scroll; border: 1px solid; padding: 2px'>
		
		
		<table style='width: 100%; border: 1px solid' id='truck_select_table'>
			<tr bgcolor='#003366' style='color: #FFFFFF'>
			<th style='padding-left: 5px'><B>Truck</B></th>
			<th style='padding-left: 5px'></th>
			<th align=center><B>Select</B></th>
			</tr>
			
		
		<?
		
		foreach($data as $delivery_run_num => $dataSection)
			{
			echo "<tr bgcolor='#6699ff'>";
			echo "<td colspan='4' class='run_num_header' truck_run_num='".$delivery_run_num."' align=center><b>Delivery Run ".$delivery_run_num."</b></td>";
			echo "</tr>";
			
			$odd = true;
			foreach($dataSection as $dataRow)
				{
				if($odd)
					{
					echo "<tr class='select_truck_id_".$dataRow['id']."' bgcolor='#ccddff'>";	
					}
				else{
					echo "<tr class='select_truck_id_".$dataRow['id']."' bgcolor='#e6eeff'>";	
					}
				echo "<td style='padding-left: 5px'>".$dataRow['truck']."</td>";
				if($dataRow['used'])
					{
					echo "<td><A class='add_truck_run' 
							truck_name='".$dataRow['truck']."' 
							next_truck_run_num='".($dataRow['delivery_run_num']+1)."' 
							truck_id='".$dataRow['id']."' 
							deliveryCount='".$deliveryCount."'
							style='cursor: pointer'>Add Run <span class='glyphicon glyphicon-arrow-down'></span></a></td>";					echo "<td></td>";
					}
				else{
					echo "<td></td>";
					echo "<td align=center><input type='radio' name='truck_row_select' 
						value='".$dataRow['id']."' 
						delivery_run_num='".$dataRow['delivery_run_num']."' 
						deliveryCount='".$deliveryCount."'
						trailer1_id='".$dataRow['trailer1_id']."'
						trailer2_id='".$dataRow['trailer2_id']."'
						
						>";
					}
				echo "</td>";
				echo "</tr>";
				
				
				$odd = !$odd;
				}
			}
		
			
		?>	
		</table>			
				
							
					
		
	</div>
	<div style='width: 5%; float: left; height: 500px; padding-top: 50px; margin-right: 5px;'>
		<img src='/images/arrows.png' width='50px' height='50px'>
		
	</div>
	<div style='width: 30%; float: left;  padding-top: 50px; height: 500px; '>

		<div>
			<button id='select_truck_button' style='width: 100%; height: 60px' deliveryCount='<?= $deliveryCount ?>' >Use Selected Truck</button>
			
		</div>
	</div>
</div>

<?

	
	?>