<?php
use yii\helpers\Html;
use yii\helpers\Url;
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
		'format' => 'raw',
		'value' => function($data)
			{
			return "<A href='/product/update?id=".$data['product_id']."'>".$data['product_code']."</A>";
			},
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
		'format'=>'raw',
		'filter' => '<span style=\' text-align: right; float: right; width: 100%;\'>'.
					'<A href=\''.Url::to(['product/add-bulk-pricing', 'useDateInt' => $dateIndex]).'\' title=\'Edit Price List\'><span class="glyphicon glyphicon-pencil"></span></A>'.
					'<A href=\''.Url::to(['product/copy-price-sheet', 'priceDateInt' => $dateIndex]).'\' title=\'Copy Price List\'><span class="glyphicon glyphicon-file"></span></A>'.
					'<A href=\''.Url::to(['product/bulk-delete', 'priceDateInt' => $dateIndex]).'\' onClick=\'return confirm("Delete All Prices on this Date")\' title=\'Delete Price List\'><span class="glyphicon glyphicon-trash"></span></A></span>',
		'value' => function($data) use ($basePricingMatrix, $dateIndex)
			{
				
			//return $dateIndex." -> ".$data['product_code'];
			
			if(array_key_exists($data['product_id'], $basePricingMatrix[$dateIndex]))
				{
				return "<font size='+1'><b>$".number_format($data[$dateIndex],2)."</b></font>";
				}
			else{
				return "<span title='Price Set Previously'><i>$".number_format($data[$dateIndex],2)."</i></span>";
				}
			}
		
		];
		
	}


$exportButton = ExportMenu::widget([
    'dataProvider' => $dataProvider,
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

?> 
<div style='height: 700px; overflow-y: auto'> 
<?= GridView::widget(
	[
	'dataProvider' => $dataProvider,
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
	

	
		
	]
);
?>
</div> 


  


