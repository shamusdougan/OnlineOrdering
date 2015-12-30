<?php

use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\html;
use vendor\actionButtons\actionButtonsWidget;
use vendor\progressbar\progressbarWidget;
use kartik\grid\GridView;
use yii\helpers\Url;

$this->title = 'Import Pricing from Excel';
$this->params['breadcrumbs'][] = ['label' => 'Update Pricing', 'url' => ['product/update-pricing'],];
$this->params['breadcrumbs'][] = $this->title;






?>

<?= actionButtonsWidget::widget(['items' => $actionItems,]); ?>

<h1><?= Html::encode($this->title) ?></h1>


<?= progressbarWidget::widget(['items' => $progress,  'current' => $progressStep]) ?>

<? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


<?=	Html::input('hidden','importState',$nextState); ?>

<? 
if($currentState == 'upload')
	{ ?>
		
		
	<div style='width: 600px;'>
		<H1>Step 1: Select File to Upload</H1><br>
		<div style='width: 600px; border-radius: 5px; border: 1px solid; background-color: #EFEFEF; padding: 5px'>
			Select the Excel file to upload. <br>
			To make sure the file is formatted correctly, you can export the data from the price lists page, modify or add price list entries as required then import the new prices in here. <br>
			You can also download a blank excel spreadsheet and add the prices and then import from here.<br>
			Blank Spreadsheet download <A href='<?= Url::to(['import-functions/download-pricing-template'])?>'>link</a>
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
   
   
<?	}
elseif($currentState == 'selectColumns'){ 

	$gridColumns = [];
	foreach($dataProvider->allModels[0] as $columnName => $dataRow)
		{
		$gridColumn =
			[
			'attribute' => $columnName,
			];
			
		if($columnName != "Product Code" && $columnName != "Product Name")
			{
			$gridColumn['filter'] = '<A href=\''.Url::to(['product/import-exceldata', 'filename' => basename($model->file), 'columnName' => $columnName]).'\' title=\'Import Column\'>Import Column</A>';
			}
		$gridColumns[] = $gridColumn;
		}
	?>

	<H1>Step 2: Select Column from File to import</H1><br>
	<div style='width: 600px; border-radius: 5px; border: 1px solid; background-color: #EFEFEF; padding: 5px'>
		From the Uploaded Excel spreadsheet, select the Column of prices to import.<br>
		Click on the <b>"import Column"</b> under the column date to import that column.<br>
		A new pricing sheet will be created based on the Date at the the top of the column and with the prices for each product in that column.<br>
		Any prices that are set to zero will not be added to the pricing sheet, the price for that product will instead come from a previous pricing sheet.
	</div>
	<?="<div style='height: 700px; overflow-y: auto; padding-top: 5px;'>";  ?>
	<?= GridView::widget(
	[
	'dataProvider' => $dataProvider,
	'headerRowOptions'=>['class'=>'kartik-sheet-style'],
	'pjax'=>false, 
    'export'=>false,
    'filterModel' => "hello",
    'panel'=>[
        'type'=>GridView::TYPE_PRIMARY,
        'heading'=>"Product Pricing - Select column to import from",
	    ],
	   'toolbar' => false,
	'columns' => $gridColumns,
	]
	); ?>



<? } ?>
</div>


<?php ActiveForm::end(); ?><?php

?>