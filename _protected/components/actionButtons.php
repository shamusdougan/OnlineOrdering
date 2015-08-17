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
    public $iconPath = "/images/icons_action/";

 
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
     	$returnString .= "<a ";
     	
     	//Add the Href if the url is specififed
     	$returnString .= isset($actionItem['url']) ? " href='".$actionItem['url']."' " : "";
     	
     	
     	//If the submit and confirmation are speficied add both via jquery
     	if(isset($actionItem['confirm']) && isset($actionItem['submit']))
     		{
     		if(isset($actionItem['overrideAction']))
     			{
				$returnString .= " onclick='if(confirm(\"".$actionItem['confirm']."\")){ $(\"form#".$actionItem['submit']."\").attr(\"action\", \"".$actionItem['overrideAction']."\"); $(\"form#".$actionItem['submit']."\").submit();}' ";
				}
			else{
				$returnString .= " onclick='if(confirm(\"".$actionItem['confirm']."\")){ $(\"form#".$actionItem['submit']."\").submit();}' ";	
			}
			
			}
			
		//If just the confirm is specifed add the confirmation via jquery
		elseif(isset($actionItem['confirm']))
			{
			$returnString .= " onclick='return confirm(\"".$actionItem['confirm']."\")' ";
			}
		elseif(isset($actionItem['submit']))
			{
			$returnString .= " onclick='$(\"form#".$actionItem['submit']."\").submit();' ";
			}

     	
     	$returnString .= ">";
     	
     	
     	//$returnString .= str_replace("</a>", "", Html::a("" ,$actionItem['url'], isset($actionItem['linkOptions']) ? $actionItem['linkOptions'] : array()));
     	$returnString .= "<div class='sap_icon sap_".$actionItem['button']."'></div><div class='sap_buttonText'>".$actionItem['label']."</div>";
     	$returnString .= "</div></A>";
     		
     	
     	
    	}
	
	
	
	
	$returnString .= "</fieldset>";
	return $returnString;
	}

    
	
    	
}
?>
