<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vendor\actionButtons\actionButtonsWidget;
use app\models\ImportFunctions;

$form = ActiveForm::begin(); ?>

	 <?= actionButtonsWidget::widget(['items' => $actionItems]) ?>
 <h1><?= Html::encode("Import ".$importModel->name) ?></h1>

<?= $form->field($importModel, 'progress')->textarea(['rows' => '20']) ?>









<?php ActiveForm::end(); ?>