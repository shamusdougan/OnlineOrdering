<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;

if(!isset($readOnly)) { $readOnly = false; }

$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'storage_form'] ); 


 $contactForm = Form::widget([
    	'model'=>$model,
    	'form'=>$form,
    	'columns'=>2,
    	'attributes'=>
    		[
			'Description' => 
				[
				'type'=>Form::INPUT_TEXT, 
				'options' => ['readonly' => $readOnly]
				],
			'Capacity' => 
				[
				'type'=>Form::INPUT_TEXT, 
				'options' => ['readonly' => $readOnly],
				'label' => "Capacity (Tonnes)",
				]
    			 
      		]
    ]);
  	

$contactForm .= Form::widget([
	'model' => $model,
	'form'=>$form,
	'columns' => 3,
	'attributes' => 
		[
		'Street_1' => 
			[
			'type'=>Form::INPUT_TEXT,
			'columnOptions'=>['colspan'=>2],
			],		
		'SuburbTown' => 
			[
			'type'=>Form::INPUT_TEXT,
			'columnOptions'=>['colspan'=>2],
			],
		'Postcode'=> ['type'=>Form::INPUT_TEXT],
		]

	]);

$contactForm .=  Form::widget(
		[
		'model' => $model,
		'form' => $form,
		'columns' => 4,
		'attributes' => 
			[
			'Auger' => ['type'=>Form::INPUT_CHECKBOX, 'label' => 'Auger' ], 
			'Blower' => ['type' =>Form::INPUT_CHECKBOX, 'label' => 'Blower'],
			'Tipper' => ['type' =>Form::INPUT_CHECKBOX, 'label' => 'Tipper'],
			
			]
		]);

	

	echo $contactForm;
	
	echo $form->field($model, 'company_id', ['template' => '{input}'])->hiddenInput()->label(false);	
	echo $form->field($model, 'id', ['template' => '{input}'])->hiddenInput()->label(false);
	echo $form->field($model, 'Status', ['template' => '{input}'])->hiddenInput()->label(false);						
 	?>
 	
 	
 	
 	
 	<div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
