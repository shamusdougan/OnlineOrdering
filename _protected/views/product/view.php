<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'Name',
            'Product_ID',
            'Description',
            'Status',
            'cp',
            'Decimals_Supported',
            'Default_Unit',
            'Feed_notes',
            'List_Price_pT_Base',
            'me',
            'Mix_Margin',
            'Mix_Margin_Base',
            'Mix_Type',
            'ndf',
            'Product_Category',
            'Retail_Price_t',
        ],
    ]) ?>

</div>
