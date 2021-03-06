<?php 
use yii\helpers\Html;
use kartik\grid\GridView;
/**
* 
* 
* var $data -> list of al the active trailers
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

<div style='width: 800px; height: 800px; '>

	<div style='float: left; width: 70%; height: 500px; margin-right: 5px; overflow-y: scroll; border: 1px solid; padding: 2px'>
			
	<table style='width: 100%' id='trailer_select_table'>
		<tr bgcolor='#003366' style='color: #FFFFFF; size: 14px'>
		<th style='padding-left: 5px'>Trailer</th>
		<th style='padding-left: 5px'>Bins Left</th>
		<th style='padding-left: 5px'>Tons Left</th>
		<th style='padding-right: 5px'></th>
		<th align=center style='padding-left: 5px'>Select</th>
		</tr>
		
		
	<?

	foreach($data as $trailer_run_num => $dataSection)
	
	{
		echo "<tr bgcolor='#6699ff'>";
		echo "<td colspan='5' class='run_num_header' trailer_run_num='".$trailer_run_num."' align=center><b>Delivery Run ".$trailer_run_num."</b></td>";
		echo "</tr>";
		
		
		$odd = true;
		foreach($dataSection as $dataRow)
			{
			if($odd)
				{
				echo "<tr class='select_trailer_id_".$dataRow['id']."' bgcolor='#ccddff'>";	
				}
			else{
				echo "<tr class='select_trailer_id_".$dataRow['id']."' bgcolor='#e6eeff'>";	
				}	
				
				
			echo "<td>".$dataRow['trailer']."</td>";
			echo "<td>".$dataRow['bins']."</td>";
			echo "<td>".$dataRow['tons']."</td>";
			if($dataRow['used'])
				{
				echo "<td><A class='add_trailer_run' 
						trailer_name='".$dataRow['trailer']."' 
						trailer_id='".$dataRow['id']."' 
						deliveryCount='".$deliveryCount."'
						trailerSlot='".$trailerSlot."'
						bins = '".$dataRow['maxBins']."'
						tons = '".$dataRow['maxTons']."'
						style='cursor: pointer'>Add Run <span class='glyphicon glyphicon-arrow-down'></span></a></td>";					
				}
			else{
				echo "<td></td>";
				}
			
			//If there are no more bins available on that trailer you cant select it	
			if($dataRow['allowSelect'])
				{
				echo "<td align=center><input type='radio' name='trailer_row_select' 
						value='".$dataRow['id']."' 
						delivery_run_num='".$dataRow['delivery_run_num']."' 
						deliveryCount='".$deliveryCount."' 
						trailerSlot='".$trailerSlot."'
						 ></td>";
				}
			else{
				echo "<td></td>";
			}
			
		
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
	<div style='width: 20%; float: left;  padding-top: 50px; height: 500px; '>

		<div>
			<button id='select_trailer_button' style='width: 100%; height: 60px' deliveryCount='<?= $deliveryCount ?>' >Use Selected Trailer</button>
			
		</div>
	</div>
</div>

<?

	
	?>