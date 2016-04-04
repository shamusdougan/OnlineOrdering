<?php
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Url;


	
	
	
$this->registerJs(
	"$(document).on('click', '#add_bin_button', function()
		{
			
		trailer_id = $(this).attr('trailer_id');
		
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("trailers/ajax-add-bin")."',
		data: {trailer_id: trailer_id},
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
$('body').on('beforeSubmit', 'form#create_contact_form', function () {
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
          		$.pjax.reload({container:'#client-contact-grid'});
				}
		  });	
     return false;
	});
	");

 
 $this->registerJs(
    "$(document).on('click', \"#refresh_bin_grid\", function() 
    	{
    	$.pjax.reload({container:\"#bin-grid\"});
		});"
   );	
 
 
  $this->registerJs(
    "$(document).on('click', '.bin-update-link', function() 
    	{
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("ajax-update-bin")."',
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
    "$(document).on('click', '.bin-delete-link', function() 
    	{
    	
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("trailers/ajax-delete-bin")."',
		data: {id: $(this).closest('tr').data('key')},
		success: function (data, textStatus, jqXHR) 
			{
			$.pjax.reload({container:\"#bin-grid\"});
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

 
$this->registerJs("
$('body').on('beforeSubmit', 'form#add_bin_form', function () {
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
          success: function (response) {
          		location.reload();
				$.pjax.reload({container:'#bin-grid'});
				$('#activity-modal').modal('hide');
				//alert('blah');
				
          }
     });
     return false;
});
"
);




$gridColumns = [
	['attribute' => 'BinNo'],
	['attribute' => 'MaxCapacity'],
	
	
	[
	    'class'=>'kartik\grid\ActionColumn',
		'template' => '{update} {delete}',
		'contentOptions' => ['class' => 'padding-left-5px'],

	   	'buttons' => 
	   		[
	   		'delete' => function ($url, $model, $key) 
	   			{
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', 
                	[
                    'class' => 'bin-delete-link',
                    'title' => 'Delete',
					]);
				},
			'update' => function ($url, $model, $key) 
	   			{
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>','#', 
                	[
                    'class' => 'bin-update-link',
                    'title' => 'Update',
					]);
				},
			],
	    'headerOptions'=>['class'=>'kartik-sheet-style'],
	],
	
	];		
	

		
		
 
echo GridView::widget(
		[
		'id' => 'bin-grid',
		'panel'=>[
        		'type'=>GridView::TYPE_PRIMARY,
        		'heading'=>"Trailer Bins",
   		 ],
		'headerRowOptions'=>['class'=>'kartik-sheet-style'],
		'toolbar'=> 
			[
				['content'=>
					Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'Add Bin', 'class'=>'btn btn-success', 'trailer_id' => $model->id, 'id' => 'add_bin_button' ]) . ' '.
					Html::button('<i class="glyphicon glyphicon-repeat"></i>', ['type'=>'button', 'title'=>'Refresh', 'id' => 'refresh_bin_grid', 'class'=>'btn btn-success'])
				],
			],
		'dataProvider'=> new yii\data\ActiveDataProvider(['query' => $model->getTrailerBins()]),
		//'filterModel'=>$searchModel,
		'columns'=>$gridColumns,
		'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
		'headerRowOptions'=>['class'=>'kartik-sheet-style'],
		'filterRowOptions'=>['class'=>'kartik-sheet-style'],
		'pjax'=>true, 
		'pjaxSettings' =>
			[
			'neverTimeout'=>true,
			'options' =>['id' => 'client-contact-grid'],
			
			],
 		'export' => false,
		]);
	

	
		


?>