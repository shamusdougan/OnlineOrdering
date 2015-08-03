<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\trailersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trailers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trailers-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Trailers', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'Registration',
            'Description',
            'Max_Capacity',
            'NumBins',
            // 'Auger',
            // 'Blower',
            // 'Tipper',
            // 'Status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
