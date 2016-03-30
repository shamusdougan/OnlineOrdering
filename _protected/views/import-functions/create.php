<?php

use yii\helpers\Html;
use vendor\actionButtons\actionButtonsWidget;


/* @var $this yii\web\View */
/* @var $model app\models\ImportFunctions */

$this->title = 'Create Import Functions';
$this->params['breadcrumbs'][] = ['label' => 'Import Functions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="import-functions-create">

 	<?= actionButtonsWidget::widget(['items' => $actionItems]) ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
