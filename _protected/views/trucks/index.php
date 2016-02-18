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

            'registration',
            'description',
            'mobile',
            [
            'attribute' => 'defaultTrailersList',
            'label' => 'Default Trailers'
          	],
          
         
            // 'Status',
            // 'Auger',
            // 'Blower',
            // 'Tipper',

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
