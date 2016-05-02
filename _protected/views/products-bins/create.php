<?php

use yii\helpers\Html;
use vendor\actionButtons\actionButtonsWidget;


/* @var $this yii\web\View */
/* @var $model app\models\ProductsBins */
/* @var $actionItems  */

$this->title = 'Create Products Bins';
$this->params['breadcrumbs'][] = ['label' => 'Products Bins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-bins-create">

	<?= actionButtonsWidget::widget(['items' => $actionItems]) ?> 
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
