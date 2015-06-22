<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\clients */

$this->title = 'Update Clients: ' . ' ' . $model->Company_Name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Company_Name, 'url' => ['view', 'id' => $model->Company_Name]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="clients-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
