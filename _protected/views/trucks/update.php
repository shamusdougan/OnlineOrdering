<?php

use yii\helpers\Html;
use app\components\actionButtons;

/* @var $this yii\web\View */
/* @var $model app\models\trucks */

$this->title = 'Update Truck: ' . ' ' . $model->registration;
$this->params['breadcrumbs'][] = ['label' => 'Trucks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="trucks-update">

	<?= actionButtons::widget(['items' => $actionItems]) ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'trailerList' => $trailerList,
    ]) ?>

</div>
