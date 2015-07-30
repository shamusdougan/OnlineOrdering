<?php
namespace app\components;

use yii\base\Widget; 
use yii\helpers\Html;



 
/*
 * Data structure for the param
 * 
 * 
 * array(
 * 		array("label" => "Text under button", "button" => "button class name", "url" => array("urlpath", "additionalGetVar" => "value"))
 * 	) 
 */


class actionButtons extends Widget {
 
    public $items;
    public $message;
    public $iconPath = "/images/icons/";

 
public function init()
	{
	parent::init();
	
	if($this->items == null)
		{
		$this->items = array();
		}
	
	}
	
public function run()
	{
		
		
	$returnString = "<fieldset class='sapFieldSet'>
    					<legend class='sapFieldSetLegend'>Actions</legend>";
	
	
	foreach($this->items as $actionItem){
     	if(!isset($actionItem['button'])){
     		$actionItem['button'] = "alert";
     		$actionItem['label'] = "No Icon Set";
     		}
     	
     	$returnString .= "<div class='sap_button'>";
     	$returnString .= str_replace("</a>", "", Html::a("" ,$actionItem['url'], isset($actionItem['linkOptions']) ? $actionItem['linkOptions'] : array()));
     	$returnString .= "<div class='sap_icon ".$actionItem['button']."'></div><div class='sap_buttonText'>".$actionItem['label']."</div></div></A>";
     		
     	if(isset($actionItem['action']))
     		{
				
			}
     		
     	
    	}
	
	
	
	
	$returnString .= "</fieldset>";
	return $returnString;
	}

    
	public function generateSubmit()
	{
		
		
		
		
	}
    	
}
?>
