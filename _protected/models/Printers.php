<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "printers".
 *
 * @property integer $id
 * @property string $name
 * @property integer $print_label
 * @property integer $print_a4
 */
class Printers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const PRINTTYPE_A4 = 1;
    const PRINTTYPE_LABEL = 2;
    
    public $type;
    public $autoprint;
     
     
    public static function tableName()
    {
        return 'printers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'print_label', 'print_a4'], 'required'],
            [['print_label', 'print_a4'], 'boolean'],
            [['name'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'print_label' => 'Print Label',
            'print_a4' => 'Print A4',
        ];
    }
    
    
    
    public function getA4PrinterString()
    {
		$printers = Printers::find()
				->where(['print_a4' => True])
				->all();
		$printerList = array();
		foreach($printers as $printer)
			{
			$printerList[] = $printer->name;
			}
		return implode(",", $printerList);
		
	}
	
	 public function getLabelPrinterString()
    {
		$printers = Printers::find()
				->where(['print_label' => True])
				->all();
		$printerList = array();
		foreach($printers as $printer)
			{
			$printerList[] = $printer->name;
			}
		return implode(",", $printerList);
		
	}
	
	/**
	* This function will check that the mozilla browser is being used and that the plugin is installed
	* 
	* @return
	*/
	public function checkPlugin($view)
	{
		
		$view->registerJs("
		ddd
		
		
		");
		
		
	}
	
	
	
	public function printSetup($view)
	{
		
	
			$javascript = "
			if (typeof jsPrintSetup == 'undefined') {
				$('#printer_warning').show();
				}
			else{";
			
			if($this->type == null || $this->type == Printers::PRINTTYPE_A4)
			
				$javascript .= "
					var a4Printers = '".$this->getA4PrinterString()."'.split(',');
					var localPrinters = jsPrintSetup.getPrintersList().split(',');
				
					//assign the default printer if a match cannot be found
					var a4Printer = jsPrintSetup.getPrinter();
				
				
					//iterate through the a4 printers looking for a match
					for (var i = 0; i < a4Printers.length; i++) 
						{
				    	if(localPrinters.indexOf(a4Printers[i]) != -1)
				    		{
							a4Printer = a4Printers[i];
							}
						}
					
					jsPrintSetup.setSilentPrint(false);
					jsPrintSetup.setPrinter(a4Printer);
					jsPrintSetup.setOption('shrinkToFit', true);
					jsPrintSetup.setOption('headerStrLeft', '');
					jsPrintSetup.setOption('headerStrRight', '');
					jsPrintSetup.setOption('printBGColors', true);
					jsPrintSetup.setOption('marginTop', 0);
				   	jsPrintSetup.setOption('marginBottom', 0);
				   	jsPrintSetup.setOption('marginLeft', 0);
				   	jsPrintSetup.setOption('marginRight', 0);";
			else{
				$javascript .= "
					var labelPrinters = '".$this->getLabelPrinterString()."'.split(',');
					var localPrinters = jsPrintSetup.getPrintersList().split(',');
					var labelPrinter = jsPrintSetup.getPrinter();
				
					//iterate through the label printers looking for a match
					for (var i = 0; i < labelPrinters.length; i++) 
						{
				    	if(localPrinters.indexOf(labelPrinters[i]) != -1)
				    		{
							labelPrinter = labelPrinters[i];
							}
						}	
				
				
					jsPrintSetup.setSilentPrint(false);
					jsPrintSetup.setPrinter(labelPrinter);
					jsPrintSetup.setOption('numCopies', 2);
					jsPrintSetup.setOption('headerStrLeft', '');
					jsPrintSetup.setOption('headerStrRight', '');
					jsPrintSetup.setOption('marginTop', 0);
				   	jsPrintSetup.setOption('marginBottom', 0);
				   	jsPrintSetup.setOption('marginLeft', 0);
				   	jsPrintSetup.setOption('marginRight', 0);";
		
				}
			if($this->autoprint)
				{
				$javascript .= "			jsPrintSetup.print();";
				}	
				
				
		$javascript .= "}";
		
		$view->registerJs($javascript);			
					
				
			
		echo "<div id='printer_warning' style='width: 800px; margin-bottom: 10px;  margin-left: auto; margin-right: auto; border-radius: 5px; border: 1px solid; background-color: #EFEFEF; padding: 5px; display: none'>
						<b>Warning: </b><br>
						The Printer plugin needs to be installed in order to allow automatic printing.<br>
						Click and download the printer plugin from here <a href='https://addons.mozilla.org/en-US/firefox/addon/js-print-setup/'>Install</a>
			</div>";
	}
}
