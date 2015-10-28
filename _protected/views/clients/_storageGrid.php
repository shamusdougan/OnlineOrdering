<?php
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;


$gridName = 	
	
$this->registerJs(
	"$(document).on('click', '#add_storage_button', function()
		{
			
		client_id = $(this).attr('client_id');
		
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("storage/ajax-create")."',
		data: {client_id: client_id},
		success: function (data, textStatus, jqXHR) 
			{
			$('.modal-body').removeData('bs.modal').find('.modal-content').empty();
			$('#activity-modal').modal();
			$('.modal-body').html(data);
           
			},
        error: function (jqXHR, textStatus, errorThrown) 
        	{
            console.log('An error occured!');
            alert('Error in ajax request' );
        	}
		});
   	});
");


$this->registerJs("
$('body').on('beforeSubmit', 'form#storage_form', function () {
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
          		$.pjax.reload({container:'#client_storage_grid'});
				}
		  });	
     return false;
	});
	");


 
 $this->registerJs(
    "$(document).on('click', \"#refresh_storage_grid\", function() 
    	{
    	$.pjax.reload({container:\"#client_storage_grid\"});
		});"
   );	
 
 
  $this->registerJs(
    "$(document).on('click', '.storage-update-link', function() 
    	{
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("storage/ajax-update")."',
		data: {id: $(this).closest('tr').data('key')},
		success: function (data, textStatus, jqXHR) 
			{
			$('.modal-body').removeData('bs.modal').find('.modal-content').empty();
			
			$('.modal-body').html(data);
         	$('#activity-modal').modal();

			},
        error: function (jqXHR, textStatus, errorThrown) 
        	{
            console.log('An error occured!');
            alert('Error in ajax request' );
        	}
		});
		});
	"
   );
 
 $this->registerJs(
    "$(document).on('click', '.storage-delete-link', function() 
    	{
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("storage/ajax-delete")."',
		data: {id: $(this).closest('tr').data('key')},
		success: function (data, textStatus, jqXHR) 
			{
			$.pjax.reload({container:\"#client_storage_grid\"});
			},
        error: function (jqXHR, textStatus, errorThrown) 
        	{
            console.log('An error occured!');
            alert('Error in ajax request' );
        	}
		});
		});
	"
   );

 




		

$gridColumns = [
	['class' => 'yii\grid\SerialColumn'],
	'Description',
	'Capacity',
	'Auger:boolean',
	'Blower:boolean',
	// 'Delivery_Instructions',
	// 'Postcode',
	// 'Status',
	// 'Street_1',
	// 'SuburbTown',
	'Tipper:boolean',

	[
	    'class'=>'kartik\grid\ActionColumn',
		'template' => '{update} {delete}',
		'contentOptions' => ['class' => 'padding-left-5px'],

	   	'buttons' => 
	   		[
	   		'delete' => function ($url, $model, $key) 
	   			{
                return Html::a('<span class="glyphicon glyphicon-trash"></span>','#', 
                	[
                    'class' => 'storage-delete-link',
                    'title' => 'Delete',
					]);
				},
			'update' => function ($url, $model, $key) 
	   			{
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>','#', 
                	[
                    'class' => 'storage-update-link',
                    'title' => 'Update',
					]);
				},
			],
	    'headerOptions'=>['class'=>'kartik-sheet-style'],
	],
];
		

echo GridView::widget(
		[
		'id' => 'client_storage_grid_control',
		'panel'=>[
        		'type'=>GridView::TYPE_PRIMARY,
        		'heading'=>"Storage",
   		 ],
		'headerRowOptions'=>['class'=>'kartik-sheet-style'],
		'toolbar'=> 
			[
				['content'=>
					Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'Add Storage', 'class'=>'btn btn-success', 'client_id' => $model->id, 'id' => 'add_storage_button' ]) . ' '.
					Html::button('<i class="glyphicon glyphicon-repeat"></i>', ['type'=>'button', 'title'=>'Refresh', 'id' => 'refresh_storage_grid', 'class'=>'btn btn-success'])
				],
			],
		'dataProvider'=> new yii\data\ActiveDataProvider(['query' => $model->getStorage()]),
		//'filterModel'=>$searchModel,
		'columns'=>$gridColumns,
		'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
		'headerRowOptions'=>['class'=>'kartik-sheet-style'],
		'filterRowOptions'=>['class'=>'kartik-sheet-style'],
		'pjax'=>true, 
		'pjaxSettings' =>
			[
			'neverTimeout'=>true,
			'options' =>['id' => 'client_storage_grid'],
			
			],
 		'export' => false,
		]);
	
			

?>