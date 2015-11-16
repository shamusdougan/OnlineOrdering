<?php
 use app\models\Lookup;
 
?>


<div style='width: 100%; height: 60px;'>
	<div style='float: left; width: 60px;'><img src="images/irwin-logo.gif" width='60px'></div>
	<div style='float: left; width: 300px; font-size: 28px; height: 50px; padding-top: 10px; padding-left: 5px'>IRWIN ORDER SHEET</div>
	<div style='float: right; width: 100px;'><b>Ref: </b><?= $order->Order_ID ?></div>
</div>
<div style='width: 100%; height: 20px; background-color: grey;  margin-top: 5px;'></div>
<div style='width: 100%'><br>
	<table style='table-layout: fixed; width: 700px' >
		<tr>
			<td width='25%'><b>Customer:</b></td>
			<td width='25%'><?= $order->client->Company_Name ?></td>
			<td width='25%'><b>Currently Milking:</b></td>
			<td width='25%'><? echo " XX " ?></td>
		</tr>
		<tr>
			<td width='25%' valign='top' rowspan='3'><b>Location:</b></td>
			<td width='25%' valign='top' rowspan='3'><?= $order->client->Address_1 ?></td>
			<td width='25%' valign='top'><b>CurrentlyFeed Rate:</b></td>
			<td width='25%' valign='top'><? echo " XX " ?></td>
		</tr>
		<tr>

			<td width='25%' valign='top'><b>Order Mass:</b></td>
			<td width='25%' valign='top'><?= number_format($order->Qty_Tonnes,3)." Tonnes" ?></td>
		</tr>
		<tr>

			<td width='25%' valign='top'><b>Requested Date:</b></td>
			<td width='25%' valign='top'><?= date("d M Y", strtotime($order->Requested_Delivery_by)) ?></td>
		</tr>		
		<tr>
			<td width='25%' valign='top'><b>Contact Phone:</b></td>
			<td width='25%' valign='top'><?= $order->client->Main_Phone ?></td>
			<td width='25%' valign='top'><b>Order Amount:</b></td>
			<td width='25%' valign='top'><?= "$".number_format($order->Price_Sub_Total,2)." (p/T)" ?></td>
		</tr>
		<tr>
			<td width='25%' valign='top'><b>Contact e-mail:</b></td>
			<td width='25%' valign='top'><?= $order->client->Email ?></td>
			<td width='25%' valign='top'><b>Discount:</b></td>
			<td width='25%' valign='top'><?= $order->Discount_Percent == 0 ? "" : $order->Discount_Percent."%" ?></td>
		</tr>
		<tr>
			<td width='25%' valign='top'><b>Delivery Location:</b></td>
			<td width='25%' valign='top'><?= $order->storage->Description ?></td>
			<td width='25%' valign='top'><b>Order Placed By:</b></td>
			<td width='25%' valign='top'><?= $order->createdByUser->fullname ?></td>
		</tr>
		<tr>
			<td width='25%' valign='top'><b>Truck Type:</b></td>
			<td width='25%' valign='top'> XX </td>
			<td width='25%' valign='top'><b>3rd Party Billing</b></td>
			<td width='25%' valign='top'></td>
		</tr>
		<tr>
			<td width='25%' valign='top'></td>
			<td width='25%' valign='top'> </td>
			<td width='25%' valign='top'><b>Split Billing</b></td>
			<td width='25%' valign='top'></td>
		</tr>		
	</table><br>
	<table style='font-size: 20px; table-layout: fixed; width: 700px; border-collapse: 0px' >
		<tr>
			<td style='background-color: grey; width: 50%'><b>Product</b></td>
			<td style='background-color: grey; width: 20%'><b>Type</b></td>
			<td style='background-color: grey; width: 15%; text-align: right'><b>%</b></td>
			<td style='background-color: grey; width: 15%; text-align: right'><b>Weight</b></td>
		</tr>
		<?php
		foreach($order->ingredients as $customerOrderIngredient)
			{
			echo "<tr>";
			echo "<td>".$customerOrderIngredient->product->Name	."</td>";
			echo "<td>".Lookup::item($customerOrderIngredient->product->Product_Category, "PRODUCT_CATEGORY")."</td>";
			echo "<td align='right'>".number_format($customerOrderIngredient->ingredient_percent,3) ."%</td>";
			echo "<td align='right'>".number_format($order->Qty_Tonnes * ($customerOrderIngredient->ingredient_percent/100),3) ." T</td>";
			}
		
		
		?>
		
	</table>
	<br><br>
	
	<div style='width: 100%; height: 50px; border: 1px solid'>
		<?= $order->Order_instructions ?>
		
		
	</div>
	
</div>
