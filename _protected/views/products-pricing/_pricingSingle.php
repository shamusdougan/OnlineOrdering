<?php
use kartik\grid\GridView;
use yii\helpers\Html;


//This handles the clicking of the refresh button on the grid
$this->registerJs(
    "$(document).on('click', \"#refresh_price_grid\", function() 
    	{
    	$.pjax.reload({container:\"#product_pricing_grid\"});
		});"
   );	



//Action on adding an ingredient
$this->registerJs(
    "$(document).on('click', '#add_price_button', function() 
    	{
    	
    	var allowAdd = ".($product->id != null ? 'true' : '\'\'').";
    	if(!allowAdd)
    		{
			alert('Please save the Product to the database first');
			return;
			}
			
		var product_id =  ($(this).attr('product_id'));
		
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("product/ajax-add-price")."',
		data: {product_id: product_id},
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
$('body').on('beforeSubmit', 'form#add-price-form', function () {
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
          		
          		$.pjax.reload({container:'#product_pricing_grid'});
				}
		  });	
     return false;
});
");	


$this->registerJs(
    "$(document).on('click', '.price_update', function() 
    	{
    	var price_id = $(this).closest('tr').data('key');
		
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("product/ajax-update-price")."',
		data: {id: price_id},
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
    "$(document).on('click', '.price_delete', function() 
    	{
    	var price_id = $(this).closest('tr').data('key');
		
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("product/ajax-delete-price")."',
		data: {id: price_id},
		success: function (data, textStatus, jqXHR) 
			{
			$.pjax.reload({container:'#product_pricing_grid'});
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
			    	'attribute' => 'date_valid_from',
			    	'label' => 'Date Price is valid From',
			    	'value' => function ($data)
			    		{
						return date("d M y", strtotime($data->date_valid_from));
						}
			    	],
			    
			    	[
					'attribute' => 'price_pt',
					'label' => 'Price per Ton',
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
                				'class' => 'price_delete',
                				'confirm' => 'Delete Price Entry',
                				'title' => 'Delete',
                				'data-pjax' => '0',
              					]);
							},
						'update' => function ($url, $model, $key) 
	   						{
           					return Html::a('<span class="glyphicon glyphicon-pencil"></span>','#gridTop', 
            					[
                				'class' => 'price_update',
                				'title' => 'Update',
                				'data-pjax' => '0',
              					]);
							},
						]
			    	
			    	
			    	]
				];


$dataProvider = new yii\data\ActiveDataProvider(['query' => $product->getPricings()]);
$dataProvider->setSort(['defaultOrder' => ['date_valid_from'=>SORT_DESC]]);
echo GridView::widget(
				[
				'id' => 'pricings',
				'panel'=>[
		        		'type'=>GridView::TYPE_PRIMARY,
		        		'heading'=>$product->Name." Price List",
		   		 ],
				'headerRowOptions'=>['class'=>'kartik-sheet-style'],
				'toolbar'=> 
					[
						['content'=>
							($readOnly ? ' ' : Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'Add Product', 'id' => 'add_price_button', 'class'=>'btn btn-success', 'product_id' => $product->id])). ' '.
							Html::button('<i class="glyphicon glyphicon-repeat"></i>', ['type'=>'button', 'title'=>'Refresh', 'id' => 'refresh_price_grid', 'class'=>'btn btn-success', ])
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
					'options' =>['id' => 'product_pricing_grid'],
					
					],
		 		'export' => false,
		 		'showPageSummary' => true,
				]);
	


?>