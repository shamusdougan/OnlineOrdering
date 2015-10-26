<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;


/* @var $this yii\web\View */
/* @var $model app\models\WeighbridgeTicket */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="weighbridge-ticket-form">

       <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'weighbridge-form']); ?>
    
    
    <? 
    //if the delivery has already been set then just hide the input field for the delivery otherwise display the selet widget to choose the Delivery
    if ($delivery != null)
    	{
		echo   $form->field($model, 'delivery_id', ['template' => '{input}'])->hiddenInput()->label(false);		
		}
    else{
		
		echo Form::widget([
	    	'model'=>$model,
	    	'form'=>$form,
	    	'columns'=>6,
	    	'attributes'=>[
	    		'delivery_id' =>
	    			[
	    				'type' => Form::INPUT_WIDGET,
	    				'label' => 'Order',
	    				'widgetClass' => '\kartik\widgets\Select2',
	    				'columnOptions'=>['colspan'=>2],
	    				'options'=>
	    					[
	    					'data'=>$deliveryList,
	    					'options' => ['placeholder' => 'Select from deliveies....', 'selected' => null,],
	    					
	    					],
						
	    			],		
	      		]
	    	]);
	
		}

   ?>

    <?= $form->field($model, 'truck_id')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'driver')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gross')->textInput() ?>

    <?= $form->field($model, 'tare')->textInput() ?>

    <?= $form->field($model, 'net')->textInput() ?>

    <?= $form->field($model, 'Notes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Moisture')->textInput() ?>

    <?= $form->field($model, 'Protein')->textInput() ?>

    <?= $form->field($model, 'testWeight')->textInput() ?>

    <?= $form->field($model, 'screenings')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
