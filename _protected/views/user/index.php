<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use kartik\grid\GridView;
use vendor\actionButtons\actionButtonsWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1>

 	<h1><?= Html::encode($this->title) ?></h1>
    
      <p><?= actionButtonsWidget::widget(['items' => $actionItems])  ?></p>

    

    </h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'summary' => false,
        'columns' => [
           
            'username',
            'fullname',
            'email:email',
            // status
            [
                'attribute'=>'status',
                'filter' => $searchModel->statusList,
                'value' => function ($data) {
                    return $data->statusName;
                },
                'contentOptions'=>function($model, $key, $index, $column) {
                    return ['class'=>CssHelper::statusCss($model->statusName)];
                }
            ],
            // role
            [
                'attribute'=>'item_name',
                'filter' => $searchModel->rolesList,
                'value' => function ($data) {
                    return $data->roleName;
                },
                'contentOptions'=>function($model, $key, $index, $column) {

                    return ['class'=>CssHelper::roleCss($model->roleName)];
                }
            ],
            // buttons
            ['class' => 'yii\grid\ActionColumn',
            'header' => "Menu",
            'template' => '{update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('', $url, ['title'=>'View user', 
                            'class'=>'glyphicon glyphicon-eye-open']);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('', $url, ['title'=>'Manage user', 
                            'class'=>'glyphicon glyphicon-user']);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('', $url, 
                        ['title'=>'Delete user', 
                            'class'=>'glyphicon glyphicon-trash',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this user?'),
                                'method' => 'post']
                        ]);
                    }
                ]
            ], // ActionColumn
        ], // columns
    ]); ?>

</div>
