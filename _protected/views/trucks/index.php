<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use vendor\actionButtons\actionButtonsWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\trucksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trucks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trucks-index">

	<?= actionButtonsWidget::widget(['items' => $actionItems]) ?>
    <h1><?= Html::encode($this->title) ?></h1>
    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'columns' => [

            'registration',
            'description',
            'mobile',
            'defaultTrailersList',
          
          
         
            // 'Status',
            // 'Auger',
            // 'Blower',
            // 'Tipper',

            [
				'class' => 'kartik\grid\ActionColumn',
				'template' => '{update} {delete}',
				
			],
        ],
    ]); ?>

</div>
