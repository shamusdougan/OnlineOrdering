<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\tabs\TabsX;
use kartik\grid\GridView;
use app\models\Lookup;
use yii\widgets\Pjax;
use kartik\datecontrol\DateControl;
use kartik\widgets\datePicker;


/* @var $this yii\web\View */
/* @var $model app\models\clients */
/* @var $form yii\widgets\ActiveForm */




?>

<div class="clients-form">

<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'id'=>'client_edit_form'] ); 

 //echo $model->getFeedQOH();
 $companyInfo = Form::widget([
    	'model'=>$model,
    	'form'=>$form,
    	'columns'=>3,
    	'attributes'=>[
			'Company_Name'=>['label' => 'Name', 'type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Companny Name', 'disabled' => $readOnly]],
			'Trading_as'=>['label' => 'Trading','type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Trading as...', 'disabled' => $readOnly,]],
			'Sales_Status'=>['label' => 'Status', 'type'=>Form::INPUT_DROPDOWN_LIST, 'items' => Lookup::items("CLIENT_STATUS"), 'options' => ['disabled' => $readOnly]  ],
			'Owner_id' => ['type'=>Form::INPUT_DROPDOWN_LIST, 'items' => $userList, 'options' => ['disabled' => $readOnly,] ],
			'Main_Competitor' => ['type' => Form::INPUT_TEXT, 'options' => ['disabled' => $readOnly,]],
    				 
      	]
    ]);
  	
	$companyInfo .= Form::widget(
		[
		'model' => $model,
		'form' => $form,
		'columns' => 4,
		'attributes' => 
			[
			'Is_Customer' => ['type'=>Form::INPUT_CHECKBOX, 'label' => 'Customer', 'options' => ['disabled' => $readOnly,]], 
			'Is_Factory' => ['type' =>Form::INPUT_CHECKBOX, 'label' => 'Factory', 'options' => ['disabled' => $readOnly,]],
			'Is_Supplier' => ['type' =>Form::INPUT_CHECKBOX, 'label' => 'Supplier', 'options' => ['disabled' => $readOnly,]],
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
			'Main_Phone' => ['type' => Form::INPUT_TEXT, 'label' => 'Phone', 'options' => ['disabled' => $readOnly,]	],
			'Mobile_Phone' => ['type' => Form::INPUT_TEXT,'label' => 'Mobile', 'options' => ['disabled' => $readOnly,]],
			'Fax' => ['type' => Form::INPUT_TEXT, 'label' => 'Fax', 'options' => ['disabled' => $readOnly,]],
			'Email' =>['type' => Form::INPUT_TEXT,'label' => 'Email', 'options' => ['disabled' => $readOnly,]],
			'Website' =>['type' => Form::INPUT_TEXT,'label' => 'Webpage', 'options' => ['disabled' => $readOnly,]],
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
			'Address_1_Street_1' => ['type'=>Form::INPUT_TEXT, 'label' => 'Main Address',	'options' =>['placeholder' => 'Address line 1', 'disabled' => $readOnly], 'columnOptions'=>['colspan'=>2 ]], 
			'Address_2_Street_1' => ['type'=>Form::INPUT_TEXT, 'label' => 'Billing/Postal Address',	'options' =>['placeholder' => 'Address line 1', 'disabled' => $readOnly], 'columnOptions'=>['colspan'=>2 ]],
			'Address_1_Street_2' => ['type'=>Form::INPUT_TEXT, 'label' => false,	'options' =>['placeholder' => 'Address line 2', 'disabled' => $readOnly],'columnOptions'=>['colspan'=>2 ]], 
			'Address_2_Street_2' => ['type'=>Form::INPUT_TEXT, 'label' => false,	'options' =>['placeholder' => 'Address line 2', 'disabled' => $readOnly], 'columnOptions'=>['colspan'=>2 ]], 			
			'Address_1_TownSuburb' =>['type' => Form::INPUT_TEXT, 'label' => 'City', 'options' =>['placeholder' => 'City...', 'disabled' => $readOnly], ],
			'Address_1_Postal_Code' =>['type' => Form::INPUT_TEXT,'label' => 'Postcode', 'options' =>['placeholder' => 'Postcode...', 'disabled' => $readOnly,]],	
			'Address_2_TownSuburb' =>['type' => Form::INPUT_TEXT, 'label' => 'City', 'options' =>['placeholder' => 'Postal/Billing City...', 'disabled' => $readOnly,]],
			'Address_2_Postal_Code' =>['type' => Form::INPUT_TEXT,'label' => 'Postcode','options' =>['placeholder' => 'Billing Postcode...', 'disabled' => $readOnly,]],		
			'Address_1_Telephone_1' =>['type' => Form::INPUT_TEXT,'label' => 'Phone','options' =>['placeholder' => 'Address Phone...', 'disabled' => $readOnly,]],
			'Address_1_Telephone_2' =>['type' => Form::INPUT_TEXT,'label' => 'Fax', 'options' =>['placeholder' => 'Address Fax...', 'disabled' => $readOnly,]],
			'Address_2_Telephone_1' =>['type' => Form::INPUT_TEXT,'label' => 'Phone','options' =>['placeholder' => 'Postal/Billing Phone...', 'disabled' => $readOnly,]],
			'Address_2_Telephone_2' =>['type' => Form::INPUT_TEXT,'label' => 'Fax', 'options' =>['placeholder' => 'Postal/Billing Fax...', 'disabled' => $readOnly,]],
			
			'Map_Reference' => ['type' => Form::INPUT_TEXT, 'options' => ['disabled' => $readOnly,]],
			'Nearest_Town' => ['type' => Form::INPUT_TEXT, 'options' => ['disabled' => $readOnly,]],
			'Parent_Region' => ['type' => Form::INPUT_TEXT, 'options' => ['disabled' => $readOnly,]],
			'Sub_Region' => ['type' => Form::INPUT_TEXT, 'options' => ['disabled' => $readOnly,]],	
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
			
			
			'Property_Name' => ['type' => Form::INPUT_TEXT, 'options' => ['disabled' => $readOnly,]],
			'Preferred_Day' => ['type' => Form::INPUT_TEXT, 'options' => ['disabled' => $readOnly,]],
			'Preferred_FacilityEquipment' => ['type' => Form::INPUT_TEXT, 'options' => ['disabled' => $readOnly,]],
			'Delivery_Directions' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['disabled' => $readOnly,], 'columnOptions'=>['colspan'=>3 ]],
			
			]
			]);	

			
			
			
			

$companyAccounts = Form::widget(
	[
		'model'=>$model,
    	'form'=>$form,
    	'columns'=>2,
    	
    	'attributes'=>
    		[
    		'Billing_type'=>
    			[
    			'label' => 'Billing Type', 
    			'type'=>Form::INPUT_DROPDOWN_LIST, 
    			'items' => Lookup::items("BILLING_TYPE"),
    			'options' => ['disabled' => $readOnly,],
    			],
    		'3rd_Party_Company' => 
    			[
				'type' => Form::INPUT_WIDGET,
				'widgetClass' => '\kartik\widgets\Select2',
				'options'=>
					[
					'data'=>$clientList,
					'options' => ['placeholder' => 'Select Client....', 'disabled' => $readOnly,]
					],
				'label' => '3rd Party Billing Company'
    			],	
    		'ABN' => ['label' => 'ABN/ACN', 'options' => ['disabled' => $readOnly,]],
    		'Business_Type'=>
    			[
				'type' => Form::INPUT_WIDGET,
				'widgetClass' => '\kartik\widgets\Select2',
				'options'=>
					[
					'data'=>Lookup::items("BUSINESS_TYPE"),
					'options' => ['placeholder' => 'Select Business Type...', 'disabled' => $readOnly,]
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
    		'Credit_Hold' => ['type'=>Form::INPUT_CHECKBOX, 'label' => 'Credit Hold', 'options' => ['disabled' => !($changeCreditHold),]], 
    		'Is_Internal' => ['type'=>Form::INPUT_CHECKBOX, 'label' => 'Internal Only', 'options' => ['disabled' => $readOnly,] ], 
    		'Is_Provider' => ['type'=>Form::INPUT_CHECKBOX, 'label' => 'Provider', 'options' => ['disabled' => $readOnly,] ], 
    		]		
	]);
	
$companyAccounts .= Form::widget(
	[
		'model'=>$model,
    	'form'=>$form,
    	'columns'=>2,
    	
    	'attributes'=> 
    		[
    		'Payment_Terms' => ['type' => Form::INPUT_TEXT,	'label' => 'Payment Terms', 'options' => ['disabled' => $readOnly,]],			
    		]
    		
	]);	
	
	
/**
* 
* @var Contacts Page for Clients
* 
*/

	







	
		

		
		
		
		
		
		
		
		
		
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
		'Feed_QOH_Tonnes' => ['type' => Form::INPUT_TEXT,],
		'Feed_QOH_Update' => 
			[
			'type'=>Form::INPUT_WIDGET, 
			'widgetClass' => DateControl::classname(),
			'options' => 
				[
				'type'=>DateControl::FORMAT_DATE,
				'options' =>
					[
					'type' => DatePicker::TYPE_COMPONENT_APPEND,
					'pluginOptions' =>
						[
						'autoclose' => true,
						'todayHighlight' => true,
						'endDate' => date("d M Y"),
						]
					]
				],
			
			],
		'Feed_Rate_Kg_Day' => ['type' => Form::INPUT_TEXT],	
		'Herd_Notes' => ['type' => Form::INPUT_TEXTAREA, 'columnOptions'=>['colspan'=>3 ]],
		'Supplies_to' => ['type' => Form::INPUT_TEXT,	'label' => 'Supplies to'],
		'Dairy_No' => ['type' => Form::INPUT_TEXT,	'label' => 'Dairy Number'],
		'Dairy_Notes' => ['type' => Form::INPUT_TEXTAREA, 'columnOptions'=>['colspan'=>3 ]],
    	]
    ]);

	


$items[] = [			
			'label'=>'<i class="glyphicon glyphicon-home"></i> Company',
			'content'=>$companyInfo,
			'active'=>true
			];
$items[] =	[
			'label'=>'<i class="glyphicon glyphicon-user"></i> Contacts',
			'content'=>$this->render("_contactGrid", ['model' => $model, 'form' => $form]),
			];
$items[] =	[
			'label'=>'<i class="glyphicon glyphicon-list-alt"></i> Accounts',
			'content'=>$companyAccounts,
			];

if($model->isCustomer())
	{
	$items[] =	[
		'label'=>'<i class="glyphicon glyphicon-tags"></i> Herd Info',
		'content'=>$companyHerd,
		];	
	$items[] =	[
		'label'=>'<i class="glyphicon glyphicon-download-alt"></i> Storage',
		'content'=>$this->render("_storageGrid", ['model' => $model, 'form' => $form]),
		];
	$items[] =	[
		'label'=>'<i class="glyphicon glyphicon-list-alt"></i> Orders',
		'content'=>$this->render("_ordersGrid", ['model' => $model, 'form' => $form]),
		];			
	}		
		
	
	

echo TabsX::widget([
		'items'=> $items,
		'position'=>TabsX::POS_ABOVE,
		'encodeLabels'=>false
]);


?>





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
