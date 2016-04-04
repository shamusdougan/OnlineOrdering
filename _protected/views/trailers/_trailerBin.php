<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;



$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'add_bin_form'] ); 

echo "Enter in the Bin Squence, for example 4 bins with 6 Tonnes each would be 6,6,6,6.";
echo Form::widget([
	
	'formName'=>"Add_Trailers",
	'columns' => 2,
	'attributes' => 
		[
		'Bin Squence' => 
			[
			'type'=>Form::INPUT_TEXT,
			],


		]

	]);

	
	echo $form->field($model, 'trailer_id', ['template' => '{input}'])->hiddenInput()->label(false);	
	echo $form->field($model, 'Status', ['template' => '{input}'])->hiddenInput()->label(false);	
	
	?>
	
	
	
 	<div class="form-group">
        <?= Html::submitButton('Add Bin(s)', ['class' => 'btn btn-primary']) ?>
    </div>
  <?php ActiveForm::end(); ?>
