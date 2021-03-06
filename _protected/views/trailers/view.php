<?php

use yii\helpers\Html;
use kartik\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\trailers */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trailers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trailers-view">

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
    	'export' => false,
        'model' => $model,
        'attributes' => [
            'id',
            'Registration',
            'Description',
            'Max_Capacity',
            'NumBins',
            'Auger',
            'Blower',
            'Tipper',
            'Status',
        ],
    ]) ?>

</div>
