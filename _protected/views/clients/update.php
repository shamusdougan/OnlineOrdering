<?php

use yii\helpers\Html;

use app\components\actionButtons;

/* @var $this yii\web\View */
/* @var $model app\models\clients */

$this->title = $model->Company_Name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Company_Name];
?>
<div class="clients-update">

    <h1><?= Html::encode($this->title) ?></h1>
  	<p><?= actionButtons::widget(['items' => $actionItems])  ?></p>
    <?= $this->render('_form', [
        'model' => $model, 'clientList' => $clientList, 'userList' => $userList
    ]) ?>

</div>
