<?php

use yii\widgets\ActiveForm;
use yii\helpers\html;
use kartik\widgets\FileInput;
use vendor\actionButtons\actionButtonsWidget;
use vendor\progressbar\progressbarWidget;

$this->title = 'Import Ingredients from Excel for '.$product->Name;
$this->params['breadcrumbs'][] = ['label' => 'Product Ingredient', 'url' => ['product/update', 'id'=>$product->id],];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= actionButtonsWidget::widget(['items' => $actionItems,]); ?>

<h1><?= Html::encode($this->title) ?></h1>


<? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= progressbarWidget::widget(['items' => $progress,  'current' => $progressStep]) ?>

<div style='width: 600px;'>
		<H1>Step 1: Select File to Upload</H1><br>
		<div style='width: 600px; border-radius: 5px; border: 1px solid; background-color: #EFEFEF; padding: 5px'>
			Use this function to bulk import the list of ingredients for this product. You can download a template excel file <?= Html::a('here', '/import-functions/download-ingedient-template') ?>.<br>
			Importing the ingredients will automatically clear any existing ingredients for this product<br>
			Populate the file with the required ingredients, save and then click the browse button below, select your excel file and then hit the submit button.<br>
			If there are any error this screen with the relevant error message.<br>
			If the import was sucessful then you will be taken back to the product page.<br>
		</div>
		<div style='width: 450px; float: left; padding-top: 10px'>
			<?= $form->field($model, 'file')->label(false)->widget(FileInput::classname(), [
			'pluginOptions' => [
				'showCaption' => true,
				'showRemove' => true,
				'showUpload' => false,
				'showPreview' => false,
				'allowedFileExtensions'=>['xlsx'],
				],
			'options' => ['accept' => '.xlsx'],
			]); ?>
  		</div>
  		<div style='width: 100px;  float: left; padding-top: 10px; padding-left: 10px'>
   			<?= Html::submitButton("Upload",  ['type'=>'button', 'class'=>'btn btn-primary']); ?>
   		</div>
   </div>





<?php ActiveForm::end(); ?><?php

?>