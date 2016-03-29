<?php

use yii\helpers\Html;
use vendor\actionButtons\actionButtonsWidget;


/* @var $this yii\web\View */
/* @var $model app\models\ImportFunctions */

$this->title = 'Update Import Functions: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Import Functions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="import-functions-update">

	 <?= actionButtonsWidget::widget(['items' => $actionItems]) ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
