<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Lookup;
use vendor\actionButtons\actionButtonsWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  
  
    <?= actionButtonsWidget::widget(['items' => $actionItems]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'columns' => [
         

 			'Product_ID',
 			[
 			'attribute' => 'Name',
 			'format' => 'raw',
    		'value' => function ($data)
    			{
				return html::a($data->Name, "/product/update?id=".$data->id);
				},
 			
 			],
            [
            'attribute' => 'Status',
            'value' => function ($data)
            	{
				return Lookup::item($data->Status, "PRODUCT_STATUS");
				},
			'filter' => Lookup::items("PRODUCT_STATUS"),
            ],

            'Description',
            // 'cp',
            // 'Decimals_Supported',
            // 'Default_Unit',
            // 'Feed_notes',
            [
            'attribute' => 'price_pT',
            'value' => function ($data)
            	{
				$data->getCurrentPrice();
				return number_format($data->price_pT, 2);
				},
            'hAlign' => 'right',
            ],
            // 'me',
            // 'Mix_Margin',
            // 'Mix_Margin_Base',
            // 'Mix_Type',
            // 'ndf',
            [
	            'attribute' => 'Product_Category',
	            'value' => function($data) {
					return Lookup::item($data->Product_Category, "ORDER_CATEGORY");
					},
				'filter' => Lookup::items("ORDER_CATEGORY"),
			],
            [
            'class' => 'kartik\grid\ActionColumn',
           	'template' => '{update} {delete}',
		
            
            ],
        ],
    ]); ?>

</div>
