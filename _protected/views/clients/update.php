<?php

use yii\helpers\Html;

use vendor\actionButtons\actionButtonsWidget;

/* @var $this yii\web\View */
/* @var $model app\models\clients */

$this->title = $model->Company_Name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Company_Name];
?>
<div class="clients-update">

    <h1><?= Html::encode($this->title) ?> <?= $model->isOnCreditHold() ? "<span style='color: red'> Credit Hold </span>" : "" ?></h1>
  	<p><?= actionButtonsWidget::widget(['items' => $actionItems])  ?></p>
  	
  

  	
    <?= $this->render('_form', [
        'model' => $model, 
        'clientList' => $clientList, 
        'userList' => $userList, 
        'readOnly' => $readOnly,
        'changeCreditHold' => $changeCreditHold
    ]) ?>

</div>
