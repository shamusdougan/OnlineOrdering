<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\datePicker;
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
						],	
		    		'ingredient_percent' => 
		    			[
		    			'type' => Form::INPUT_WIDGET,
		    			'widgetClass' => '\kartik\widgets\RangeInput',
		    			'options' =>
		    				[
							'name' => 'Percentage',
							'html5Options' => ['min' => 0, 'max' => 100, 'step' => 0.01],
							'addon' => ['append' => ['content' => '%']],
		    				],
		    			'columnOptions'=>['colspan'=>2],
		    			'label' =>false,
		    			],
					
		    		 'actions'=>
		    		 	[
		    		 	'type'=>Form::INPUT_RAW, 
		    		 	'value'=>Html::submitButton('Add', ['class'=>'btn btn-primary'])
		    		 	]
		    		]
		    	]);
   ?>
   
   
<?= $form->field($model, 'created_on')->widget(DatePicker::classname(), 
	[
	'options' => ['placeholder' => 'created on'],
	'pluginOptions' => 
		[
		'autoclose'=>true
		],
	]); ?>

      
	<?= $form->field($model, 'order_id')->textInput() ?>
		    	
		    	
		    	<?php
ActiveForm::end(); 

$this->registerJs("
$('body').on('beforeSubmit', 'form#ingredient_add', function () {
     var form = $(this);
     // return false if form still have some validation errors
     if (form.find('.has-error').length) {
          return false;
     }
     // submit form
     $.ajax({
          url: form.attr('action'),
          type: 'post',
          data: form.serialize(),
          success: function (response) 
          		{
          		alert(response);
				}
		  });

				
     return false;
});
");



?>	  
	