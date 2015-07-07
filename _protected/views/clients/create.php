<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\clients */

$this->title = 'Create Clients';
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-create">

<div class="contacts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $this->render('_form', [
        'model' => $model, 'clientList' => $clientList, 'userList' => $userList
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
