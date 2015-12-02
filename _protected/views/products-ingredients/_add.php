<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\datePicker;
use yii\helpers\Html;



?>


 <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'add-ingredient-form']); ?>
 
  <?= $form->field($model, 'product_id')->hiddenInput()->label(false) ; ?>
  <?= $form->field($model, 'created_on')->hiddenInput()->label(false) ; ?>
  <? echo Form::widget([
		    	'model'=>$model,
		    	'form'=>$form,
		    	'columns'=>6,
		    	'attributes'=>
		    		[	 
		    		'product_ingredient_id' =>
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
								'max' => $max_percent, 
								'postfix' => '%',
								'step' => 0.001,
								'decimals' => 3,
								],
		    				],
		    			'columnOptions'=>['colspan'=>2],
		    			'label' =>false,
		    			],
		      		'actions'=>
		    		 	[
		    		 	'type'=>Form::INPUT_RAW, 
		    		 	'value'=>(isset($model->id) ? Html::submitButton('Update', ['class'=>'btn btn-primary']) : Html::submitButton('Add', ['class'=>'btn btn-primary']))
		    		 	]
		      		],
		    ]); ?>
 
 
 <?php ActiveForm::end(); ?>

