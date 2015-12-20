<?php
use yii\helpers\Html;
use vendor\actionButtons\actionButtonsWidget;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/*
'dataProvider' => $dataProvider,
'actionItems' => $actionItems,
'basePricingMatrix' => $basePricingMatrix,



*/
?>


<?= actionButtonsWidget::widget(['items' => $actionItems]) ?> 
  <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id' => 'bulk-pricing-form']); ?>

<br>
<div style='width: 400px'>
<?= "<h3>Pricing Valid From: </h3>".DatePicker::widget([
        'name' => 'price_date',
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'value' => date("d-M-Y"),
        'pluginOptions' => [
        	'autoclose'=>true,
            'format' => 'dd-M-yyyy'
        ]
    ]);
    ?>
</div><br>


<div style='height: 600px; overflow-y: auto'> 



<?


echo GridView::widget([
 	'dataProvider'=> $dataProvider,
 	'export' => false,
 	'columns' => 
 		[
 		'product.Product_ID',
 		'product.Name',
 	[
        'format' => 'raw',
        'attribute' => 'price_pT',
        'label' => 'Price per Tonne',
      	'value' => function ($data)
      		{
			return "<input type='text' name='price[".$data->product_id."]' ";
			},
      	],
		],
 	]);



?>

</div>

<?php ActiveForm::end(); ?>