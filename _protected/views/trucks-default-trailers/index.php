<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TrucksDefaultTrailersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trucks Default Trailers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trucks-default-trailers-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Trucks Default Trailers', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'truck_id',
            'trailer_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
