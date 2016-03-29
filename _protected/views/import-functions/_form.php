<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model app\models\ImportFunctions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="import-functions-form">

  <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'import-function-form']);


 	echo Form::widget([
		    	'model'=>$model,
		    	'form'=>$form,
		    	'columns'=>2,
		    	'attributes'=>
		    		[
		    		'name' => ['type' => FORM::INPUT_TEXT],
		    		'function' => ['type' => FORM::INPUT_TEXT],
		    		],
		    	]);
		    	

    ?>
    

    <?php ActiveForm::end(); ?>

</div>
