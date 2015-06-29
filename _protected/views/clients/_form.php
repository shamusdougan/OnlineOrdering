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

<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL] ); 


 $companyInfo = Form::widget([
    	'model'=>$model,
    	'form'=>$form,
    	'columns'=>3,
    	'attributes'=>[
			'Company_Name'=>['label' => 'Name', 'type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Companny Name']],
			'Trading_as'=>['label' => 'Trading','type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Trading as...']],
			'Status'=>['label' => 'Status', 'type'=>Form::INPUT_DROPDOWN_LIST, 'items' => Lookup::items("CLIENT_STATUS")  ],
    				 
      	]
    ]);
  	
	$companyInfo .= Form::widget(
		[
		'model' => $model,
		'form' => $form,
		'columns' => 4,
		'attributes' => 
			[
			'Is_Customer' => ['type'=>Form::INPUT_CHECKBOX, 'label' => 'Customer' ], 
			'Is_Factory' => ['type' =>Form::INPUT_CHECKBOX, 'label' => 'Factory'],
			'Is_Supplier' => ['type' =>Form::INPUT_CHECKBOX, 'label' => 'Supplier'],
			]
		]);
	 	
	$companyInfo .= "<br><b>Contact Information</b><HR>";
	
	$companyInfo .= Form::Widget(
		[
		'model' => $model,
		'form' => $form,
		'columns' => 3,
		'attributes' =>
			[
			'Main_Phone' => ['type' => Form::INPUT_TEXT, 'label' => 'Phone'	],
			'Mobile_Phone' => ['type' => Form::INPUT_TEXT,'label' => 'Mobile'],
			'Fax' => ['type' => Form::INPUT_TEXT, 'label' => 'Fax'],
			'Email' =>['type' => Form::INPUT_TEXT,'label' => 'Email'],
			'Website' =>['type' => Form::INPUT_TEXT,'label' => 'Webpage'],
			]
		]);
		
	$companyInfo .= "<br><b>Address Information</b><HR>";		
	 	
	$companyInfo .= Form::widget(
		[
		'model' => $model,
		'form' => $form,
		'columns' => 4,
		
		'attributes' => 
			[
			'Address_1_Street_1' => ['type'=>Form::INPUT_TEXT, 'label' => 'Main Address',	'options' =>['placeholder' => 'Address line 1'], 'columnOptions'=>['colspan'=>2 ]], 
			'Address_2_Street_1' => ['type'=>Form::INPUT_TEXT, 'label' => 'Billing/Postal Address',	'options' =>['placeholder' => 'Address line 1'], 'columnOptions'=>['colspan'=>2 ]],
			'Address_1_Street_2' => ['type'=>Form::INPUT_TEXT, 'label' => false,	'options' =>['placeholder' => 'Address line 2'], 'columnOptions'=>['colspan'=>2 ]], 
			'Address_2_Street_2' => ['type'=>Form::INPUT_TEXT, 'label' => false,	'options' =>['placeholder' => 'Address line 2'], 'columnOptions'=>['colspan'=>2 ]], 			
			'Address_1_TownSuburb' =>['type' => Form::INPUT_TEXT, 'label' => 'City', 'options' =>['placeholder' => 'City...']],
			'Address_1_Postal_Code' =>['type' => Form::INPUT_TEXT,'label' => 'Postcode', 'options' =>['placeholder' => 'Postcode...']],	
			'Address_2_TownSuburb' =>['type' => Form::INPUT_TEXT, 'label' => 'City', 'options' =>['placeholder' => 'Postal/Billing City...']],
			'Address_2_Postal_Code' =>['type' => Form::INPUT_TEXT,'label' => 'Postcode','options' =>['placeholder' => 'Billing Postcode...']],		
			'Address_1_Telephone_1' =>['type' => Form::INPUT_TEXT,'label' => 'Phone','options' =>['placeholder' => 'Address Phone...']],
			'Address_1_Telephone_2' =>['type' => Form::INPUT_TEXT,'label' => 'Fax', 'options' =>['placeholder' => 'Address Fax...']],
			'Address_2_Telephone_1' =>['type' => Form::INPUT_TEXT,'label' => 'Phone','options' =>['placeholder' => 'Postal/Billing Phone...']],
			'Address_2_Telephone_2' =>['type' => Form::INPUT_TEXT,'label' => 'Fax', 'options' =>['placeholder' => 'Postal/Billing Fax...']],	
			]
		]);

	$companyInfo .= "<br><b>Company Details</b><HR>";		

	$companyInfo .= Form::widget(
		[
		'model' => $model,
		'form' => $form,
		'columns' => 3,
		
		'attributes' => 
			[
			'Owner' => ['type' => Form::INPUT_TEXT],
			'Main_Competitor' => ['type' => Form::INPUT_TEXT],
			'Map_Reference' => ['type' => Form::INPUT_TEXT],
			'Nearest_Town' => ['type' => Form::INPUT_TEXT],
			'Parent_Region' => ['type' => Form::INPUT_TEXT],
			'Sub_Region' => ['type' => Form::INPUT_TEXT],
			'Property_Name' => ['type' => Form::INPUT_TEXT],
			'Preferred_Day' => ['type' => Form::INPUT_TEXT],
			'Preferred_FacilityEquipment' => ['type' => Form::INPUT_TEXT],
			'Delivery_Directions' => ['type' => Form::INPUT_TEXTAREA, 'columnOptions'=>['colspan'=>3 ]],
			
			]
			]);	

			
			
			
			

$companyAccounts = Form::widget(
	[
		'model'=>$model,
    	'form'=>$form,
    	'columns'=>2,
    	
    	'attributes'=>
    		[
    		'Status'=>['label' => 'Billing Type', 'type'=>Form::INPUT_DROPDOWN_LIST, 'items' => Lookup::items("BILLING_TYPE")],
    		'3rd_Party_Company' => 
    			[
				'type' => Form::INPUT_WIDGET,
				'widgetClass' => '\kartik\widgets\Select2',
				'options'=>
					[
					'data'=>$clientList,
					'options' => ['placeholder' => 'Select Client....']
					],
				'label' => '3rd Party Billing Company'
    			],	
    		'ABN' => ['label' => 'ABN/ACN'],
    		'Business_Type'=>
    			[
				'type' => Form::INPUT_WIDGET,
				'widgetClass' => '\kartik\widgets\Select2',
				'options'=>
					[
					'data'=>Lookup::items("BUSINESS_TYPE"),
					'options' => ['placeholder' => 'Select Business Type...']
					],
				'label' => 'Company Type'
    			],	
      		]
    ]);
    		
   
$companyAccounts .= Form::widget(
	[
		'model'=>$model,
    	'form'=>$form,
    	'columns'=>3,
    	
    	'attributes'=> 
    		[
    		'Credit_Hold' => ['type'=>Form::INPUT_CHECKBOX, 'label' => 'Credit Hold' ], 
    		'Is_Internal' => ['type'=>Form::INPUT_CHECKBOX, 'label' => 'Internal Only' ], 
    		'Is_Provider' => ['type'=>Form::INPUT_CHECKBOX, 'label' => 'Provider' ], 
    		]		
	]);
	
$companyAccounts .= Form::widget(
	[
		'model'=>$model,
    	'form'=>$form,
    	'columns'=>2,
    	
    	'attributes'=> 
    		[
    		'Payment_Terms' => ['type' => Form::INPUT_TEXT,	'label' => 'Payment Terms'],			
    		]
    		
	]);	
	
	
$companyContact =  Form::widget(
		[
		'model' => $model,
		'form' => $form,
		'columns' => 4,
		'attributes' => 
			[
			'Do_not_allow_Bulk_Emails' => ['type'=>Form::INPUT_CHECKBOX, 'label' => 'No Bulk Emails' ], 
			'Do_not_allow_Bulk_Mails' => ['type' =>Form::INPUT_CHECKBOX, 'label' => 'No Bulk Mail'],
			'Do_not_allow_Emails' => ['type' =>Form::INPUT_CHECKBOX, 'label' => 'No Emails'],
			'Do_not_allow_Faxes' => ['type' =>Form::INPUT_CHECKBOX, 'label' => 'No Faxes'],
			'Do_not_allow_Mails' => ['type' =>Form::INPUT_CHECKBOX, 'label' => 'No Mail'],
			'Do_not_allow_Phone_Calls' => ['type' =>Form::INPUT_CHECKBOX, 'label' => 'no Phone'],
			]
		]);

$items = 
	[
		[			
		'label'=>'<i class="glyphicon glyphicon-home"></i> Company',
		'content'=>$companyInfo,
		'active'=>true
		],
		[
		'label'=>'<i class="glyphicon glyphicon-tags"></i> Herd Info',
		'content'=>$companyAccounts,
		],
		[
		'label'=>'<i class="glyphicon glyphicon-user"></i> Contacts',
		'content'=>$companyContact,
		],
		[
		'label'=>'<i class="glyphicon glyphicon-list-alt"></i> Accounts',
		'content'=>$companyAccounts,
		],
	];
	
	

echo TabsX::widget([
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		'encodeLabels'=>false
]);

?>

  


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
    
    <?= $form->field($model, 'Supplies_to')->textInput(['maxlength' => true]) ?>
    
      <?= $form->field($model, 'Dairy_No')->textInput() ?>

    <?= $form->field($model, 'Dairy_Notes')->textInput(['maxlength' => true]) ?>

    




    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
