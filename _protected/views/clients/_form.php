<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\tabs\TabsX;
use app\models\Lookup;

/* @var $this yii\web\View */
/* @var $model app\models\clients */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clients-form">

<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL] ); 


 $content1 = Form::widget([
    	'model'=>$model,
    	'form'=>$form,
    	'columns'=>2,
    	'attributes'=>[
			'Company_Name'=>['label' => 'Name', 'type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Companny Name']],
			'Trading_as'=>['label' => 'Trading','type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Trading as...']]

    				 
      	]
    ]);
  $content1 .= Form::widget(
  		[
		'model'=>$model,
    	'form'=>$form,
    	'columns'=>2,
    	'attributes'=>
    		[
    		'Status'=>['label' => 'Status', 'type'=>Form::INPUT_DROPDOWN_LIST, 'items' => Lookup::items("CLIENT_STATUS")  ],
    		'ABN' => ['label' => 'ABN/ACN']
    		]
    	]);
    	
    	
    	
	$content1 .= Form::widget(
		[
		'model' => $model,
		'form' => $form,
		'columns' => 4,
		'attributes' => 
			[
			'Is_Customer' => ['type'=>Form::INPUT_CHECKBOX, 'label' => 'Customer' ], 
			'Is_Factory' => ['type' =>Form::INPUT_CHECKBOX, 'label' => 'Factory'],
			'Is_Supplier' => ['type' =>Form::INPUT_CHECKBOX, 'label' => 'Supplier'],
			'3rd_Party_Company' => ['type' =>Form::INPUT_CHECKBOX, 'label' => 'Other Provider'],
			]
		]);
	 	
	$content1 .= Form::widget(
		[
		'model' => $model,
		'form' => $form,
		'columns' => 2,
		
		'attributes' => 
			[
			'Address_1_Street_1' => 
				[
				'type'=>Form::INPUT_TEXT, 
				'label' => 'Address',
				'labelspan' => 1,
				'columnOptions'=>['colspan'=>2 ],
				'options' =>
					[
					'placeholder' => 'Address line 1'
					],
			
				], 
			'Address_1_Street_2' => 
				[
				'type'=>Form::INPUT_TEXT, 
				'label' => '',
				'labelSpan' => 1,
				'columnOptions'=>['colspan'=>2 ],
				'options' =>
					[
					'placeholder' => 'Address line 2',
					]
				], 
			
			'Address_1_TownSuburb' =>
				[
				'type' => Form::INPUT_TEXT,
				'label' => 'City',
				'options' =>
					[
					'placeholder' => 'City'
					]
				],
			'Address_1_Postal_Code' =>
				[
				'type' => Form::INPUT_TEXT,
				'label' => 'Postcode',
				],	
			'Main_Phone' =>
				[
				'type' => Form::INPUT_TEXT,
				'label' => 'Phone'
				],
			'Fax' =>
				[
				'type' => Form::INPUT_TEXT,
				'label' => 'Fax'
				]
				
			]
		
		
		]);

$content2 = "Hello world";
$items = 
	[
		[			
		'label'=>'<i class="glyphicon glyphicon-home"></i> Company',
		'content'=>$content1,
		'active'=>true
		],
		[
		'label'=>'<i class="glyphicon glyphicon-user"></i> Herd',
		'content'=>$content2,

		],
	];

echo TabsX::widget([
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		'encodeLabels'=>false
]);

?>

    
 

    <?= $form->field($model, 'Address_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Address_Type')->textInput() ?>

    <?= $form->field($model, 'Address_2_CountryRegion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Postal_Code')->textInput() ?>

    <?= $form->field($model, 'Address_2_StateProvince')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Street_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Street_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Street_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Telephone_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Telephone_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_Telephone_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_2_TownSuburb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address_Phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Address1_IsBillTo')->checkbox() ?>

    <?= $form->field($model, 'Address1_IsShipTo')->checkbox() ?>

    <?= $form->field($model, 'Billing_company_admin_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Billing_company_admin_fee_Base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Billing_contact')->textInput() ?>

    <?= $form->field($model, 'Billing_type')->textInput() ?>

    <?= $form->field($model, 'Business_Type')->textInput() ?>

    <?= $form->field($model, 'Category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Client_Status')->textInput() ?>

    <?= $form->field($model, 'Copy_addess')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Copy_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Created_By')->textInput() ?>

    <?= $form->field($model, 'Created_On')->textInput() ?>

    <?= $form->field($model, 'Credit_Hold')->checkbox() ?>

    <?= $form->field($model, 'Dairy_No')->textInput() ?>

    <?= $form->field($model, 'Dairy_Notes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Delivery_Directions')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Do_not_allow_Bulk_Emails')->checkbox() ?>

    <?= $form->field($model, 'Do_not_allow_Bulk_Mails')->checkbox() ?>

    <?= $form->field($model, 'Do_not_allow_Emails')->checkbox() ?>

    <?= $form->field($model, 'Do_not_allow_Faxes')->checkbox() ?>

    <?= $form->field($model, 'Do_not_allow_Mails')->checkbox() ?>

    <?= $form->field($model, 'Do_not_allow_Phone_Calls')->checkbox() ?>

    <?= $form->field($model, 'Email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Email_Address_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Email_Address_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Exchange_Rate')->textInput() ?>

    <?= $form->field($model, 'Farm_Mgr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Farm_No')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Farm_Operation')->textInput() ?>

    <?= $form->field($model, 'Feed_Days_Remaining')->textInput() ?>

    <?= $form->field($model, 'Feed_empty')->textInput() ?>

    <?= $form->field($model, 'Feed_QOH_Tonnes')->textInput() ?>

    <?= $form->field($model, 'Feed_QOH_Update')->textInput() ?>

    <?= $form->field($model, 'Feed_Rate_Kg_Day')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Herd_Notes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Herd_Size')->textInput() ?>

    <?= $form->field($model, 'Herd_Type')->textInput() ?>

    <?= $form->field($model, 'Is_Internal')->checkbox() ?>

    <?= $form->field($model, 'Is_Provider')->checkbox() ?>

    <?= $form->field($model, 'Main_Competitor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Map_Reference')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Mobile_Phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Modified_By')->textInput() ?>

    <?= $form->field($model, 'Modified_On')->textInput() ?>

    <?= $form->field($model, 'Nearest_Town')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'No_of_Employees')->textInput() ?>

    <?= $form->field($model, 'Owner')->textInput() ?>

    <?= $form->field($model, 'Parent_Region')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Payment_Terms')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Preferred_Day')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Preferred_FacilityEquipment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Property_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Status')->textInput() ?>

    <?= $form->field($model, 'Sub_Region')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Supplies_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Trading_as')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Website')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
