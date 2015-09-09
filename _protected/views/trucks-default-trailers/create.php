<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrucksDefaultTrailers */

$this->title = 'Create Trucks Default Trailers';
$this->params['breadcrumbs'][] = ['label' => 'Trucks Default Trailers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trucks-default-trailers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
