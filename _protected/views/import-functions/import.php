<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vendor\actionButtons\actionButtonsWidget;

$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	 <?= actionButtonsWidget::widget(['items' => $actionItems]) ?>
 <h1><?= Html::encode("Import ".$model->name) ?></h1>

<?= $form->field($model, 'progress')->textarea(['rows' => '20']) ?>

<?= $form->field($model, 'file')->fileInput() ?>





<button>Submit</button>

<?php ActiveForm::end(); ?>