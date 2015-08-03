<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrailerBins */

$this->title = 'Create Trailer Bins';
$this->params['breadcrumbs'][] = ['label' => 'Trailer Bins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trailer-bins-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
