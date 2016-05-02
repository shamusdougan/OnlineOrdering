<?php

use yii\helpers\Html;
use vendor\actionButtons\actionButtonsWidget;
use kartik\grid\GridView;
use app\models\Lookup;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsBinsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products Bins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-bins-index">

	 <?= actionButtonswidget::widget(['items' => $actionItems]) ?> 
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'export' => false,
        'filterModel' => $searchModel,
        'columns' => [

            [
            'attribute' => 'location_id',
            'value' => function($data)
            	{
				return Lookup::item($data->location_id, "BIN_LOCATION");
				},
			'filterType'=>GridView::FILTER_SELECT2,
            'filter' => Lookup::items("BIN_LOCATION"),
            'filterWidgetOptions'=>['pluginOptions'=>['allowClear'=>true],],
    		'filterInputOptions'=>['placeholder'=>'All'],
    		'group' => true,
            ],
          	'bin_id',
            'name',
            'description',
            'capacity',
          
            
          
            [
            'attribute' => 'bin_type',
            'value' => function($data)
            	{
				return Lookup::item($data->bin_type, "BIN_TYPE");
				},
			'filterType'=>GridView::FILTER_SELECT2,
            'filter' => Lookup::items("BIN_TYPE"),
            'filterWidgetOptions'=>['pluginOptions'=>['allowClear'=>true],],
    		'filterInputOptions'=>['placeholder'=>'All'],
            ],
            [
            'attribute' => 'order',
            'width' => '10px',
            ],

            [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
</div>
