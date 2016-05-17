<?php

use yii\helpers\Html;
use vendor\actionButtons\actionButtonsWidget;


/* @var $this yii\web\View */
/* @var $model app\models\trucks */

$this->title = 'Create Truck';
$this->params['breadcrumbs'][] = ['label' => 'Trucks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trucks-create">

 	<?= actionButtonsWidget::widget(['items' => $actionItems]) ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'trailerList' => $trailerList,
    ]) ?>

</div>
