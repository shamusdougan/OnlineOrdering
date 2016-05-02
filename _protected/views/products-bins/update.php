<?php

use yii\helpers\Html;
use vendor\actionButtons\actionButtonsWidget;

/* @var $this yii\web\View */
/* @var $model app\models\ProductsBins */
/* @var $actionItems  */

$this->title = 'Update Products Bins: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products Bins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="products-bins-update">

	<?= actionButtonsWidget::widget(['items' => $actionItems]) ?> 
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
