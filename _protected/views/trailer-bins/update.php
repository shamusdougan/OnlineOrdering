<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrailerBins */

$this->title = 'Update Trailer Bins: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trailer Bins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="trailer-bins-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
