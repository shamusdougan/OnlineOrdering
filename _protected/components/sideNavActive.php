<?php
namespace app\components;

use yii\base\Widget; 
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;





class sideNavActive extends Widget {
 
    public $controller;
    public $actions;
  

 
	
public function run()
	{
		$currentUrl = Url::current();
		$currentController = Yii::$app->controller->id;
		$currentAction = Yii::$app->controller->action->id;
		
		
		//first check that the controller matches, then check to see if the action matches
		if(is_array($this->controller) && array_search($currentController, $this->controller) !== false)
			{
			if($this->actions == null)
				{
				return true;					
				}
			else{
				if(array_search($currentAction, $this->actions) !== false)
					{
					return true;
					}
				}
			}
		if($currentController == $this->controller)
			{
				
			//if no actions have been set then all actions are assumed to make this active
			if($this->actions == null)
				{
				return true;					
				}
			else{
				if(array_search($currentAction, $this->actions) !== false)
					{
					return true;
					}
				}
			}
		return false;
	}
	
}

?>