<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DeliveryLoadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Delivery Loads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-load-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Delivery Load', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'delivery_id',
            'load_qty',
            'trailer_bin_id',
            'delivery_on',
            // 'delivery_completed_on',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
