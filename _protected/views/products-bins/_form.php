<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use app\models\Lookup;

/* @var $this yii\web\View */
/* @var $model app\models\ProductsBins */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-bins-form">

     <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'products-bin-form']); ?>

    <?  echo Form::widget([
		    	'model'=>$model,
		    	'form'=>$form,
		    	'columns'=>4,
		    	'attributes'=>[
		    		'location_id' =>
		    			[
	    				'type' => Form::INPUT_DROPDOWN_LIST,
	    				'items' => Lookup::items("BIN_LOCATION"),
		    			],			 
		    		'order' =>
		    			[
	    				'type' => Form::INPUT_TEXT,
		    			],	
		    		'name' =>
		    			[
	    				'type' => Form::INPUT_TEXT,
		    			],	
		    		'bin_id' =>
		    			[
	    				'type' => Form::INPUT_TEXT,
		    			],
		    		'bin_type' =>
		    			[
		    			'type' => Form::INPUT_DROPDOWN_LIST,
	    				'items' => Lookup::items("BIN_TYPE"),
		    			],
		    		'capacity' =>
		    			[
		    			'type' => Form::INPUT_TEXT,
		    			],
		    		'description'=>
		    			[
		    			'type' => Form::INPUT_TEXTAREA,
		    			'columnOptions'=>['colspan'=>4],
		    			]	

		      	]
		    ]); ?>

    <?php ActiveForm::end(); ?>

</div>
