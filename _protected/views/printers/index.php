<?php

use yii\helpers\Html;
use vendor\actionButtons\actionButtonsWidget;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PrintersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Printers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="printers-index">

	 <?= actionButtonswidget::widget(['items' => $actionItems]) ?> 
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div style='width: 600px; border-radius: 5px; border: 1px solid; background-color: #EFEFEF; padding: 5px'>
			This lists the default printers that can be used for the auto printing to an a4 printer or a label printer. <br>
			If printing automaticilly, labels or a4 cheets, the bowser will pull the local list of printers from the local machine. <br>
			If any of the local printer names match the printer name in the database and can print the type (either a4 or label) then the print job will be sent automatticaly.
			

		</div>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'export' => false,
        'filterModel' => $searchModel,
        'columns' => [

            'name',
			[
			'attribute' => 'print_label',
			'value' => function ($data)
				{
					return $data->print_label == 1 ? "Yes": "";
					
				},
			'filter' => array(1 => "Yes", 0 => "No"),
			],
            [
			'attribute' => 'print_a4',
			'value' => function ($data)
				{
					return $data->print_a4 == 1 ? "Yes": "";
				},
			'filter' => array(1 => "Yes", 0 => "No"),
			],

            [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
</div>
