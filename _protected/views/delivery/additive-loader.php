<?php

$this->registerJs("

	jsPrintSetup.setSilentPrint(false);
	jsPrintSetup.setPrinter('CutePDF Writer');
	jsPrintSetup.setOption('shrinkToFit', true);
	jsPrintSetup.setOption('headerStrLeft', '');
	jsPrintSetup.setOption('headerStrRight', '');
	jsPrintSetup.setOption('printBGColors', true);
	jsPrintSetup.setOption('marginTop', 0);
   	jsPrintSetup.setOption('marginBottom', 0);
   	jsPrintSetup.setOption('marginLeft', 0);
   	jsPrintSetup.setOption('marginRight', 0);
	jsPrintSetup.print();
	
");


if(!$delivery->deliveryLoad)
	{
	?>
	<page size="A4">
	<div style='width: 100%; height: 150px;'>
		<table width='100%' >
			<tr>
				<td width='100px' rowspan='2'><img src="/images/irwin-logo.gif" width='100px' alt="Irwin Logo"> </td>
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
	</div>
	<div style='width: 100%; height: 150px;'>
	
	<div style='font-size: 40px; width: 100%; text-align: center'>No Loads Allocated</div>
	</page>
	
	<?
	}



foreach($delivery->deliveryLoad as $deliveryLoadObject){
	
	
	/**
	* 
	* 
	* 
	* 
	* 
	* 
	* Addtivie Sheet
	* 
	* 
	* 
	* 
	* * 
	*/
	
	
	
?>
<page size="A4">
  <div style='width: 100%; height: 100%; padding-left: 50px; padding-top: 50px'>
	<div style='width: calc(100% - 55px); height: 255px;'>
		<table width='100%' >
			<tr>
				<td width='100px' rowspan='2'><img src="/images/irwin-logo.gif" width='100px' alt="Irwin Logo"> </td>
				<td width='400px' height='10px' ><span style='font-size: 21px; font-weight: bold'>IRWIN STOCKFEEDS ADDITIVE SHEET</span></td>
				<td valign="bottom" align='right'> <b>Order:</b> <?= $delivery->customerOrder->Order_ID?></td>
			</tr>
			<tr>
				<td> 
					<table>
						<tr>
							<td width='100px'><b>Date:</b></td>
							<td><?= date("d M Y", strtotime($delivery->delivery_on))?></td>
						</tr>
						<tr>
							<td width='100px'><b>Customer:</b></td>
							<td><?= $delivery->customerOrder->client->Company_Name ?></td>
						</tr>
						<tr>
							<td width='100px' valign='top'><b>Location:</b></td>
							<td><?= $delivery->customerOrder->client->Address_1 ?></td>
						</tr>
					</table>
				</td>
				<td> </td>
			</tr>
		</table>	
	 	<table style='width: 100%'>
	 		<tr>
	 			<td width='25%'><b>Mixed to Bin: </b><?= $delivery->productBin->name ?></td>
	 			<td width='35%'>
	 				<table width='100%'>
	 					<tr>
	 						<td width='35%'><b>Truck Bin: </b></td>
	 						<td width='65%'><?= $deliveryLoadObject->getTruckBinsString() ?></td>
	 					</tr>
	 				</table>
	 			
	 			</td>
	 			<td width='40%'>
	 				<table width='100%'>
	 					<tr>
	 						<td width='33%'></td>
	 						<td width='33%'><b>Rego: </b></td>
	 						<td width='33%'>
	 						<?
	 						if($deliveryLoadObject->truck)
	 							{
								echo  $deliveryLoadObject->truck->registration;
								}
							else{
								echo "No Truck";
							}
	 						?>
	 						 </td>
	 					</tr>
	 					<tr>
	 						<td width='33%'></td>
	 						<td><b>Batch Size: </b></td>
	 						<td>
	 						<?= $delivery->num_batches." x ".number_format(($delivery->delivery_qty / $delivery->num_batches), 3)."T" ?>
	 						</td>
	 					</tr>
	 				</table>
	 			</td>
	 			
	 		</tr>
	 		<tr>
	 			<td style="vertical-align: middle; height: 30px"><b>Vehicle Inspected: </b><img src='/images/tick-box.png' style="vertical-align:middle;" width='30px'></td>
	 			
	 			
	 	
	 			<td colspan='3' align='right'>
	 				<b>Added & Loaded by:</B>___________________________
	 			</td>
	 			
	 		</tr>
	 		
	 	</table>
	</div>
	<div style='width: calc(100% - 55px); height: 520px;' >
		<table width='100%' class='productTable'>
			<tr style='background-color: #c6c6c6'>
				<td width='40%'><b>Product</B></td>
				<td width='10%' align='right'><b>%</b></td>
				<td width='10%'><b>Weight</B></td>
				<td width='40%' ><b>Batching</B></td>
			</tr>
			<?
			$boxesWidth = '150';
			$imageWidth = min(($boxesWidth / $delivery->num_batches), 30);
			$additiveTotalPercent = 0;
			$additiveTotalWeight = 0;
			foreach($delivery->customerOrder->getAdditiveIngredients() as $orderIngredient)
				{	
					$additivePercent = $orderIngredient->ingredient_percent;
					$additiveWeight = ((($delivery->customerOrder->Qty_Tonnes / $delivery->num_batches) * $orderIngredient->ingredient_percent) / 100);
					$additiveTotalPercent += $additivePercent;
					$additiveTotalWeight += $additiveWeight;
					echo "<tr>";
						echo "<td><span style='font-size: 22px'>".$orderIngredient->product->Name."</spant></td>";
						echo "<td align='right'><span style='font-size: 18px'>".number_format($additivePercent, 3)."%</span></td>";
						echo "<td align='right'><span style='font-size: 18px'>".number_format($additiveWeight, 3)."T </span></td>";
						echo "<td align='right'><span style='font-size: 18px'>";
						for($i=0; $i < $delivery->num_batches; $i++)
							{
								echo "<img src='/images/tick-box.png' width='".$imageWidth."'>";
							}
					echo "</td>";
					echo "</tr>";
				}
			?>
		</table>
	</div>
	<div style='width: calc(100% - 55px); height: 100px; margin-top: 10px'>
		<table width='100%'>
			<tr>
				<td style='width: 25%'></td>
				<td style='width: 25%'>ADDITIVE TOTAL:</td>
				<td style='width: 25%'><?= number_format($additiveTotalPercent, 3) ?>%</td>
				<td style='width: 25%'><?= number_format($additiveTotalWeight, 3) ?>T</td>
			</tr>
			<tr>
				<td><img src='/images/tick-box.png' width='30px'> System Flushed</td>
				<td>ORDER TOTAL:</td>
				<td>100.000%</td>
				<td><?= $delivery->delivery_qty ?> </td>
			</tr>
			<tr>
				<td><img src='/images/tick-box.png' width='30px'> Sample Taken</td>
				<td colspan='3' style='border-bottom: 1px solid'></td>
				<td></td>
			</tr>
			<tr>
				<td><img src='/images/tick-box.png' width='30px'> Sample Inspected</td>
				<td colspan='3' style='border-bottom: 1px solid'></td>
				<td></td>
			</tr>
		</table>
	
	
	</div>
</div>
	

</page>

<?

/**
	* 
	* 
	* 
	* 
	* 
	* 
	* Loader Sheet
	* 
	* 
	* 
	* 
	* * 
	*/
	

?>
<page size="A4">
	<div style='width: 100%; height: 100%; padding-left: 50px; padding-top: 50px'>
		<div style='width: calc(100% - 55px); height: 255px;'>
			<table width='100%' >
				<tr>
					<td width='100px' rowspan='2'><img src="/images/irwin-logo.gif" width='100px' alt="Irwin Logo"> </td>
					<td width='400px' height='10px' ><span style='font-size: 21px; font-weight: bold'>IRWIN STOCKFEEDS LOADER SHEET</span></td>
					<td valign="bottom" align='right'> <b>Order:</b> <?= $delivery->customerOrder->Order_ID?></td>
				</tr>
				<tr>
					<td> 
						<table>
							<tr>
								<td width='100px'><b>Date:</b></td>
								<td><?= date("d M Y", strtotime($delivery->delivery_on))?></td>
							</tr>
							<tr>
								<td width='100px'><b>Customer:</b></td>
								<td><?= $delivery->customerOrder->client->Company_Name ?></td>
							</tr>
							<tr>
								<td width='100px' valign='top'><b>Location:</b></td>
								<td><?= $delivery->customerOrder->client->Address_1 ?></td>
							</tr>
						</table>
					</td>
					<td> </td>
				</tr>
			</table>	
		 	<table style='width: 100%'>
		 		<tr>
		 			<td width='25%'><b>Mixed to Bin: </b><?= $delivery->productBin->name ?></td>
		 			<td width='35%'>
		 				<table width='100%'>
		 					<tr>
		 						<td width='35%'><b>Truck Bin: </b></td>
		 						<td width='65%'><?= $deliveryLoadObject->getTruckBinsString() ?></td>
		 					</tr>
		 				</table>
		 			
		 			</td>
		 			<td width='40%'>
		 				<table width='100%'>
		 					<tr>
		 						<td width='33%'></td>
		 						<td width='33%'><b>Rego: </b></td>
		 						<td width='33%'>
		 						<?
		 						if($deliveryLoadObject->truck)
		 							{
									echo  $deliveryLoadObject->truck->registration;
									}
								else{
									echo "No Truck";
								}
		 						?>
		 						 </td>
		 					</tr>
		 					<tr>
		 						<td width='33%'></td>
		 						<td width='33%'><b>Batch Size: </b></td>
		 						<td width='33%'>
		 						<?= $delivery->num_batches." x ".number_format(($delivery->delivery_qty / $delivery->num_batches), 3)."T" ?>
		 						</td>
		 					</tr>
		 				</table>
		 			</td>
		 			
		 		</tr>
		 		<tr>
		 			<td style="vertical-align: middle; height: 30px"><b>Vehicle Inspected: </b><img src='/images/tick-box.png' style="vertical-align:middle;" width='30px'></td>
		 			
		 			
		 	
		 			<td colspan='3' align='right'>
		 				<b>Added & Loaded by:</B>___________________________
		 			</td>
		 			
		 		</tr>
		 		
		 	</table>
		</div>
		<div style='width: calc(100% - 55px); height: 520px;' >
		<table width='100%' class='productTable'>
			<tr style='background-color: #c6c6c6'>
				<td width='40%'><b>Product</B></td>
				<td width='10%' align='right'><b>%</b></td>
				<td width='10%'><b>Weight</B></td>
				<td width='40%' ><b>Batching</B></td>
			</tr>
			<?
			$boxesWidth = '150';
			$imageWidth = min(($boxesWidth / $delivery->num_batches), 30);
			$bulkTotalPercent = 0;
			$bulkTotalWeight = 0;
			foreach($delivery->customerOrder->getCommodityIngredients() as $orderIngredient)
				{	
					$additivePercent = $orderIngredient->ingredient_percent;
					$additiveWeight = ((($delivery->customerOrder->Qty_Tonnes / $delivery->num_batches) * $orderIngredient->ingredient_percent) / 100);
					$bulkTotalPercent += $additivePercent;
					$bulkTotalWeight += $additiveWeight;
					echo "<tr>";
						echo "<td><span style='font-size: 22px'>".$orderIngredient->product->Name."</spant></td>";
						echo "<td align='right'><span style='font-size: 18px'>".number_format($additivePercent, 3)."%</span></td>";
						echo "<td align='right'><span style='font-size: 18px'>".number_format($additiveWeight, 3)."T </span></td>";
						echo "<td align='right'><span style='font-size: 18px'>";
						for($i=0; $i < $delivery->num_batches; $i++)
							{
								echo "<img src='/images/tick-box.png' width='".$imageWidth."'>";
							}
					echo "</td>";
					echo "</tr>";
				}
			?>
		</table>
	</div>
		
		<div style='width: calc(100% - 55px); height: 100px; border: 1px solid'><b>Note:</b><br>
			<?= $delivery->customerOrder->Order_instructions ?>
		</div>
		<div style='width: 100%; height: 100px; margin-top: 10px'>
			<table width='100%'>
				<tr>
					<td width='50%' rowspan='2' valign='top'>Mixed By:___________________________</td>
					<td width='50%'>BULK TOTAL: <?=  $bulkTotalPercent ?>% </td>
				</tr>
				<tr>
					<td>ORDER TOTAL: 100.00%</td>
				</tr>
			</table>
		</div>
	</div>
</page>
<? } ?>
