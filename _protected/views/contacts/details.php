<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\detail\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\contacts */
/* @var $form yii\widgets\ActiveForm */
  

$this->params['breadcrumbs'][] = ['label' => 'Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->fullname;

if(!isset($mode)){
	$mode = 'edit';
}
   
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
   
   
 echo  DetailView::widget([
		'model'=>$model,
		'condensed'=>true,
		'hover'=>true,
		'mode'=>$mode,
		'panel'=>[
			'heading'=>'Contact',
			'type'=>DetailView::TYPE_INFO,
			],
			
		'formOptions' => ['action' => Url::current(), 'id' => 'contact-form'],
		'attributes' => $attributes,
		'buttons1' => '{update}',
		'buttons2' => '{save}'

    ]) ?>
  

 


</div>