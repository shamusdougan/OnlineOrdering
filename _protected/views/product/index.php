<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Lookup;
use vendor\actionButtons\actionButtonsWidget;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = 
	[
		 

		[
		'attribute' => 'Product_ID',
		'width' => '5%',
		],
		[
		'attribute' => 'Name',
		'width' => '15%',
		'format' => 'raw',
		'value' => function ($data)
			{
				return html::a($data->Name, "/product/update?id=".$data->id);
				},

		],
	    [
	    'attribute' => 'Status',
	    'width' => '10%',
	    'value' => function ($data)
	    	{
			return Lookup::item($data->Status, "PRODUCT_STATUS");
			},
		'filter' => Lookup::items("PRODUCT_STATUS"),
	    ],
		[
	    'attribute' => 'Description',
	    'width' => '25%',
	    ],
	    [
	    'attribute' => 'price_pT',
	    'width' => '10%',
	    'value' => function ($data)
	    	{
			$data->getCurrentPrice();
			return "$".number_format($data->price_pT, 2);
			},
	    'hAlign' => 'right',
	    ],
	    [
	        'attribute' => 'Product_Category',
	        'width' => '10%',
	        'value' => function($data) {
				return Lookup::item($data->Product_Category, "ORDER_CATEGORY");
				},
			'filter' => Lookup::items("ORDER_CATEGORY"),
		],
	    [
	    'class' => 'kartik\grid\ActionColumn',
	   	'template' => '{update} {delete}',
		'width' => '5%',
        
        ]
	];


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
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  
  
    <?= actionButtonsWidget::widget(['items' => $actionItems]) ?>


	
	
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export'=>[
	        'fontAwesome'=>true,
	        'showConfirmAlert'=>false,
	        'target'=>GridView::TARGET_BLANK,
        	],
    	'panel'=>[
        	'type'=>GridView::TYPE_PRIMARY,
        	'heading'=>"Product Pricing",
    		],
        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
        'toolbar'=> [
		    [
		    'content' => $exportButton,
		    ],
       	 ],
       'columns' => $gridColumns,
       
    ]); ?>

</div>
