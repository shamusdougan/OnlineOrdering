<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\datePicker;
use yii\helpers\Html;



?>


 <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'add-price-form']); ?>
 
  <?= $form->field($model, 'product_id')->hiddenInput()->label(false) ; ?>
  <? echo Form::widget([
		    	'model'=>$model,
		    	'form'=>$form,
		    	'columns'=>3,
		    	'attributes'=>
		    		[	 
		    		'date_valid_from' =>
		    			[
						'type'=>Form::INPUT_WIDGET, 
						'widgetClass' => DateControl::classname(),
						'label' => 'Valid From',
						'options' => 
							[
							'type'=>DateControl::FORMAT_DATE,
							'options' =>
								[
								'type' => DatePicker::TYPE_COMPONENT_APPEND,
								//'placeholder' => "Requested Delivery Date...",
								'pluginOptions' =>
									[
									'autoclose' => true,
									'todayHighlight' => true,
									'startDate' => date("d M Y"),
									]
								]
							],
						],
		    		'price_pt' =>
		    			[
	    				'type' => Form::INPUT_TEXT,	
		    			],	
		      		'actions'=>
		    		 	[
		    		 	'type'=>Form::INPUT_RAW, 
		    		 	'value'=>(isset($model->id) ? Html::submitButton('Update', ['class'=>'btn btn-primary']) : Html::submitButton('Add', ['class'=>'btn btn-primary']))
		    		 	]
		      		],
		    ]); ?>
 
 
 <?php ActiveForm::end(); ?>

