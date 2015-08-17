<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\builder\Form;
//use kartik\widgets\Typeahead;

?>

<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'ingredient_add']); ?>
  
 
<?php


   echo Form::widget([
		    	'model'=>$model,
		    	'form'=>$form,
		    	'columns'=>6,
		    	'attributes'=>
		    		[
		  			'ingredient_id' =>
		    			[
		    				'type' => Form::INPUT_WIDGET,
		    				'widgetClass' => '\kartik\widgets\Select2',
		    				'options'=>
		    					[
		    					'data'=>$productList,
		    					'options' => ['placeholder' => 'Select Product....', 'selected' => null,],
		    					'hideSearch' => false,
		    					],
		    				'columnOptions'=>['colspan'=>2],
		    				'label' => false,
							'readonly' => true,
						],	
		    		'ingredient_percent' => 
		    			[
		    			'type' => Form::INPUT_WIDGET,
		    			'widgetClass' => '\kartik\widgets\TouchSpin',
		    			'options' =>
		    				[
							'name' => 'Percentage',
							'pluginOptions' => 
								[
								'min' => 0, 
								'max' => 100, 
								'postfix' => '%',
								'step' => 1,
								'decimals' => 2,
								],
		    				],
		    			'columnOptions'=>['colspan'=>2],
		    			'label' =>false,
		    			],
					
		    		 'actions'=>
		    		 	[
		    		 	'type'=>Form::INPUT_RAW, 
		    		 	'value'=>Html::submitButton('Save', ['class'=>'btn btn-primary'])
		    		 	]
		    		]
		    	]);
   ?>
   
   

    <?= $form->field($model, 'created_on')->hiddenInput()->label(false) ;  ?>  
	<?= $form->field($model, 'order_id')->hiddenInput()->label(false) ;  ?>
		    	
		    	
		    	<?php
ActiveForm::end(); 




?>	  
	