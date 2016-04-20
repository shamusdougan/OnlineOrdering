<?php 
use yii\helpers\Html;
use kartik\grid\GridView;
/**
* 
* 
* var $trailerList -> list of al the active trailers
* var $deliveryCount -> delivery Load the trailer is to be put into
* var $trailerSlot -> the delivery Slot the trailer is for
* var $selectiondate -> date the trailers are being selected for
* * 
* 
* 
*/


?>

<h2>Available Trailers for <?= $selectionDate ?></h2>

To Select a trailer from the list click on the check box to the right,<Br>
To create an additional delivery Run on the same day, select a trailer and click "create an additional delivery run" button. A new Trailer will be added to the top of the list to be selected <br><br>

<div style='width: 1000px; height: 800px; '>

	<div style='float: left; height: 600px; overflow-y: scroll'>
			
	<table style='wdith: 100%' id='trailer_select_table'>
		<tr>
		<th>Trailer</th>
		<th>Bins Left</th>
		<th>Tons Left</th>
		<th>Select</th>
		</tr>
		
		<tr>
			<td colspan='4'>Delivery Run 1</td>
			
			
		</tr>
	<?
	
	foreach($data as $dataRow)
	{
		echo "<tr>";
		echo "<td>".$dataRow['trailer']."</td>";
		echo "<td>".$dataRow['bins']."</td>";
		echo "<td>".$dataRow['tons']."</td>";
		echo "<td><input type='radio' name='trailer_row_select' value='".$dataRow['id']."' delivery_run_num='".$dataRow['delivery_run_num']."' deliveryCount='".$deliveryCount."' trailerSlot='".$trailerSlot."' ></td>";
		echo "</tr>";
	}
	
	
	
	?>	
	</table>			
			
						
				
	
	</div>
	<div style='width: 150px; float: left; height: 100%;'>

		<div>
			<button id='select_trailer_button' style='width: 100%' deliveryCount='<?= $deliveryCount ?>' trailerSlot='<?= $trailerSlot ?>'>Use Selected Trailer</button>
			<button id='add_run'>Create Additional Delivery Run</button>
		</div>
	</div>
</div>

<?

	
	?>