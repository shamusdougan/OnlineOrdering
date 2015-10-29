<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\actionButtons;

/* @var $this yii\web\View */
/* @var $searchModel app\models\trailersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trailers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trailers-index">

	<?= actionButtons::widget(['items' => $actionItems]) ?>
    <h1><?= Html::encode($this->title) ?></h1>
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'columns' => [
           
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
