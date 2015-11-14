<?php


foreach($delivery->deliveryLoad as $deliveryLoadObject){
	
?>

<div style='width: 100%;'>

	<div style='width: 100%; height: 150px;'>
		<table width='100%' >
			<tr>
				<td width='100px' rowspan='2'><img src="images/irwin-logo.gif" width='100px' alt="Irwin Logo"> </td>
				<td width='400px' height='10px' ><span style='font-size: 22'>IRWIN STOCKFEEDS LOADER SHEET</span></td>
				<td valign="bottom"> Order: <?= $delivery->customerOrder->Order_ID?></td>
			</tr>
			<tr>
				<td> 
				<table>
					<tr>
						<td width='100px'>Date:</td>
						<td><?= date("d M Y", strtotime($delivery->delivery_on))?></td>
					</tr>
					<tr>
						<td width='100px'>Customer:</td>
						<td><?= $delivery->customerOrder->client->Company_Name ?></td>
					</tr>
					<tr>
						<td width='100px' valign='top'>Location:</td>
						<td><?= $delivery->customerOrder->client->Address_1 ?></td>
					</tr>
				</table>
				
				
				
				
				
				
				</td>
				
				<td> </td>
			</tr>
			
			
		</table>	
	 
	 	<table style='width: 100%'>
	 		<tr>
	 			<td width='25%'>Mixed to Bin: Bin 1</td>
	 			<td width='25%'>
	 				<table width='100%'>
	 					<tr>
	 						<td width='50%'>Truck Bin: </td>
	 						<td wdith='50%'><?= $deliveryLoadObject->getTruckBinsString() ?></td>
	 					</tr>
	 				</table>
	 			
	 			</td>
	 			<td width='25%'>
	 				<table width='100%'>
	 					<tr>
	 						<td width='50%'>Rego: </td>
	 						<td wdith='50%'><?= $deliveryLoadObject->truck->registration ?></td>
	 					</tr>
	 				</table>
	 			</td>
	 			<td width='25%'>
	 				<table width='100%'>
	 					<tr>
	 						<td width='50%'>Batch Size: </td>
	 						<td wdith='50%'>
	 						<?= $delivery->num_batches." x ".number_format(($deliveryLoadObject->load_qty / $delivery->num_batches), 3)."T" ?>
	 						</td>
	 					</tr>
	 				</table>
	 			</td>
	 		</tr>
	 		
	 		
	 	</table>
		
	</div>
	<div style='width: 100%; height: 620px;' >
		<table >
			<tr style='background-color: #c6c6c6'>
				<td width='350px'><b>PRODUCT</B></td>
				<td width='100px'></td><b></b></td>
				<td width='250px'><b>WEIGHT</B></td>
			</tr>
			<?
			$boxesWidth = '150';
			$imageWidth = min(($boxesWidth / $delivery->num_batches), 30);
			foreach($delivery->customerOrder->ingredients as $orderIngredient)
				{
					echo "<tr>";
					echo "<td><span style='font-size: 22px'>".$orderIngredient->product->Name."</spant></td>";
					echo "<td align='right'><span style='font-size: 18px'>".number_format($orderIngredient->ingredient_percent, 3)."%</span></td>";
					echo "<td align='right'><span style='font-size: 18px'>".number_format(((($delivery->customerOrder->Qty_Tonnes / $delivery->num_batches) * $orderIngredient->ingredient_percent) / 100), 3)."T </span>";
					for($i=0; $i < $delivery->num_batches; $i++)
						{
							echo "<img src='images/tick-box.png' width='".$imageWidth."'>";
						}
					
					
					echo "</td>";
					echo "</tr>";
				}
			
			
			?>
			
		</table>
	
	
	</div>
	<div style='width: 100%; height: 100px; border: 1px solid'>Notes:<br>
		<?= $delivery->customerOrder->Order_instructions ?>
		
	</div>
	<div style='width: 100%; height: 100px; margin-top: 10px'>
		<table width='100%'>
			<tr>
				<td width='50%' rowspan='2' valign='top'>Mixed By:___________________________</td>
				<td width='50%'>BULK TOTAL: <?= $delivery->customerOrder->Qty_Tonnes ?>T</td>
			</tr>
			<tr>
				<td>ORDER TOTAL: 100.00%</td>
			</tr>
			
		</table>
	
	
	</div>
</div>
 
 <? } ?>
 