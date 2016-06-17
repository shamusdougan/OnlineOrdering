<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use vendor\actionButtons\actionButtonsWidget;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel app\models\trailersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trailers';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
           
             [
    		'attribute' => 'Registration',
    		'format' => 'raw',
    		'value' => function ($data)
    			{
				return html::a($data->Registration, "/trailers/update?id=".$data->id);
				},
			'width' => '100px',
    		],
            'Description',
            'Max_Capacity',
            [
            'attribute' => 'bin_Capacity',
            'value' => function ($data)
            	{
				return $data->getTrailerBinDisplayString();
				}
            
            ],
            'NumBins',
            [
            'attribute' => 'Auger',
            'value' => function ($data)
            	{
				return $data->Auger ? "Yes" : "";
				},
            'filter' => ['1' => 'Yes', '0' => 'No'],
            ],
            [
            'attribute' => 'Blower',
            'value' => function ($data)
            	{
				return $data->Blower ? "Yes" : "";
				},
            'filter' => ['1' => 'Yes', '0' => 'No'],
            ],
           	[
            'attribute' => 'Tipper',
            'value' => function ($data)
            	{
				return $data->Tipper ? "Yes" : "";
				},
            'filter' => ['1' => 'Yes', '0' => 'No'],
            ],
     
            

			[
		    'class' => 'kartik\grid\ActionColumn',
		   	'template' => '{update} {delete}',
			'width' => '5%',
        
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
<div class="trailers-index">

	<?= actionButtonsWidget::widget(['items' => $actionItems]) ?>
    <h1><?= Html::encode($this->title) ?></h1>
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'columns' => $gridColumns,
		'panel'=>[
        	'type'=>GridView::TYPE_PRIMARY,
        	'heading'=>"Irwin Trucks",
    		],
        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
        'toolbar'=> 
        	[
			    [
			    'content' => $exportButton,
			    ],
			],
    ]); ?>

</div>
