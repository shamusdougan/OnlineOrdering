<?php
use kartik\grid\GridView;
use yii\helpers\Html;


//This handles the clicking of the refresh button on the grid
$this->registerJs(
    "$(document).on('click', \"#refresh_ingredient_grid\", function() 
    	{
    	$.pjax.reload({container:\"#product_ingredient_grid\"});
		});"
   );	
   
   
$this->registerJs("
$(document).on('pjax:end', function() {
   getIngredientSum();
    });

$( document ).ready(function() {
	getIngredientSum();
	
});

");


$this->registerJs("
function getIngredientSum()
{
	

	var sum = 0
	$('.ingredient_percent').each(function() 
 		{
		if(!isNaN($(this).text()) && $(this).text().length!=0) 
			{
           	sum += parseFloat($(this).text());
       		}
		});
	$('#ingredient_sum').val(sum);
	$('tfoot td:eq(1)').text(sum);
	
	
	return sum;
}

");


//Action on adding an ingredient
$this->registerJs(
    "$(document).on('click', '#add_ingredient_button', function() 
    	{
    	
    	
		var product_id =  ($(this).attr('product_id'));
		var ingredient_sum = parseFloat($('#ingredient_sum').val());
		
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("product/ajax-add-ingredient")."',
		data: {product_id: product_id, ingredient_sum: ingredient_sum},
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

//action on submiting the ingredient add form
$this->registerJs("
$('body').on('beforeSubmit', 'form#add-ingredient-form', function () {
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
          		
          		$.pjax.reload({container:'#product_ingredient_grid'});
				}
		  });	
     return false;
});
");	


$this->registerJs(
    "$(document).on('click', '.ingredient_update', function() 
    	{
    	var price_id = $(this).closest('tr').data('key');
		var ingredient_sum = parseFloat($('#ingredient_sum').val());
		
		
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("product/ajax-update-ingredient")."',
		data: {id: price_id, ingredient_sum: ingredient_sum},
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
    "$(document).on('click', '.ingredient_delete', function() 
    	{
    	var ingredient_id = $(this).closest('tr').data('key');
		
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("product/ajax-delete-ingredient")."',
		data: {id: ingredient_id},
		success: function (data, textStatus, jqXHR) 
			{
			$.pjax.reload({container:'#product_ingredient_grid'});
			},
        error: function (jqXHR, textStatus, errorThrown) 
        	{
            console.log('An error occured!');
            alert('Error in ajax request' );
        	}
		});
   	});"
		

   );




$gridColumns = 	[
			    	[
			    	'attribute' => 'ingredient.Name',
			    	'pageSummary'=>'Total',
			    	],
			    
			    	[
					'attribute' => 'ingredient_percent',
					'label' => '%',
					'contentOptions' => ['class' => 'ingredient_percent sap_edit_ingredient_link', ],
					'hAlign'=>'right',
					'pageSummary'=>true,
					
					/*
					'format'=>'raw',
					'value'=>function ($model) use ($readOnly) {
        					if($readOnly)
        						{
								return  "<span class='ingredient_percent'>".$model->ingredient_percent."</span>";
								}
							else{
								return "<a class='sap_edit_ingredient_link' ingredientId='".$model->id."'><span class='ingredient_percent'>" . $model->ingredient_percent . '</span></a>';	
								}
        					
    						},*/
					],
					[
			    	'class' => '\kartik\grid\ActionColumn',
			    	'template' => '{update} {delete}',
			    	'hidden' => $readOnly,
					'buttons' =>
						[
						'delete' => function ($url, $model, $key) 
	   						{
           					return Html::a('<span class="glyphicon glyphicon-remove"></span>','#gridTop', 
            					[
                				'class' => 'ingredient_delete',
                				'confirm' => 'Delete Price Entry',
                				'title' => 'Delete',
                				'data-pjax' => '0',
              					]);
							},
						'update' => function ($url, $model, $key) 
	   						{
           					return Html::a('<span class="glyphicon glyphicon-pencil"></span>','#gridTop', 
            					[
                				'class' => 'ingredient_update',
                				'title' => 'Update',
                				'data-pjax' => '0',
              					]);
							},
						]
			    	
			    	
			    	]
				];


$dataProvider = new yii\data\ActiveDataProvider(['query' => $product->getIngredients()]);
$dataProvider->setSort(['defaultOrder' => ['ingredient_percent'=>SORT_DESC]]);





echo "<input type='hidden' id='ingredient_sum'>";
echo GridView::widget(
				[
				'id' => 'ingredients',
				'panel'=>[
		        		'type'=>GridView::TYPE_PRIMARY,
		        		'heading'=>$product->Name." Ingredient List",
		   		 ],
				'headerRowOptions'=>['class'=>'kartik-sheet-style'],
				'toolbar'=> 
					[
						['content'=>
							($readOnly ? ' ' : Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'Add Product', 'id' => 'add_ingredient_button', 'class'=>'btn btn-success', 'product_id' => $product->id])). ' '.
							Html::button('<i class="glyphicon glyphicon-repeat"></i>', ['type'=>'button', 'title'=>'Refresh', 'id' => 'refresh_ingredient_grid', 'class'=>'btn btn-success', ])
						],
					],
				'dataProvider'=> $dataProvider,
				//'filterModel'=>$searchModel,
				'columns'=>$gridColumns,
				'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
				'headerRowOptions'=>['class'=>'kartik-sheet-style'],
				'filterRowOptions'=>['class'=>'kartik-sheet-style'],
				'pjax'=>true, 
				'pjaxSettings' =>
					[
					'neverTimeout'=>true,
					'options' =>['id' => 'product_ingredient_grid'],
					
					],
		 		'export' => false,
		 		'showPageSummary' => true,
				]);
	


?>