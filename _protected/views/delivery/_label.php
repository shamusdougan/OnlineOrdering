<?php
 use app\models\Lookup;
 
?>

<table rotate="-90" style='width: 200px; height: 430px; border: 1px solid;'>
	<tr>
		<td style='height: 160px; width:100%; text-align: center'><img src="images/irwin-logo.gif" ></td>
	</tr>
	<tr>
		<td style='height: 270px;'> 
			<table style=' padding-top: 20px; table-layout: fixed; width: 100%; font-size: 14px' >
				<tr>
					<td width='100%'><b>Date:</b> <?= $delivery->delivery_on ?></td>
				</tr>
				<tr>
					<td ><b>Customer:</b> <?= $delivery->customerOrder->client->Company_Name ?></td>
				</tr>
				<tr>
					<td><b>Order Number:</b> <?= $delivery->customerOrder->Order_ID ?></td>
				</tr>
				<tr>
					<td style='height: 50px'></td>
				</tr>
				<tr>
					<td><b>Bin Number:</b> <?= $delivery->deliveryLoad[0]->getTruckBinsString() ?></td>
				</tr>
				<tr>
					<td><b>Truck:</b> <?= $delivery->deliveryLoad[0]->truck->registration ?></td>
				</tr>
				<tr>
					<td><b>Product:</b> <?= $delivery->customerOrder->Name ?></td>
				</tr>
		
			</table>
		</td>
	</tr>
</table>
