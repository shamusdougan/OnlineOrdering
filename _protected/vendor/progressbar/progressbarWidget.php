<?php
namespace vendor\progressbar;

use yii\base\Widget; 
use yii\web\assetBundle;
use yii\helpers\Html;
use yii\helpers\Url;



 
/*
 * Data structure for the param
 * 
 * 
 * array(
 * 		array("label" => "Text under button", 
 				"icon" => "graphic file name", 
 				"url" => array("urlpath", "additionalGetVar" => "value"),
 				"Mouse Over Text")
 * 	) 
 */


class progressbarWidget extends Widget {
 
    public $items;
    public $current;
    public $message;
    public $iconPath = "/icons";

 
public function init()
	{
	parent::init();
	
	if($this->items == null)
		{
		$this->items = array();
		}
	
	if($this->current == null)
		{
		$this->current = 0;
		}
	}
	
public function run()
	{
	
	
	
	progressbarAsset::register($this->getView()); 


	end($this->items);
	$lastIndex = key($this->items);

	 
	$returnString = "<div class='progressWrapper'>\n";
	foreach($this->items as $index => $progressItem)
		{
			
			if(!array_key_exists('label', $progressItem))
				{
				die("Label not defined in progress item");
				}
			if(!array_key_exists('url', $progressItem))
				{
				$progress['url'] = null;
				}
			if(!array_key_exists('icon', $progressItem))
				{
				$progress['icon'] = null;
				}
			if(!array_key_exists('mouseOver', $progressItem))
				{
				$progress['mouseOver'] = null;
				}
			
			
			
			
			
			if($index == $lastIndex)
				{
				$arrowClass = "last_arrow";
				$iconClass = "next_icon";
				}
			elseif($index == $this->current)
				{
				$arrowClass = "current_arrow";
				$iconClass = "current_icon";
				}
			elseif($index < $this->current || $index > $this->current)
				{
				$arrowClass = "next_arrow";
				$iconClass = "next_icon";	
				}
			else{
				$arrowClass = "next_arrow";
				$iconClass = "next_icon";	
				
			}
				
				
				
			$returnString .= "<div class='progressElement'>\n";
			$returnString .= "	<div class='progressArrowWrapper ".$arrowClass."'>\n";
			if($progressItem['url'] != null)
				{
				$returnString .= "<A href='".Url::to($progressItem['url'])."' title='".$progressItem['mouseOver']."'>";
				$returnString .= "		<div class='progressArrowIcon ".$iconClass."'>".($index + 1)."</div>\n";
				$returnString .= "</A>\n";	
				$returnString .= "<A href='".Url::to($progressItem['url'])."'  title='".$progressItem['mouseOver']."'>";
				$returnString .= "	<div class='progressText'>".$progressItem['label']."</div>";	
				$returnString .= "</A>\n";		
				}
			else{
				$returnString .= "	<div class='progressArrowIcon ".$iconClass."'>".($index + 1)."</div>\n";
				$returnString .= "	<div class='progressText'>".$progressItem['label']."</div>";
				}
			$returnString .= "	</div>\n";
			
			
			

			
	
			$returnString .= "</div>\n";
			
		}
	
	
	$returnString .= "</div>\n";
	

	return $returnString;
	}

    
	
    	
}
?>
