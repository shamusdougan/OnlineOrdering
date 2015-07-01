<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\contactsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contacts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contacts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Contacts', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'First_Name',
            'Last_Name',
            'Business_Phone',
            'Mobile_Phone',
            'Email:email',
            [
            	'attribute' => 'company',
            	'value' => 'company.Company_Name'
            ],
            
     
            'Address_1_Street_1',
            'Address_1_Street_2',
            'Address_1_TownSuburbCity',
            'Address_1_Postal_Code',
            'Do_Not_Allow_Bulk_Emails:boolean',
            'Do_Not_Allow_Bulk_Mails:boolean',
            'Do_Not_Allow_Emails:boolean',
            'Do_Not_Allow_Faxes:boolean',
            'Do_Not_Allow_Mails:boolean',
            'Do_Not_Allow_Phone_Calls:boolean',


            ['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['style' => 'width:80px; white-space: nowrap;'],],
        ],
    ]); ?>

</div>
