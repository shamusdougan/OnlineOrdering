<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\tabs\TabsX;
use kartik\grid\GridView;
use app\models\Lookup;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model app\models\clients */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clients-form">

<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id'=>'client_edit_form'] ); 


 $companyInfo = Form::widget([
    	'model'=>$model,
    	'form'=>$form,
    	'columns'=>3,
    	'attributes'=>[
			'Company_Name'=>['label' => 'Name', 'type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Companny Name']],
			'Trading_as'=>['label' => 'Trading','type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Trading as...']],
			'Status'=>['label' => 'Status', 'type'=>Form::INPUT_DROPDOWN_LIST, 'items' => Lookup::items("CLIENT_STATUS")  ],
			'owner' => ['type'=>Form::INPUT_DROPDOWN_LIST, 'items' => $userList ],
			'Main_Competitor' => ['type' => Form::INPUT_TEXT],
    				 
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
			
			'Map_Reference' => ['type' => Form::INPUT_TEXT],
			'Nearest_Town' => ['type' => Form::INPUT_TEXT],
			'Parent_Region' => ['type' => Form::INPUT_TEXT],
			'Sub_Region' => ['type' => Form::INPUT_TEXT],	
			]
		]);

	$companyInfo .= "<br><b>Delivery Details</b><HR>";		

	$companyInfo .= Form::widget(
		[
		'model' => $model,
		'form' => $form,
		'columns' => 3,
		
		'attributes' => 
			[
			
			
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
	
	
/**
* 
* @var Contacts Page for Clients
* 
*/
	
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
	
	







	
		

		
		
		
		
		
		
		
		
		
/**
* 
* @var Herd information page for clients
* 
*/	
		
$companyHerd = Form::widget(
	[
	'model' => $model,
	'form' => $form,
	'columns' => 3,
	'attributes' => 
		[
		'Farm_Mgr' => ['type' => Form::INPUT_TEXT,	'label' => 'Farm Manager'],	
		'Farm_No' => ['type' => Form::INPUT_TEXT,	'label' => 'Farm Number'],	
		'Farm_Operation'=>
    			[
				'type' => Form::INPUT_WIDGET,
				'widgetClass' => '\kartik\widgets\Select2',
				'options'=>
					[
					'data'=> Lookup::items("FARM_OPERATION"),
					'options' => ['placeholder' => 'Select Business Type...']
					],
				'label' => 'Farm Operation'
    			],	
    	'Herd_Size' => ['type' => Form::INPUT_TEXT,	'label' => 'Herd Size'],	
		]
	]);
	
$companyHerd = Form::widget(
	[
	'model' => $model,
	'form' => $form,
	'columns' => 3,
	'attributes' => 
		[
		'Herd_Type'=>
			[
				'type' => Form::INPUT_WIDGET,
				'widgetClass' => '\kartik\widgets\Select2',
				'options'=>
					[
					'data'=> Lookup::items("HERD_TYPE"),
					'options' => ['placeholder' => 'Select Herd Type....']
					],
				'label' => 'Herd Type'
			],	
		'Herd_Size' => ['type' => Form::INPUT_TEXT,	'label' => 'Herd Size'],	
		'Herd_Notes' => ['type' => Form::INPUT_TEXTAREA, 'columnOptions'=>['colspan'=>3 ]],
		'Supplies_to' => ['type' => Form::INPUT_TEXT,	'label' => 'Supplies to'],
		'Dairy_No' => ['type' => Form::INPUT_TEXT,	'label' => 'Dairy Number'],
		'Dairy_Notes' => ['type' => Form::INPUT_TEXTAREA, 'columnOptions'=>['colspan'=>3 ]],
    	]
    ]);

	
$companyHerd .= Form::widget(
	[
	'model' => $model,
	'form' => $form,
	'columns' => 3,
	'attributes' => 
		[
		'Feed_Days_Remaining' => ['type' => Form::INPUT_TEXT],	
		'Feed_empty' => ['type' => Form::INPUT_TEXT],	
		'Feed_QOH_Tonnes' => ['type' => Form::INPUT_TEXT],	
		'Feed_QOH_Update' => ['type' => Form::INPUT_TEXT],	
		'Feed_Rate_Kg_Day' => ['type' => Form::INPUT_TEXT],	
		
		]
	]);

$items = 
	[
		[			
		'label'=>'<i class="glyphicon glyphicon-home"></i> Company',
		'content'=>$companyInfo,
		],
		
		[
		'label'=>'<i class="glyphicon glyphicon-tags"></i> Herd Info',
		'content'=>$companyHerd,
		],
		[
			'label'=>'<i class="glyphicon glyphicon-user"></i> Contacts',
			'content'=>$this->render("_contactGrid", ['model' => $model, 'form' => $form]),

		],
		[
		'label'=>'<i class="glyphicon glyphicon-list-alt"></i> Accounts',
		'content'=>$companyAccounts,
		],
		[
		'label'=>'<i class="glyphicon glyphicon-download-alt"></i> Storage',
		'content'=>$this->render("_storageGrid", ['model' => $model, 'form' => $form]),
		'active'=>true
		],
		
		
	];
	
	

echo TabsX::widget([
		'items'=> $items,
		'position'=>TabsX::POS_ABOVE,
		'encodeLabels'=>false
]);


?>





    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

<?php		
Modal::begin([
    'id' => 'activity-modal',
    'header' => '<h4 class="modal-title">Contact Information</h4>',
    'size' => 'modal-lg',

]);		?>


<div id="modal_content"></div>

<?php

Modal::end(); 
		
?>

</div>
