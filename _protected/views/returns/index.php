<?php

use yii\helpers\Html;
use vendor\actionButtons\actionButtonsWidget;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReturnsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Returns';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="returns-index">

	 <?= actionButtonswidget::widget(['items' => $actionItems]) ?> 
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'export' => false,
        'filterModel' => $searchModel,
        'columns' => [

            'delivery.Name',
            'amount',

            [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
</div>
