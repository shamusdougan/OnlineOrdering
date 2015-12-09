<?php
use kartik\widgets\ActiveForm;

use yii\helpers\Html;
use kartik\widgets\FileInput;

$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' =>'import-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

<br>

<?

print_r($file);
//echo FileInput::widget(['name'=>'kartiks_file']);

?>

<?  echo Html::input('file', 'importFile', ''); ?>



<button>Submit</button>

<?php ActiveForm::end(); ?>
