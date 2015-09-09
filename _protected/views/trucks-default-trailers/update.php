<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrucksDefaultTrailers */

$this->title = 'Update Trucks Default Trailers: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trucks Default Trailers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="trucks-default-trailers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
