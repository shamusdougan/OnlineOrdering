<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model app\models\trucks */
/* @var $form yii\widgets\ActiveForm */
?>

	<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'truck-form']);
 	echo $form->errorSummary($model); 
 	
 	
 	
 	echo $form->field($model, 'Status', ['template' => '{input}'])->hiddenInput()->label(false);	
	echo Form::widget(
				[
				'model'=>$model,
				'form'=>$form,
			
				'columns'=>3,
				'attributes' =>
					[    
					'registration' => ['type' => FORM::INPUT_TEXT, ],
					'description' => ['type' => FORM::INPUT_TEXT, 'columnOptions' => ['colspan' => 2]],
					'mobile' => ['type' => FORM::INPUT_TEXT, ]
					],
				]);
		echo Form::widget(
				[
				'model'=>$model,
				'form'=>$form,
			
				'columns'=>3,
				'attributes' =>
					[    
					'Auger' => ['type' => FORM::INPUT_CHECKBOX],
					'Blower' => ['type' => FORM::INPUT_CHECKBOX],
					'Tipper' => ['type' => FORM::INPUT_CHECKBOX],
					],
				]);		
				
				
		echo '<label class="control-label">Default Trailers (Max 2 Trailers)</label>';	
		echo Select2::widget([
		    'name' => 'trailer_select',
		    'value' => $model->listDefaultTrailers(),
		    'data' => $trailerList,
		    'size' => Select2::MEDIUM,
		    'options' => ['placeholder' => 'Select default trailers ...', 'multiple' => true],
		    'pluginOptions' => [
		        'allowClear' => true
		    ],
])
					
		?>
    

  

  
   

    <?php ActiveForm::end(); ?>

</div>
