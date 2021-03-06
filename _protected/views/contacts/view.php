<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\contacts */

$this->params['breadcrumbs'][] = ['label' => 'Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->fullname;


$attributes = [
		[
			'group'=>true,
			'label'=>'Contact\'s Name',
			'rowOptions'=>['class'=>'info'],
		], 
		'First_Name',
		'Last_Name',
		'Job_Title',
		[
			'group'=>true,
			'label'=>'Contact Info',
			'rowOptions'=>['class'=>'info'],
		], 
		'Business_Phone',
		'Email',
		'Fax',
		[
			'group'=>true,
			'label'=>'Address Information',
			'rowOptions'=>['class'=>'info'],
		], 
		'Address_1_Street_1',
		'Address_1_Street_2',
		'Address_1_TownSuburbCity',
		'Address_1_StateProvince',
		'Address_1_Postal_Code',
		[
			'attribute' => 'Do_Not_Allow_Bulk_Emails',
			'type' => DetailView::INPUT_CHECKBOX,
			'options' => ['label' => false]

		],

		'Do_Not_Allow_Bulk_Mails',
		'Do_Not_Allow_Emails',
		'Do_Not_Allow_Faxes',
		'Do_Not_Allow_Mails',
		'Do_Not_Allow_Phone_Calls',
	 ];
?>


     <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>
</div>
