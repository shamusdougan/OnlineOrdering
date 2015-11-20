<div style='margin-top: 5px; width: 100%; height: 400px; border: 1px solid;'>
	<div style='height: 90px;'>
		<div style='width: 20%; float: left; padding-left: 10px;'>
			<img src="images/irwin-logo.gif"  width='90px' alt="Irwin Logo">
		</div>
		<div style='width: 58%; float: left; text-align: center'>
			<span style='font-size: 28px; font-weight: bold'>IRWIN STOCKFEEDS</span><br>
			<span style='font-size: 8px'><b>ABN:</b> 20 145 497 374 <b>ACN:</b> 145 497 374</span><br>
			<span style='font-size: 11px'><b>WEIGHBRIDGE LOCATION: </b>Laurens Street North Melbourne Victoria 3051</span><br>
			<span style='font-size: 11px'><b>Phone: </b>03 9328 2681</span><b>Fax: </b>03 9328 3522</span><br>
		</div>
		<div style='width: 20%; float: left; text-align: right'>
			<img src="images/FeedSafe-Logo.jpg" width='100px' alt="Irwin Logo">
		</div>
	</div>
	<div style='width: 100%; height: 350px; padding-top: 10px; padding-left: 10px'>
		<div style='width: 40%; float: left; '>
			<span style='font-size: 13px; font-weight: bold;'>PRIVATE WEIGHBRIDGE</span>
				<div style='border-bottom: 1px solid; width: 100%;  padding-top: 10px'><b>FROM:</b> Irwin Stockfeeds </div>
				<div style='border-bottom: 1px solid; width: 100%;  padding-top: 5px'><b>TO:</b> <?= $weighbridgeTicket->delivery->customerOrder->client->Company_Name ?></div>
				<div style='border-bottom: 1px solid; width: 100%;  padding-top: 5px'><b>LOCATION:</b> <?= $weighbridgeTicket->delivery->customerOrder->client->Address_1_TownSuburb ?></div>
				<div style='border-bottom: 1px solid; width: 100%;  padding-top: 5px'><b>ORDER NO:</b> <?= $weighbridgeTicket->delivery->customerOrder->Order_ID ?></div>
				<div style='border-bottom: 1px solid; width: 100%;  padding-top: 5px'><b>REGISTRATION OF VEHICLE:</b> <?= $weighbridgeTicket->delivery->deliveryLoad[0]->truck->registration; ?></div>
				<div style='border-bottom: 1px solid; width: 100%;  padding-top: 5px'><b>OWNER OF VEHICLE:</b> Irwins</div>
				<div style='border-bottom: 1px solid; width: 100%;  padding-top: 5px'><b>DRIVER:</b> <?= $weighbridgeTicket->driver ?></div>
				<div style='border-bottom: 1px solid; width: 100%;  padding-top: 5px'><b>SMO:</b> <?= $weighbridgeTicket->smo_number ?></div>
				<div style='border-bottom: 0px solid; width: 100%;  padding-top: 5px; height: 90px; font-size: 10px' ><b>COMMENTS:</b> <?= substr($weighbridgeTicket->Notes, 0, 450) ?></div>
		</div>
		<div style='width: 57%; float: left; margin-left: 10px;'>
			<div style='width: 100%; height: 50px;text-align: right'>
				<table width='100%'>
					<tr>
						<td width='60%' align='right'><b>DATE:</B></td>
						<td width='20%' align='right'><?= date("d M Y", strtotime($weighbridgeTicket->date)); ?></td>
					</tr>
					<tr>
						<td width='60%' align='right'><b>Ticket No:</b></td>
						<td width='20%' align='right'><?= $weighbridgeTicket->ticket_number ?></td>
					</tr>
				</table>
				
				<b> </b> <span style='width: 200px;'></span>
			</div>
			<div style='width: 100%;'>
				<div style='width: 48%; float: left'>
					<table width='100%'  style='border: 1px solid; border-collapse: collapse;'>
						<tr >
							<td style='border: 1px solid; width: 50%; height: 60px'>MOGR</td>
							<td style='border: 1px solid; width: 50%'><?= $weighbridgeTicket->Moisture ?></td>
						</tr>
						<tr>
							<td style='border: 1px solid; width: 50%; height: 60px'>PRGR</td>
							<td style='border: 1px solid; width: 50%'><?= $weighbridgeTicket->Protein ?></td>
						</tr>
						<tr style='height: 25%'>
							<td style='border: 1px solid; width: 50%; height: 60px'>TWT</td>
							<td style='border: 1px solid; width: 50%'><?= $weighbridgeTicket->testWeight ?></td>
						</tr>
						<tr style='height: 25%'>
							<td style='border: 1px solid; width: 50%; height: 60px'>SCRN</td>
							<td style='border: 1px solid; width: 50%'><?= $weighbridgeTicket->screenings ?></td>
						</tr>
					</table>
				</div>
				<div style='width: 50%; float: left; padding-left: 3px'>
					<table width='100%'  style='border: 1px solid; border-collapse: collapse;'>
						<tr >
							<td style='border: 1px solid; width: 50%; height: 84px'>GROSS WEIGHT</td>
							<td style='border: 1px solid; width: 50%; padding-left: 10px'><?= number_format($weighbridgeTicket->gross, 3) ?></td>
						</tr>
						<tr>
							<td style='border: 1px solid; width: 50%; height: 84px'>TARE WEIGHT</td>
							<td style='border: 1px solid; width: 50%; padding-left: 10px'><?=  number_format($weighbridgeTicket->tare, 3) ?></td>
						</tr>
						<tr>
							<td style='border: 1px solid; width: 50%; height: 84px'>NET WEIGHT</td>
							<td style='border: 1px solid; width: 50%; padding-left: 10px'><?=  number_format($weighbridgeTicket->net, 3) ?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		
		
	</div>
	<div style='width: 100%; height: 30px'>
		<div style='width: 100%; border-bottom: 1px solid'>
		Signature
		</div>
	</div>
</div>