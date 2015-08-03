<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\trailers */

$this->title = 'Create Trailers';
$this->params['breadcrumbs'][] = ['label' => 'Trailers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trailers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
