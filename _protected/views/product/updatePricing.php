<?php
use yii\helpers\Html;
use vendor\actionButtons\actionButtonsWidget;
use kartik\grid\GridView;
use kartik\export\ExportMenu;



/*
'dataProvider' => $dataProvider,
'actionItems' => $actionItems,
'basePricingMatrix' => $basePricingMatrix,



*/
?>


<?= actionButtonsWidget::widget(['items' => $actionItems]) ?> 
<? 



$gridColumns = 
	[
		[
		'attribute' => 'product_code',
		'filter' => '<input class="form-control" name="filtercode" value="'. $filterModel['product_code'] .'" type="text">'
		],
		[
		'attribute' => 'product_name',
		'filter' => '<input class="form-control" name="filtername" value="'. $filterModel['product_name'] .'" type="text">'
		],
	];
	
foreach($basePricingMatrix as $dateIndex => $pricingArray )
	{
	$gridColumns[] = 
		[
		'attribute' => $dateIndex,
		'header' => date("d M Y", $dateIndex),
		'hAlign' => 'right',
		
		];
		
	}


$exportButton = ExportMenu::widget([
    'dataProvider' => $dataProviderFull,
    'columns' => $gridColumns,
    'fontAwesome' => true,
    'dropdownOptions' => [
        'label' => 'Export All',
        'class' => 'btn btn-default'
    	],
    'exportConfig' =>
    	[
    	ExportMenu::FORMAT_HTML => false,
    	ExportMenu::FORMAT_TEXT => false,
    	ExportMenu::FORMAT_PDF => false,
    	ExportMenu::FORMAT_EXCEL => false,
    	
    	]
]) ;


echo GridView::widget(
	[
	'dataProvider' => $dataProviderFull,
	'filterModel' => $filterModel,
	'headerRowOptions'=>['class'=>'kartik-sheet-style'],
	'pjax'=>true, 
	'toolbar'=> [
	    [
	    'content' => $exportButton,
	    ],
        ],
	'autoXlFormat'=>true,
    'export'=>[
        'fontAwesome'=>true,
        'showConfirmAlert'=>false,
        'target'=>GridView::TARGET_BLANK,
        
    ],
    'panel'=>[
        'type'=>GridView::TYPE_PRIMARY,
        'heading'=>"Product Pricing",
    ],
	'columns' => $gridColumns,
	
	'floatHeader' => true,
	'perfectScrollbar' => true,
	'perfectScrollbarOptions' => 
		[
		'height' => '8',
		],
	'tableOptions' =>
		[
		'height' => 800,
		]
		
	]
);


/*
<table width='100%' border=1>
	<tr>
		<th>Product2</th>
		<? foreach($pricingMatrix as $priceDate => $productPricingArray)
			{
			echo "<th>".date("d M Y", $priceDate)."</th>";
			}
		?>
	</tr>

	<?
	foreach($baseProducts as $productObj)
		{
		echo "<tr>";
		echo "	<TD>".$productObj->Name." (".$productObj->Product_ID.") </TD>";
		foreach($pricingMatrix as $productPricingArray)
			{
			echo "<td>".$productPricingArray[$productObj->id]."</td>";
			}
		echo "</tr>";
			
			
			
		}
	
	?>
	
	
</table>

*/


  



?>
