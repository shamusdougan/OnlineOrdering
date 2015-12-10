<?php
use yii\helpers\Html;
use vendor\actionButtons\actionButtonsWidget;
use kartik\grid\GridView;
?>


<?= actionButtonsWidget::widget(['items' => $actionItems]) ?> 
<? 

$gridColumns = 
	[
		[
		'attribute' => 'product_id'
		'value' => function ($data)
			{
			return "blah";
			}
		],
	];
	
foreach($basePricingMatrix as $dateIndex => $pricingArray )
	{
	$gridColumns[] = ['attribute' => $dateIndex];
		
	}


echo GridView::widget(
	[
	'dataProvider' => $dataProvider,
	'filterModel' => null,
	'export' => false,
	'columns' => $gridColumns,

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
