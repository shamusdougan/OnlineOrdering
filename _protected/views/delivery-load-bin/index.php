<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DeliveryLoadBinSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Delivery Load Bins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-load-bin-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Delivery Load Bin', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'delivery_load_id',
            'trailer_bin_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
