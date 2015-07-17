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


?>

<div class="customer-orders-form">
	<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); ?>
		<div class='customer-orders-form-pricing'>
			blah blah blah
		</div>
		<div class='customer-orders-form-main'>
   		
		    
		    
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
		    <fieldset id="w1_2">
		    <div class='col-md-12'>
		    	<label class="control-label col-md-4"></label>
		    	<div class='col-md-10' >
		    		<div class='col-md-4'><b>Contact:</b> <input type='text' id='customerdetails-contactname'  style='border: 0px  solid; width:170px' readonly></div>
		    		<div class='col-md-4'><b>Phone: </b><input type='text' id='customerdetails-phone' readonly style='border: 0px  solid'> </div>
		    		<div class='col-md-4'><b>Status:</b> <input type='text' id='customerdetails-status' style='border: 0px  solid' readonly> </div>
		    	</div>
		    	<label class="control-label col-md-2"></label>
		    	<div class='col-md-10'>
		    		<div class='col-md-10'><b>Nearest Town:</b> <input type='text' id='customerdetails-nearestTown' readonly style='border: 0px  solid; width: 500px'> </div>
		    	</div>
		    	<label class="control-label col-md-2"></label>
		    	<div class='col-md-10'>
		    		<div class='col-md-10' '><b>Address: </b><input type='text' id='customerdetails-address'  style='border: 0px  solid; width: 500px' readonly></div>
		    	</div>
		    	<label class="control-label col-md-2"></label>
		    	<div class='col-md-10' id='customerdetails-viewmore' style='display: none'>
		    		<div class='col-md-10'><a id='customerdetails-readmorelink' href='<?php echo yii\helpers\Url::toRoute("client/view?id=") ?>' target="_blank">View More Details</a></div>
		    	</div>
		    	<div class='col-md-12' style='height: 20px; width: 100%'></div>
		    	
			</div>  	
			</fieldset>
			
			
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
		<div class='customer_order_subheading'>Order Information</div>
		
		
		
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
						]
					],
					
				]);

		    $gridColumns = 
		    	[
			    	['attribute' => 'product.Name'],
			    
			    	[
			    		'class' => 'kartik\grid\EditableColumn',
        				'attribute' => 'ingredient_percent',
        				'pageSummary'=>'Total',
        				'editableOptions'=>
        					[
        					'header' => "%",
        					'inputType' => \kartik\editable\Editable::INPUT_SPIN,
        					'options' =>
        						[
								'pluginOptions'=>['min'=>0, 'max'=>100],
        						]
        					]
        				
        				
        				
        				
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
		    
		    echo "<A Href='#gridTop' />";
		    echo GridView::widget(
				[
				'id' => 'ingredients1234',
				'panel'=>[
		        		'type'=>GridView::TYPE_PRIMARY,
		        		'heading'=>"Ingredients order (".$model->id.")",
		   		 ],
				'headerRowOptions'=>['class'=>'kartik-sheet-style'],
				'toolbar'=> 
					[
						['content'=>
							Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'Add Product', 'id' => 'add_ingredient_button', 'class'=>'btn btn-success']) . ' '.
							Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['grid-demo'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'Reset Grid'])
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
				]);
	
		    
		    
		    ?>
		    
		    
		    
		    
		    
    

		
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
	<?php ActiveForm::end(); ?>
	
<?php  


$this->registerJs(
    "$(document).on('click', '#add_ingredient_button', function() 
    	{
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("customer-order/ajax-add-ingredient")."',
		data: {id: 'new', order_id: ".$model->id."},
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
          		//alert(form.attr('action'));
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