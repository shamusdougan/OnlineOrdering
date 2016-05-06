<?

use yii\helpers\Html;
use kartik\grid\GridView;
use vendor\actionButtons\actionButtonsWidget;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/*	@var $user -> current user */
/* @var $searchModel app\models\clientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Anticipated Sales: '.$user->fullname;
$this->params['breadcrumbs'][] = $this->title;

$gridColumns =
			[
				[
        		'attribute' => 'Company_Name',
        		'format' => 'raw',
        		'value' => function ($data)
        			{
					return html::a($data['Company_Name'], "/clients/update?id=".$data['id']);
					},
        		],
        	'Company_Name', 
			'Account_Number', 
			'Feed_QOH_Tonnes',
			'Herd_Size',
			'Feed_Rate_Kg_Day',
			'Feed_Days_Remaining',
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
<div class="clients-index">

 	<h1><?= Html::encode($this->title) ?></h1>
 	
 	
 	 <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
         'export'=>[
	        'fontAwesome'=>true,
	        'showConfirmAlert'=>false,
	        'target'=>GridView::TARGET_BLANK,
        	],
        'panel'=>[
        	'type'=>GridView::TYPE_PRIMARY,
        	'heading'=>"Anticipated Sales",
    		],
    	'toolbar'=> [
		    [
		    'content' => $exportButton,
		    ],
		    ],
        'columns' => $gridColumns,
		'hover' => true,
		'striped' => false,
    ]); ?>

 </div>