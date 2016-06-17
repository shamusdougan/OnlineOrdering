<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use vendor\actionButtons\actionButtonsWidget;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel app\models\trucksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trucks';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [

            [
    		'attribute' => 'registration',
    		'format' => 'raw',
    		'value' => function ($data)
    			{
				return html::a($data->registration, "/trucks/update?id=".$data->id);
				},
			'width' => '100px',
    		],
            'description',
            [
            'attribute' => 'defaultTrailer1_id',
            'value' => function($data)
            	{
					if($data->defaultTrailer1)
						{
						return $data->defaultTrailer1->Description;
						}
					return null;
				}
            ],
             [
            'attribute' => 'defaultTrailer2_id',
            'value' => function($data)
            	{
					if($data->max_trailers == 1)
						{
						return " ";
						}
					
					
					if($data->defaultTrailer2)
						{
						return $data->defaultTrailer2->Description;
						}
					return null;
				}
            ],
            'mobile',
            [
    		'attribute' => 'Auger',
    		'format' => 'raw',
    		'value' => function ($data)
    			{
				return $data->Auger ? "Yes": "";
				},
			'width' => '100px',
			'filterType'=>GridView::FILTER_SELECT2,
			'filter' => array(0 => "No", 1 => "Yes"),
			'filterWidgetOptions'=>['pluginOptions'=>['allowClear'=>true],],
			'filterInputOptions'=>['placeholder'=>'All'],
    		],
            [
    		'attribute' => 'Blower',
    		'format' => 'raw',
    		'value' => function ($data)
    			{
				return $data->Blower ? "Yes": "";
				},
			'width' => '100px',
			'filterType'=>GridView::FILTER_SELECT2,
			'filter' => array(0 => "No", 1 => "Yes"),
			'filterWidgetOptions'=>['pluginOptions'=>['allowClear'=>true],],
			'filterInputOptions'=>['placeholder'=>'All'],
    		],
 			[
    		'attribute' => 'Tipper',
    		'format' => 'raw',
    		'value' => function ($data)
    			{
				return $data->Tipper ? "Yes": "";
				},
			'width' => '100px',
			'filterType'=>GridView::FILTER_SELECT2,
			'filter' => array(0 => "No", 1 => "Yes"),
			'filterWidgetOptions'=>['pluginOptions'=>['allowClear'=>true],],
			'filterInputOptions'=>['placeholder'=>'All'],
    		],


            [
				'class' => 'kartik\grid\ActionColumn',
				'template' => '{update} {delete}',
				
			],
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
<div class="trucks-index">

	<?= actionButtonsWidget::widget(['items' => $actionItems]) ?>
    <h1><?= Html::encode($this->title) ?></h1>
    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'panel'=>[
        	'type'=>GridView::TYPE_PRIMARY,
        	'heading'=>"Irwin Trucks",
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
