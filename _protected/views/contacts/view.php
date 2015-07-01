<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\contacts */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contacts-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'Business_Phone',
            'Address_1',
            'Address_1_CountryRegion',
            'Address_1_Postal_Code',
            'Address_1_StateProvince',
            'Address_1_Street_1',
            'Address_1_Street_2',
            'Do_Not_Allow_Bulk_Emails:boolean',
            'Do_Not_Allow_Bulk_Mails:boolean',
            'Do_Not_Allow_Emails:boolean',
            'Do_Not_Allow_Faxes:boolean',
            'Do_Not_Allow_Mails:boolean',
            'Do_Not_Allow_Phone_Calls:boolean',
            'Email:email',
            'Fax',
            'First_Name',
            'Job_Title',
            'Last_Name',
            'Mobile_Phone',
            'Company',
        ],
    ]) ?>

</div>
