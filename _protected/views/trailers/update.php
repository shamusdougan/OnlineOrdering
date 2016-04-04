<?php

use yii\helpers\Html;
use vendor\actionButtons\actionButtonsWidget;

/* @var $this yii\web\View */
/* @var $model app\models\trailers */

$this->title = 'Trailer Details: ' . ' ' . $model->Registration;
$this->params['breadcrumbs'][] = ['label' => 'Trailers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="trailers-update">

	<?= actionButtonsWidget::widget(['items' => $actionItems]) ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
