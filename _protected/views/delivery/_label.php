<?php
 use app\models\Lookup;
 
?>


<div style='width: 100%; height: 100%; border: 1px solid'>
	<div style='width:100%; text-align: center'><img src="images/irwin-logo.gif" width='100px'></div>
	<div style='width: 100%; padding-top: 10px'>
		<table style='table-layout: fixed; width: 100%; font-size: 10px' >
		<tr>
			<td width='50%'><b>Date :</b></td>
			<td width='50%'><?= $delivery->delivery_on ?></td>
		</tr>
		<tr>
			<td ><b>Customer:</b></td>
			<td ><?= $delivery->customerOrder->client->Company_Name ?></td>
		</tr>
		<tr><td colspan='2'><br></td></tr>		
		<tr>
			<td><b>Order Number:</b></td>
			<td ><?= $delivery->customerOrder->Order_ID ?></td>
		</tr>
		<tr>
			<td><b>Bin Number:</b></td>
			<td><?= $delivery->deliveryLoad[0]->getTruckBinsString() ?></td>
		</tr>
		<tr>
			<td><b>Truck:</b></td>
			<td><?= $delivery->deliveryLoad[0]->truck->registration ?></td>
		</tr>
		<tr>
			<td><b>Product:</b></td>
			<td><?= $delivery->customerOrder->Name ?></td>
		</tr>
	</table>
		
	</div>
</div>
