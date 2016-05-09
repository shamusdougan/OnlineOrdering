<?php

use yii\helpers\Html;
use vendor\actionButtons\actionButtonsWidget;
use vendor\orderState\orderStateWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Returns */
/* @var $actionItems  */

$this->title = 'Update Returns: ' . $model->name;
//$this->params['breadcrumbs'][] = ['label' => 'Returns', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="returns-update">

	<?= orderStateWidget::widget(['object' => $model]) ?>
	<?= actionButtonsWidget::widget(['items' => $actionItems]) ?> 
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'delivery' => $delivery,
    ]) ?>

</div>
