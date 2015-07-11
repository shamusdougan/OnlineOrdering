<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
            // 'Product_Category',
            // 'Retail_Price_t',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
