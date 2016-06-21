<?php

use app\models\Product;
use yii\helpers\Html;
use app\models\Lookup;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */

if(!isset($readOnly)){$readOnly = false;}
if(!isset($lockProductCode)){$lockProductCode = true;}

$this->registerJs(
    "$(document).on('change', '#".Html::getInputId($model, 'Mix_Type')."', function() 
    	{
    	
    	
		var product_type = $(this).val();
		if(product_type == ".Product::MIXTYPE_BASE.")
			{
			$('#product_price_list').show();
			$('#ingredient_list').hide();
			}
		else if (product_type == ".Product::MIXTYPE_COMPOSITE.")
			{
				
			$('#product_price_list').hide();
			$('#ingredient_list').show();
			}
    	
		
	});"
   );
?>
<div class="product-form">

   <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'product-form']); ?>
 
 <?= $form->errorSummary($model); ?>  
 	<?
 	

 	echo $form->field($model, 'Mix_Percentage_Total', ['template' => '{input}'])->hiddenInput()->label(false); 
 	
 	
 	
 //Customer Select options
		    echo Form::widget([
		    	'model'=>$model,
		    	'form'=>$form,
		    	'columns'=>3,
		    	'attributes'=>[
		    		'Product_ID' =>
		    			[
	    				'type' => Form::INPUT_TEXT,
	    				'options'=>
	    					[
	    					'disabled' => $lockProductCode,
	    					],
		    			],			 
		    		'Name' =>
		    			[
	    				'type' => Form::INPUT_TEXT,
	    				'options'=>
	    					[
	    					'disabled' => $readOnly,
	    					],
							
		    			],	
		    		'Product_Category' =>
		    			[
	    				'type' => Form::INPUT_WIDGET,
		    			'widgetClass' => '\kartik\widgets\Select2',
	    				'options'=>
	    					[
	    					'data' => Lookup::items("PRODUCT_CATEGORY"),
	    					'disabled' => $readOnly,
	    					],
							
		    			],	
		      	]
		    ]);
	?>

<div style='width: 600px'>
<?php
	
  echo Form::widget([
		    	'model'=>$model,
		    	'form'=>$form,
		    	'columns'=>3,
				'attributes'=>
					[
					'Mix_Type' => 
						[
						'type' => FORM::INPUT_WIDGET,
						'widgetClass' => '\kartik\widgets\Select2',
	    				'options'=>
	    					[
	    					'data' => Lookup::items("PRODUCT_MIXTYPE"),
	    					'disabled' => isset($model->id),
	    					],
	    				],
	    			'Status' =>
	    				[
	    				'type' => FORM::INPUT_DROPDOWN_LIST,
	    				'items' => Lookup::items("PRODUCT_STATUS"),
	    				
	    				],
	    			'price_pT' =>
	    				[
	    				'type' => FORM::INPUT_TEXT,
						'hAlign'=>'right',
						'options'=>
							[
							'readonly' => true,
							],
						
	    				]
					]
				]);

?>

</div>


<div style='width: 100%'>
<?php
	
  echo Form::widget([
		    	'model'=>$model,
		    	'form'=>$form,
		    	'columns'=>1,
				'attributes'=>
					[
					'Feed_notes' => 
	    				[
	    				'type' => FORM::INPUT_TEXTAREA,
						
	    				]
					]
				]);

?>
<?php ActiveForm::end(); ?>


</div>


<div style='width: 100%;' id='product_price_list' >
	
	<?= $this->render("/products-pricing/_pricingSingle", [
					'product' => $model,
					'readOnly' => $readOnly,
					]); ?>
	
	
</div>


<div style='width: 100%; <? if($model->Mix_Type != Product::MIXTYPE_COMPOSITE){ echo " display: none; ";} ?>' id='ingredient_list' >
	
	
	<?= $this->render("/products-ingredients/_productIngredients", [
					'product' => $model,
					'readOnly' => $readOnly,
					]); ?>
	
</div>



  

</div>



<div>
	<?php		
		Modal::begin([
		    'id' => 'activity-modal',
		    'header' => '<h4 class="modal-title">Add Price</h4>',
		    'size' => 'modal-lg',
		    'options' =>
		    	[
				'tabindex' => false,
				]

		]);		?>


		<div id="modal_content">dd</div>

	<?php Modal::end(); ?>
	
</div>

