<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StorageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Storages';
$this->params['breadcrumbs'][] = $this->title;




$gridColumns = [
	['class' => 'yii\grid\SerialColumn'],
	'Description',
	'Capacity',
	[
		'attribute' => 'company',
		'value' => 'company.Company_Name',
		'filter' => \yii\helpers\ArrayHelper::map($clientList, 'Company_Name', 'Company_Name'),
	],
	'Auger:boolean',
	'Blower:boolean',
	// 'Delivery_Instructions',
	// 'Postcode',
	// 'Status',
	// 'Street_1',
	// 'SuburbTown',
	'Tipper:boolean',

	[ 'class'=>'kartik\grid\ActionColumn'],
];


?>
<div class="storage-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Storage', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns'=>$gridColumns,
		'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
		'headerRowOptions'=>['class'=>'kartik-sheet-style'],
		'filterRowOptions'=>['class'=>'kartik-sheet-style'],
		'export'=>false,

    ]); ?>

</div>
