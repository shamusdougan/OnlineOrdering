<?php

use yii\helpers\Html;

use app\models\Lookup;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\Typeahead;
use kartik\widgets\datePicker;
use kartik\widgets\DepDrop;
use kartik\grid\GridView;
use yii\bootstrap\Modal;


use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\customerOrders */
/* @var $form yii\widgets\ActiveForm */
/* @var $clientlist app\models\clients*/

$this->registerJs("$('#customerorders-customer_id').on('change',function(){
    $.ajax({
        url: '".yii\helpers\Url::toRoute("customer-order/ajax-company-details")."',
        dataType: 'json',
        method: 'GET',
        data: {id: $(this).val()},
        success: function (data, textStatus, jqXHR) {
            $('#customerdetails-contactname').val(data.contact);
           	$('#customerdetails-phone').val(data.number);
           	$('#customerdetails-status').val(data.status);
           	$('#customerdetails-address').val(data.address);
           	$('#customerdetails-nearestTown').val(data.nearestTown);
           	$('#customerdetails-viewmore').show();
           	$('#customerdetails-readmorelink').attr('href', '".yii\helpers\Url::toRoute("clients/view?id=")."' + data.id);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('An error occured!');
            alert('Error in ajax request retriving customer details' );
        }
    });
});"); 

$this->registerJs("

function getIngredientSum()
{
	
	var sum = 0
	$(\".kv-editable-value\").each(function() 
 		{
		if(!isNaN($(this).text()) && $(this).text().length!=0) 
			{
           	sum += parseFloat($(this).text());
       		}
		});
	$(\"#".Html::getInputId($model, 'Percent_ingredients')."\").val(sum);
	
	return sum;
}


function updateOrderPricePerTonne()
{
	var sum = 0
	$(\".pricePerTon\").each(function() 
 		{
		if(!isNaN($(this).text()) && $(this).text().length!=0) 
			{
           	sum += parseFloat($(this).text());
       		}
		});
	$(\"#".Html::getInputId($model, 'Price_pT')."\").val(sum);
	
	return sum;
}




");


$this->registerJs("
$(document).on('pjax:end', function() {
   getIngredientSum();
   updateOrderPricePerTonne();
    });
");


?>

<div class="customer-orders-form">
		<div class='customer-orders-form-pricing'>
			<fieldset>
		    
		    		<div class='order_info'>
		    			<b>Owner:</b> <input class='order_info_input' type='text' id='customerdetails-contactname'  readonly>
		    			<b>Phone: </b><input type='text' id='customerdetails-phone' readonly style='border: 0px  solid'> 
		    		</div>
		    		<div class='order_info'><b>Status:</b> <input type='text' id='customerdetails-status' style='border: 0px  solid' readonly> </div>
		       		<div class='order_info'><b>Nearest Town:</b> <input type='text' id='customerdetails-nearestTown' readonly style='width: 350px' class='order_info_input'> </div>
		    		<div class='order_info'><b>Address: </b><input type='text' id='customerdetails-address'  style='width: 350px' class='order_info_input' readonly></div>
		    
		
		    	<div class='order_info' id='customerdetails-viewmore' style='display: none'>
		    		<a id='customerdetails-readmorelink' href='<?php echo yii\helpers\Url::toRoute("client/view?id=") ?>' target="_blank">View More Details</a>
		    	</div>
		    	<hr>
		    	
			</div>  	
			</fieldset>
		</div>
		<div class='customer-orders-form-main'>
   		
		<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); ?>
   
		    
		<?php	
		    //Customer Select options
		    echo Form::widget([
		    	'model'=>$model,
		    	'form'=>$form,
		    	'columns'=>1,
		    	'attributes'=>[
		    		'Customer_id' =>
		    			[
		    				'type' => Form::INPUT_WIDGET,
		    				'widgetClass' => '\kartik\widgets\Select2',
		    				'options'=>
		    					[
		    					'data'=>$clientList,
		    					
		    					'options' => ['placeholder' => 'Select Client....', 'selected' => null,]
		    					],

		    			],			 
		      	]
		    ]);
		    
		    //Display the Customer Information this is view only for reference
		   
			
		    ?>
		  
			
			
		   <?= Form::widget(
				[
				'model'=>$model,
				'form'=>$form,
			
				'columns'=>1,
				'attributes'=>
					[
					'Delivery Info' =>
						[  
						'label' => 'Delivery Info',
						'labelSpan' => 2,
						'columns' => 10,
						'attributes' =>
							[    
							'Requested_Delivery_by'=>
								[
								'type'=>Form::INPUT_WIDGET, 
								'widgetClass' => '\kartik\widgets\DatePicker',
								'options' => 
									[
									'type' => DatePicker::TYPE_COMPONENT_APPEND,
									'options' => 
										[
										'placeholder' => 'Requested Delivery By'
										],
										'pluginOptions' => 
											[
											'format' => "dd-M-yyyy",
											'todayHighlight' => true,
											'autoclose' => true,
											]
									],
								'label' => false,
								'columnOptions'=>['colspan'=>6],
							
								],
							'Storage_Unit' => 
								[
								'type' => FORM::INPUT_WIDGET,
								'widgetClass' => DepDrop::classname(), 
								'options'=>[
									'options' =>
										[
										'placeholder'=>'Select Storage Location',
										],
									'pluginOptions'=>
										[
										'depends'=>[Html::getInputId($model, 'Customer_id')],
										'url'=>yii\helpers\Url::toRoute('/customer-order/ajax-storage-details'),
										'emptyMsg' => 'No Storage Available',
										'initialize'=>false,
										],
									],
								'columnOptions'=>['colspan'=>6],
								]
							]
						]
					]
				]) ?><br>
				
				
				
		
		<div class='customer_order_subheading'>Order Details</div>
		
		
		
			<?= Form::widget(
				[
				'model'=>$model,
				'form'=>$form,
			
				'columns'=>6,
				'attributes' => 
					[
					'Qty_Tonnes' => 
						[
						'type' => FORM::INPUT_TEXT,
						'columnOptions'=>['colspan'=>2],
						],
					'Product_Category' => 
						[
						'type' => FORM::INPUT_DROPDOWN_LIST,
						'items' => Lookup::items("ORDER_CATEGORY"),
						'columnOptions'=>['colspan'=>2],
						],
					'Percent_ingredients' =>
						[
						'type' => FORM::INPUT_HIDDEN,
						'columnOptions'=>['colspan'=>2],
						'label' => false,
						'hidden' => true
						]
					],
					
				]);

		    $gridColumns = 
		    	[
			    	[
			    		'attribute' => 'product.Name',
			    		'pageSummary' => "Total",
			    	],
			    
			    	[
			    		'class' => 'kartik\grid\EditableColumn',
        				'attribute' => 'ingredient_percent',
        				'pageSummary'=>True,
        				'editableOptions'=>
        					[
        					'header' => "%",
        					'inputType' => \kartik\editable\Editable::INPUT_SPIN,
        					'options' =>
        						[
								'pluginOptions'=>['min'=>0, 'max'=>100],
        						],
        					'pluginEvents' =>
	        					[
	        					'editableSuccess'=>"function(event, val, form, data) { $.pjax.reload({container:'#order_ingredient_grid'});  }"
	        					],
        					],
        				
        				
					],
					[
			    		'attribute' => 'product.List_Price_pT_Base',
			    		'hidden' => true,
			    		 'contentOptions' => ['class' => 'pricePerTon'],

			    	
			    		'pageSummary' => True,
			    	],
			    	[
			    	'class' => '\kartik\grid\ActionColumn',
			    	'template' => '{delete}',
					'buttons' =>
						[
						'delete' => function ($url, $model, $key) 
	   						{
           					return Html::a('<span class="glyphicon glyphicon-remove"></span>','#gridTop', 
            					[
                				'class' => 'order_ingredient_delete',
                				'title' => 'Delete',
                				'data-pjax' => '0',
              					]);
							},
						]
			    	
			    	
			    	]
		    	];
		    
		    echo "<A Href='#gridTop' /></A>";
		    echo GridView::widget(
				[
				'id' => 'ingredients',
				'panel'=>[
		        		'type'=>GridView::TYPE_PRIMARY,
		        		'heading'=>"Ingredients order (".$model->id.")",
		   		 ],
				'headerRowOptions'=>['class'=>'kartik-sheet-style'],
				'toolbar'=> 
					[
						['content'=>
							Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'Add Product', 'id' => 'add_ingredient_button', 'class'=>'btn btn-success']) . ' '.
							Html::button('<i class="glyphicon glyphicon-repeat"></i>', ['type'=>'button', 'title'=>'Refresh', 'id' => 'refresh_ingredients_grid', 'class'=>'btn btn-success'])
						],
					],
				'dataProvider'=> new yii\data\ActiveDataProvider(['query' => $model->getIngredients()]),
				//'filterModel'=>$searchModel,
				'columns'=>$gridColumns,
				'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
				'headerRowOptions'=>['class'=>'kartik-sheet-style'],
				'filterRowOptions'=>['class'=>'kartik-sheet-style'],
				'pjax'=>true, 
				'pjaxSettings' =>
					[
					'neverTimeout'=>true,
					'options' =>['id' => 'order_ingredient_grid'],
					
					],
		 		'export' => false,
		 		'showPageSummary' => true,
				]);
	
		    
		    
		    ?>
		    
		  <div class='customer_order_subheading'>Pricing Information</div>	
		
		<?= Form::widget(
				[
				'model'=>$model,
				'form'=>$form,
			
				'columns'=>6,
				'attributes' => 
					[
					'Price_pT' => 
						[
						'type' => FORM::INPUT_TEXT,
						'columnOptions'=>['colspan'=>2],
						'options' => ['readonly' => true],
						],
					'Price_production_pT' => 
						[
						'type' => FORM::INPUT_TEXT,
						'columnOptions'=>['colspan'=>2],
						],
					'Price_transport_pT' =>
						[
						'type' => FORM::INPUT_TEXT,
						'columnOptions'=>['colspan'=>2],
						],
					'Price_Sub_Total' =>
						[
						'type' => FORM::INPUT_TEXT,
						'columnOptions'=>['colspan'=>2],
						'options' => ['readonly' => true],
						]
					],
					
				]); ?>
		
		<div class='customer_order_subheading'>Discounts</div>	
		
			<?= Form::widget(
				[
				'model'=>$model,
				'form'=>$form,
				'columns'=>6,
				'attributes' => 
					[
					'Discount_type' => 
						[
						'type' => FORM::INPUT_DROPDOWN_LIST,
						'items' => Lookup::items("DISCOUNT_TYPE"),
						'columnOptions'=>['colspan'=>2],
						],
					'Discount_pT' =>
						[
						'type' => FORM::INPUT_TEXT,
						'columnOptions'=>['colspan'=>2],
						'options' => ['readonly' => true],
						],
					'Discount_Percent' => 
						[
						'type' => FORM::INPUT_TEXT,
						'columnOptions'=>['colspan'=>2],
						'options' => ['readonly' => true],
						],
					'Discount_notation' =>
						[
						'type' => FORM::INPUT_TEXTAREA,
						'columnOptions'=>['colspan'=>6],
						'options' => ['readonly' => true],
						]
					],
					
				]);	?>		  
		    
		    
		    
    

		
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
	<?php ActiveForm::end(); ?>
	
<?php  


$this->registerJs(
    "$(document).on('click', '#add_ingredient_button', function() 
    	{
    	var percentAllocated = getIngredientSum();
    	productType = $(\"#".Html::getInputId($model, 'Product_Category')."\").val();
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("customer-order/ajax-add-ingredient")."',
		data: {id: 'new', order_id: ".$model->id.", productType: productType, total: percentAllocated},
		success: function (data, textStatus, jqXHR) 
			{
			$('#activity-modal').modal();
			$('.modal-body').html(data);
			},
        error: function (jqXHR, textStatus, errorThrown) 
        	{
            console.log('An error occured!');
            alert('Error in ajax request' );
        	}
		});
	});"
   );


$this->registerJs(
    "$(document).on('click', '#refresh_ingredients_grid', function() 
    	{
    	$.pjax.reload({container:'#order_ingredient_grid'});
		});"
   );	


$this->registerJs("
$('body').on('beforeSubmit', 'form#ingredient_add', function () {
     var form = $(this);
     // return false if form still have some validation errors
     if (form.find('.has-error').length) {
          return false;
     }
     // submit form
     $.ajax({
          url: form.attr('action'),
          type: 'post',
          data: form.serialize(),
          success: function (response) 
          		{
          		$('#activity-modal').modal('hide');
          		var url = '".yii\helpers\Url::toRoute("customer-order/update")."&id=".$model->id."';
          		$.pjax.reload({url: url, container:'#order_ingredient_grid'});
				}
		  });	
     return false;
});
");	
	


	
$this->registerJs(
    "$(document).on('click', '.order_ingredient_delete', function()  
    {
  	$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("customer-orders-ingredients/ajax-delete")."',
		data: {id: $(this).closest('tr').data('key')},
		success: function (data, textStatus, jqXHR) 
			{
			var url = '".yii\helpers\Url::toRoute("customer-order/update")."&id=".$model->id."';
          	$.pjax.reload({url: url, container:'#order_ingredient_grid'});
			},
        error: function (jqXHR, textStatus, errorThrown) 
        	{
            console.log('An error occured!');
            alert('Error in ajax request' );
        	}
		});
   	});"
   );
	
	
$this->registerJs("
	$('#".Html::getInputId($model, 'Discount_type')."').on('change', function()
		{
		if(this.value > 0)
			{
			$('#".Html::getInputId($model, 'Discount_pT')."').prop('readonly', false);
			$('#".Html::getInputId($model, 'Discount_notation')."').prop('readonly', false);
			}
		});

	$('#".Html::getInputId($model, 'Discount_pT')."').on('change', function()
		{
		$('#".Html::getInputId($model, 'Discount_Percent')."').val(
			$('#".Html::getInputId($model, 'Discount_pT')."').val() / $('#".Html::getInputId($model, 'Price_Sub_Total')."').val());
		});
	
	
	
	");
	
	?>
	
	
	
</div>
<div>
	<?php		
		Modal::begin([
		    'id' => 'activity-modal',
		    'header' => '<h4 class="modal-title">Add Product</h4>',
		    'size' => 'modal-lg',
		    'options' =>
		    	[
				'tabindex' => false,
				]

		]);		?>


		<div id="modal_content">dd</div>

	<?php Modal::end(); ?>
	
	</div>