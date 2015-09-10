<?php

use yii\helpers\Html;
use kartik\grid\GridView;

use app\components\actionButtons;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DeliverySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Deliveries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-index">


    <?= actionButtons::widget(['items' => $actionItems]) ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'columns' => [
        	'Name',
            'delivery_on',
            'customerOrder.Name',
            'customerOrder.Requested_Delivery_by',
            'customerOrder.Qty_Tonnes',
            'delivery_qty',
             [
				'class' => 'kartik\grid\ActionColumn',
				'template' => '{update} {delete}',
			],
        ],
    ]); ?>

</div>
