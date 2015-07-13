<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomerOrdersIngredientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customer Orders Ingredients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-orders-ingredients-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Customer Orders Ingredients', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'created_on',
            'category',
            'ingredient_id',
            'ingredient_percent',
            // 'modified_by',
            // 'modified_on',
            // 'order_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
