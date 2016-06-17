<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\builder\Form;
use app\models\Trailers;

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
					'description' => ['type' => FORM::INPUT_TEXT],
					'mobile' => ['type' => FORM::INPUT_TEXT, ],
					'defaultTrailer1_id' => 
						[
						'type' => Form::INPUT_WIDGET,
	    				'widgetClass' => '\kartik\widgets\Select2',
	    				'options'=>
	    					[
	    					'data'=>Trailers::getActiveTrailersList(),
	    					'options' => ['placeholder' => 'Select Trailer', 'selected' => null,],
							'pluginOptions' => [
								'allowClear' => true
								],
	    					],
    				   
						'label' => "Default 1st Trailer",
						],
					'defaultTrailer2_id' => 
						[
						'type' => Form::INPUT_WIDGET,
	    				'widgetClass' => '\kartik\widgets\Select2',
	    				'options'=>
	    					[
	    					'data'=>Trailers::getActiveTrailersList(),
	    					'options' => ['placeholder' => 'Select Trailer', 'selected' => null,],
	    					'pluginOptions' => [
								'allowClear' => true
								],
	    					],
						
						'label' => "Default 2nd Trailer",
						],
					
					
					],
				]);
		echo "<h2>Allowed Trailer Configurations</h2>";
		echo "<div style='width: 300px'>";
		echo Form::widget(
				[
				'model'=>$model,
				'form'=>$form,
			
				'columns'=>1,
				'attributes' =>
					[    
					'max_trailers' => 
						[
		    			'type' => Form::INPUT_WIDGET,
		    			'widgetClass' => '\kartik\widgets\TouchSpin',
		    			'options' =>
		    				[
							'name' => 'Max Trailers',
							'pluginOptions' => 
								[
								'min' => 0, 
								'max' => 2, 
								//'postfix' => '%',
								'step' => 1,
								'decimals' => 0,
								],
		    				],
						],
					'Auger' => ['type' => FORM::INPUT_CHECKBOX],
					'Blower' => ['type' => FORM::INPUT_CHECKBOX],
					'Tipper' => ['type' => FORM::INPUT_CHECKBOX],
					],
				]);		
		echo "</div>";		
				
	
	
					
		?>
    

  

  
   

    <?php ActiveForm::end(); ?>

</div>
