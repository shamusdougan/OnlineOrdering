<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;

if(!isset($readOnly)) { $readOnly = false; }

$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'create_contact_form'] ); 


 $contactForm = Form::widget([
    	'model'=>$model,
    	'form'=>$form,
    	'columns'=>3,
    	'attributes'=>
    		[
			'First_Name' => 
				[
				'type'=>Form::INPUT_TEXT, 
				'options' => ['readonly' => $readOnly]
				],
			'Last_Name' => ['type'=>Form::INPUT_TEXT, 'options' => ['readonly' => $readOnly]],
			'Job_Title' => ['type'=>Form::INPUT_TEXT, 'options' => ['readonly' => $readOnly]],
			'Business_Phone' => ['type'=>Form::INPUT_TEXT, 'options' => ['readonly' => $readOnly]],
			'Mobile_Phone' => ['type'=>Form::INPUT_TEXT, 'options' => ['readonly' => $readOnly]],
    			 
      		]
    ]);
  	

$contactForm .= Form::widget([
	'model' => $model,
	'form'=>$form,
	'columns' => 2,
	'attributes' => 
		[
		'Address_1_Street_1' => 
			[
			'type'=>Form::INPUT_TEXT,
			'columnOptions'=>['colspan'=>2],
			],
		'Address_1_Street_2' => 
			[
			'type'=>Form::INPUT_TEXT,
			'columnOptions'=>['colspan'=>2],
			'label' => false,
			],		
		'Address_1_TownSuburbCity' => ['type'=>Form::INPUT_TEXT],
		'Address_1_Postal_Code'=> ['type'=>Form::INPUT_TEXT],
		]

	]);

$contactForm .=  Form::widget(
		[
		'model' => $model,
		'form' => $form,
		'columns' => 4,
		'attributes' => 
			[
			'Do_Not_Allow_Bulk_Emails' => ['type'=>Form::INPUT_CHECKBOX, 'label' => 'No Bulk Emails' ], 
			'Do_Not_Allow_Bulk_Mails' => ['type' =>Form::INPUT_CHECKBOX, 'label' => 'No Bulk Mail'],
			'Do_Not_Allow_Emails' => ['type' =>Form::INPUT_CHECKBOX, 'label' => 'No Emails'],
			'Do_Not_Allow_Faxes' => ['type' =>Form::INPUT_CHECKBOX, 'label' => 'No Faxes'],
			'Do_Not_Allow_Mails' => ['type' =>Form::INPUT_CHECKBOX, 'label' => 'No Mail'],
			'Do_Not_Allow_Phone_Calls' => ['type' =>Form::INPUT_CHECKBOX, 'label' => 'no Phone'],
			]
		]);

	

	echo $contactForm;
	
	echo $form->field($model, 'Company_id', ['template' => '{input}'])->hiddenInput()->label(false);	
	echo $form->field($model, 'id', ['template' => '{input}'])->hiddenInput()->label(false);				
 	?>
 	
 	
 	
 	
 	<div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
