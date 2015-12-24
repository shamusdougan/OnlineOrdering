<?php

use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\html;
use vendor\actionButtons\actionButtonsWidget;
use kartik\grid\GridView;
use yii\helpers\Url;


echo actionButtonsWidget::widget(['items' => $actionItems]);




$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


<?=	Html::input('text','importState',$nextState); ?>

<? 
if($currentState == 'upload')
	{
		
	
		
	echo $form->field($model, 'file')->label('Select Excel File to upload')->widget(FileInput::classname(), [
	'pluginOptions' => [
		'showCaption' => true,
		'showRemove' => true,
		'showUpload' => false,
		'showPreview' => false,
		'allowedFileExtensions'=>['xlsx'],
		],
   'options' => ['accept' => '.xlsx'],
   ]);
   }
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
			$gridColumn['filter'] = '<A href=\''.Url::to(['product/import-exceldata', 'filename' => basename($model->file), 'columnName' => $columnName]).'\' title=\'Import Column\'>Import Prices</A>';
			}
		$gridColumns[] = $gridColumn;
		}


echo "<div style='height: 700px; overflow-y: auto'>"; 
echo GridView::widget(
	[
	'dataProvider' => $dataProvider,
	'headerRowOptions'=>['class'=>'kartik-sheet-style'],
	'pjax'=>true, 
    'export'=>false,
    'filterModel' => "hello",
    'panel'=>[
        'type'=>GridView::TYPE_PRIMARY,
        'heading'=>"Product Pricing - Select column to import from",
	    ],
	   'toolbar' => false,
	'columns' => $gridColumns,
]
);



 } ?>
</div>
<button>Submit</button>

<?php ActiveForm::end(); ?><?php

?>