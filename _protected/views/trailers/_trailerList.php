<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use kartik\widgets\select2;

?>

<div style='height: 30px;'>
	<div style='float: right'>
		<button class='select_trailers_button' truck_id='<?= $truck_id ?>'>Use Selected</button>
	</div>
</div>
<div>
<table border=1>
	<thead>
		<tr style='font-weight: bold'>
			<td width='280px'>Trailer Registration</td>
			<td width='180px'>Used in Delivery</td>
			<td>Space</td>
			<td>Selected</td>
		</tr>
	</thead>
	<tbody>
	<?
	foreach($trailerList as $trailer)
		{
			$remainingSpace = $trailer->Max_Capacity;
			$deliveries = "";
			if(array_key_exists($trailer->id, $trailersUsed))
				{
				$remainingSpace -= $trailersUsed['used_space'];
				$deliveries = $trailersUsed['deliveries'];
				}
		
			$checked = "";
			if(array_search($trailer->id, $selected_trailers) !== false)
				{
				$checked = "CHECKED";
				}
			
			echo "<tr>";
			echo "<td>".substr($trailer->Registration, 0, 35)."</td>";
			echo "<td>".$deliveries."</td>";
			echo "<td align='center'>".$remainingSpace."</td>";
			echo "<td align='center'><input type='checkbox' class='trailer_select_".$truck_id."' value='".$trailer->id."' ".$checked." ></td>";
			echo "</tr>";
		}	
	?>	
	</tbody>
</table>

</div>
<div style='float: right'>
	<button class='select_trailers_button' truck_id='<?= $truck_id ?>'>Use Selected</button>
</div>
