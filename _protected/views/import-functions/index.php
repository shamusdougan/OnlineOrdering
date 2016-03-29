<?php

use yii\helpers\Html;
use yii\grid\GridView;
use vendor\actionButtons\actionButtonsWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ImportFunctionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Import Functions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="import-functions-index">


  <?= actionButtonsWidget::widget(['items' => $actionItems]) ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

      

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'function',

            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => '{view} {update} {delete} {import}',
            	'buttons' => [
            		'import' => function ($url, $model){
						return Html::a('<span class="glyphicon glyphicon-download-alt"></span>', $url, [
							'title' => "Import",
							]);
						}
            		]
            ],
        ],
    ]); ?>

</div>
