<?php

use yii\helpers\Html;
use vendor\actionButtons\actionButtonsWidget;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\emailQueueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Email Queues';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-queue-index">

	 <?= actionButtonswidget::widget(['items' => $actionItems]) ?> 
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
 	<?= Yii::$app->session->getFlash('error'); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'export' => false,
        'filterModel' => $searchModel,
        'columns' => [

            'from',
            'to',
            'subject',
            'htmlBody',
            // 'attachment1',
            // 'attachment1_filename',
            // 'attachment1_type',
            // 'attachment2',
            // 'attachment2_filename',
            // 'attachment2_type',

            [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{update} {delete} {send}',
            'buttons' =>
				[

				'send' => function ($url, $model)
					{
						return html::a('<span class="glyphicon glyphicon-envelope"></span>', Url::toRoute(['/email-queues/send', 'id' => $model->id]), [
                                    'title' => 'Send Message',
                                    ]);

					}
				]
            ],
        ],
    ]); ?>
</div>
