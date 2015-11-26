<?php

use yii\helpers\Html;
use vendor\actionButtons\actionButtonsWidget;

/* @var $this yii\web\View */
/* @var $model app\models\clients */

$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Company_Name];








?>
<div class="clients-update">

    <h1><?= Html::encode($this->title) ?></h1>
  	<p><?= actionButtonsWidget::widget(['items' => $actionItems])  ?></p>


<div class="clients-create">



  

    <?= $this->render('_createForm', [
        'model' => $model, 'clientList' => $clientList
    ]) ?>



</div>
