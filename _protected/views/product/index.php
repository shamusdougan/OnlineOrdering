<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Lookup;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

 			'Product_ID',
            'Name',
           
            'Description',
            'Status',
            // 'cp',
            // 'Decimals_Supported',
            // 'Default_Unit',
            // 'Feed_notes',
            'List_Price_pT_Base',
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
