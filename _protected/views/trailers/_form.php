<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use app\models\Lookup;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\trailers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trailers-form">

   	<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'trailer-form']); ?>
   	
   	 <? echo Form::widget([
		    	'model'=>$model,
		    	'form'=>$form,
		    	'columns'=>4,
		    	'attributes'=>
		    		[
		    		'Registration' =>
		    			[
	    				'type' => Form::INPUT_TEXT,
		    			],			 
		    		'Max_Capacity' =>
		    			[
		    			'type' => FORM::INPUT_TEXT,
		    			],
		    		'NumBins' =>
		    			[
		    			'type' => FORM::INPUT_TEXT,
		    			
		    			],
		    		'Status' =>
		    			[
		    			'type' => FORM::INPUT_DROPDOWN_LIST,
		    			'items' => Lookup::Items("TRAILER_STATUS"),
		    			
		    			
		    			],
		    		
		    		'Auger' => 
		    			[
		    			'type' => FORM::INPUT_CHECKBOX,
		    			],
		    		'Blower' => 
		    			[
		    			'type' => FORM::INPUT_CHECKBOX,
		    			],
		    		'Tipper' => 
		    			[
		    			'type' => FORM::INPUT_CHECKBOX,
		    			]
		    		],
		    	]); ?>
		    
		    
		    <?= Form::widget([
		    	'model'=>$model,
		    	'form'=>$form,
		    	'columns'=>1,
		    	'attributes'=>	
		    		[		
		    		'Description' =>
		    			[
		    			'type' => FORM::INPUT_TEXTAREA,
		    			],
		      		]
		    ]); ?>

    <?=  $this->render("_binGrid", ['model' => $model, 'form' => $form]) ?>

    <?php ActiveForm::end(); ?>



<?php		
Modal::begin([
    'id' => 'activity-modal',
    'header' => '<h4 class="modal-title">Trailer Bin Information</h4>',
    'size' => 'modal-lg',

]);		?>


<div id="modal_content"></div>

<?php

Modal::end(); 
		
?>


</div>
