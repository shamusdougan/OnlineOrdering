<?
//use yii\helpers\Html;

//$this->title = 'Print All';


$this->registerJs("

	
	var a4Printers = '".$a4_printer_list."'.split(',');
	var labelPrinters = '".$label_printer_list."'.split(',');
	var localPrinters = jsPrintSetup.getPrintersList().split(',');
	
	//assign the default printer if a match cannot be found
	var a4Printer = jsPrintSetup.getPrinter();
	var labelPrinter = jsPrintSetup.getPrinter();
	
	//iterate through the a4 printers looking for a match
	for (var i = 0; i < a4Printers.length; i++) 
		{
    	if(localPrinters.indexOf(a4Printers[i]) != -1)
    		{
			a4Printer = a4Printers[i];
			}
		}
	
	//iterate through the label printers looking for a match
	for (var i = 0; i < labelPrinters.length; i++) 
		{
    	if(localPrinters.indexOf(labelPrinters[i]) != -1)
    		{
			labelPrinter = labelPrinters[i];
			}
		}	
	
	
	$('#additiveLoader').text(a4Printer);
	$('#labels').text(labelPrinter);
	
	//alert('hello world');
	//Print the Additive Loader Sheet
	//jsPrintSetup.setPrinter(a4Printer);
	//jsPrintSetup.printWindow(window.frames[0]);	
	

	
	

	//Printer the Labels
	//jsPrintSetup.setPrinter(labelPrinter);
	//jsPrintSetup.setOption('numCopies', 2);
	//jsPrintSetup.setPrinter(labelPrinter);
	

	if(confirm('Print all'))
		{
		jsPrintSetup.setPrinter(labelPrinter);
		jsPrintSetup.printWindow(window.frames[0]);	
		}


	//$('#labelFrame').load(function(){
	//	jsPrintSetup.setPrinter(labelPrinter);
	//	jsPrintSetup.setOption('numCopies', 2);
	//	jsPrintSetup.printWindow(window);
	//	});

");



?>

 <h1><?= 'blah' //Html::encode($this->title) ?></h1>

<div style='width: 100%; border-radius: 5px; border: 1px solid; background-color: #EFEFEF; padding: 5px'>
Print All, this will print all of the doucments below.<br>
The Printer selected for each print job is selected by matching against a list of a4 or label printers configured under settings.<br>
</div><br>
<div>
<div>
	Additive/Loader Sheet printing to: <span id='additiveLoader'></span><br>
	Labels printing to: <span id='labels'></span>
</div><br>
<iframe id='additiveFrame' src='http://local.irwinstockfeeds.com.au/delivery/print-additive-loader-pdf?id=<?= $delivery_id ?>'></iframe>
<iframe id='labelFrame' src='http://local.irwinstockfeeds.com.au/delivery/print-label?id=<?= $delivery_id ?>'></iframe>
</div>