<?php
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

	
	
	
$this->registerJs(
	"$(document).on('click', '#add_contact_button', function()
		{
			
		client_id = $(this).attr('client_id');
		
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("contacts/ajax-create")."',
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
    "$(document).on('click', \"#refresh_contacts_grid\", function() 
    	{
    	$.pjax.reload({container:\"#client-contact-grid\"});
		});"
   );	
 
 
  $this->registerJs(
    "$(document).on('click', '.contact-update-link', function() 
    	{
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("contacts/ajax-update")."',
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
    "$(document).on('click', '.contact-delete-link', function() 
    	{
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("contacts/ajax-delete")."',
		data: {id: $(this).closest('tr').data('key')},
		success: function (data, textStatus, jqXHR) 
			{
			$.pjax.reload({container:\"#client-contact-grid\"});
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
$('body').on('beforeSubmit', 'form#contact-form', function () {
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
				$.pjax.reload({container:'#123client-contact-grid'});
				$('#activity-modal').modal('hide');
				//alert('blah');
				
          }
     });
     return false;
});
"
);




$gridColumns = [
	[ 'attribute' => 'fullname'],
	['attribute' => 'Mobile_Phone'],
	
	['attribute' => 'Business_Phone'],
	
	['attribute' => 'Email'],
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
                    'class' => 'contact-delete-link',
                    'title' => 'Delete',
					]);
				},
			'update' => function ($url, $model, $key) 
	   			{
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>','#', 
                	[
                    'class' => 'contact-update-link',
                    'title' => 'Update',
					]);
				},
			],
	    'headerOptions'=>['class'=>'kartik-sheet-style'],
	],
	
	];		
	
echo Form::widget(
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
		
		
 
echo GridView::widget(
		[
		'id' => 'client_contact-grid',
		'panel'=>[
        		'type'=>GridView::TYPE_PRIMARY,
        		'heading'=>"Company Contacts",
   		 ],
		'headerRowOptions'=>['class'=>'kartik-sheet-style'],
		'toolbar'=> 
			[
				['content'=>
					Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'Add Contact', 'class'=>'btn btn-success', 'client_id' => $model->id, 'id' => 'add_contact_button' ]) . ' '.
					Html::button('<i class="glyphicon glyphicon-repeat"></i>', ['type'=>'button', 'title'=>'Refresh', 'id' => 'refresh_contacts_grid', 'class'=>'btn btn-success'])
				],
			],
		'dataProvider'=> new yii\data\ActiveDataProvider(['query' => $model->getContacts()]),
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