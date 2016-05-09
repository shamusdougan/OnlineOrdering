<?php
namespace vendor\orderState;

use yii\base\Widget; 
use yii\web\assetBundle;
use yii\helpers\Html;
use app\models\CustomerOrders;
use app\models\Lookup;
use app\models\Delivery;
use app\models\Returns;



 
/*
 * Data structure for the param
 * 
 * 
 * array(
 * 		array("label" => "Text under button", "button" => "button class name", "url" => array("urlpath", "additionalGetVar" => "value"))
 * 	) 
 */


class orderStateWidget extends Widget {
 
    public $object;
    
    public $customerOrder;
    public $delivery;
    public $weighbridgeTicket;
    public $return;
    


	
public function run()
	{
	orderStateAsset::register($this->getView()); 
	
	//Check to see if the given object is an customer order
	if(is_a($this->object, "app\models\CustomerOrders"))
		{
		$this->customerOrder = $this->object;
		if($this->object->delivery)
			{
			$this->delivery = $this->object->delivery;
			$this->delivery->weighbridgeTicket ? $this->weighbridgeTicket = $this->delivery->weighbridgeTicket: $this->weighbridgeTicket = null;	
			$this->delivery->return ? $this->return = $this->delivery->return: $this->return = null;
			}
		else{
			$this->delivery = null;
			$this->weighbridgeTicket = null;
			$this->return = null;
			}
		}
		
	//if the given object is an delivery object
	elseif(is_a($this->object, "app\models\Delivery"))
		{
		$this->delivery = $this->object;
		$this->customerOrder = $this->object->customerOrder;
		$this->delivery->weighbridgeTicket ? $this->weighbridgeTicket = $this->delivery->weighbridgeTicket: $this->weighbridgeTicket = null;	
		$this->delivery->return ? $this->return = $this->delivery->return: $this->return = null;
		}
	
	
	elseif(is_a($this->object, "app\models\weighbridgeTicket"))
		{
		$this->weighbridgeTicket = $this->object;
		$this->delivery	 = $this->object->delivery;
		$this->customerOrder = $this->object->delivery->customerOrder;
		$this->delivery->return ? $this->return = $this->delivery->return: $this->return = null;
		}	
	
	elseif(is_a($this->object, "app\models\Returns"))
		{
		$this->return = $this->object;
		$this->delivery	 = $this->object->delivery;
		$this->customerOrder = $this->object->delivery->customerOrder;
		$this->weighbridgeTicket = $this->delivery->weighbridgeTicket;
		}	
	else{
		echo "invlid object given";
	}
	
	
	
	if($this->customerOrder)
		{
		$customerOrderSection = $this->renderCustomerOrder();	
		}
	else{
		$customerOrderSection = "Invalid Order";
		}
	
	
	$returnString = "<div class='sap_orderStatus'>";
	$returnString .= $this->renderSectionWrapper($customerOrderSection);
	if($this->delivery)
		{
		$returnString .= $this->renderSectionWrapper($this->renderDelivery());
		}
	if($this->weighbridgeTicket)
		{
		$returnString .= $this->renderSectionWrapper($this->renderWeighbridgeTicket());
		}
	if($this->return)
		{
		$returnString .= $this->renderSectionWrapper($this->renderReturn());
		}
	
	$returnString .= "</div>";

	return $returnString;



	}

    
   public function renderSectionWrapper($content)
   {
		$returnString = "<div class='sap_component'>";
		$returnString .= 	"<div class='sap_component_innner'>";
		$returnString .= 	$content;
		$returnString .= 	"</div>";
		$returnString .= "</div>";
   	
   	
   	
   		return $returnString;
   }
	
    
    
    
   public function renderCustomerOrder()
   {
   		$returnString = "<div class='innerDetails'>";
   		$returnString .= "<b>Order: ".Html::a($this->customerOrder->Order_ID, ['customer-order/update', 'id' => $this->customerOrder->id])."</b><br>";
   		$returnString .= $this->customerOrder->Name;
   		$returnString .= "</div>";
   		$returnString .= "<div class='innerState'>";
   		$returnString .= Lookup::item($this->customerOrder->Status, 'ORDER_STATUS');
   		$returnString .= "</div>";
   		return $returnString;
   }


	public function renderDelivery()
	{
		$returnString = "<div class='innerDetails'>";
		if($this->delivery->id)
			{
			$returnString .= "<b>Delivery: ".Html::a($this->delivery->Name, ['delivery/update', 'id' => $this->delivery->id])."</b><br>";	
			$returnString .= "Scheduled: ".$this->delivery->delivery_on;
			}
   		else{
			$returnString .= "<b>Delivery: Creating</b><br>";
			$returnString .= "Scheduled: TBA";
		}
   		
   		$returnString .= "</div>";
   		$returnString .= "<div class='innerState'>";
   		$returnString .= Lookup::item($this->delivery->status, "DELIVERY_STATUS");
   		$returnString .= "</div>";
   		return $returnString;
	}
    
    
    public function renderWeighbridgeTicket()
    {
		$returnString = "<div class='innerDetailsLong'>";
		if($this->delivery->id)
			{
			$returnString .= "<b>Weighbridge Ticket Number: ".Html::a($this->weighbridgeTicket->ticket_number, ['weighbridge-ticket/update', 'id' => $this->weighbridgeTicket->id])."</b><br>";	
			$returnString .= "Loaded: ".$this->weighbridgeTicket->date;
			}
   		else{
			$returnString .= "<b>Ticket Number: TBA</b><br>";
			$returnString .= "Loaded: TBA";
		}
   		
   		$returnString .= "</div>";
   		
   		return $returnString;
	}
    
     public function renderReturn()
    {
		$returnString = "<div class='innerDetailReturned'>";
		if($this->return->id)
			{
			$returnString .= "Returned Product: ".$this->return->amount." Tonnes";
			}
   		else{
			$returnString .= "Returned: TBA";
		}
   		
   		$returnString .= "</div>";
   		
   		return $returnString;
	}
    	
}
?>
