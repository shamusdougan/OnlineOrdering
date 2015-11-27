<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use vendor\actionButtons\actionButtonsWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\clientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
      <p><?= actionButtonsWidget::widget(['items' => $actionItems])  ?></p>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'columns' => 
        	[
        		[
        		'attribute' => 'Company_Name',
        		'format' => 'raw',
        		'value' => function ($data)
        			{
					return html::a($data->Company_Name, "/clients/update?id=".$data->id);
					},
        		],
        	'Trading_as',
 			'Account_Number',
            'Address_1_TownSuburb',
            'Main_Phone',
         
        	[
			'attribute' => 'Owner_id',
			'value' => 'owner.fullname',
			'label' => 'Owner',
			'filter' => $userList,
			],
        	],
        'rowOptions' => function ($model, $key, $index, $grid)
        	{
				return ['id' => $model['id'], 'dblclick' => 'alert(this.id);'];
			},
		'hover' => true,
		'striped' => false,
    ]); ?>

</div>
