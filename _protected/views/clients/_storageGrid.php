<?php
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

$gridColumns = [
	[ 'attribute' => 'fullname'],
	['attribute' => 'Mobile_Phone'],
	
	['attribute' => 'Business_Phone'],
	
	['attribute' => 'Email'],
	[
	    'class'=>'kartik\grid\ActionColumn',
		'template' => '{view} {update} {delete}',
		'contentOptions' => ['class' => 'padding-left-5px'],

	   	'buttons' => 
	   		[
	   		'view' => function ($url, $model, $key) 
	   			{
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>','#', 
                	[
                    'class' => 'activity-view-link',
                    'title' => 'View',
                    'data-toggle' => 'modal',
                    'data-target' => '#activity-modal',
                   // 'data-id' => $key,
                   // 'data-pjax' => '0',
					]);
				},
			'update' => function ($url, $model, $key) 
	   			{
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>','#', 
                	[
                    'class' => 'activity-update-link',
                    'title' => 'Update',
                  	'data-toggle' => 'modal',
                  	'data-target' => '#activity-modal',
                  //  'data-id' => $key,
                  //  'data-pjax' => '0',
					]);
				},
			],
	    'headerOptions'=>['class'=>'kartik-sheet-style'],
	],
	
	];
	
	

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

	[ 'class'=>'kartik\grid\ActionColumn'],
];
		
$this->registerJs(
    "$(document).on('click', '.activity-view-link', function()  
    {
  	$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("contacts/modal")."',
		data: {id: $(this).closest('tr').data('key'), mode: 'view'},
		success: function (data, textStatus, jqXHR) 
			{
			$('.modal-body').removeData('bs.modal').find('.modal-content').empty();
			//$('#activity-modal').modal();
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
    "$(document).on('click', '.activity-update-link', function() 
    	{
		$.ajax
  		({
  		url: '".yii\helpers\Url::toRoute("contacts/modal")."',
		data: {id: $(this).closest('tr').data('key')},
		success: function (data, textStatus, jqXHR) 
			{
			$('.modal-body').removeData('bs.modal').find('.modal-content').empty();
			//$('#activity-modal').modal();
			$('.modal-body').html(data);
          

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
 
/*	
$this->registerJs(
      "$('.activity-update-link').click(function() 
    {
 	 $('#activity-modal').modal('show').find('#modal_content').load('".yii\helpers\Url::toRoute(["contacts/modal", 'id' => '1' ])."');


 	alert('clicly clicky');
 	
   	});"
   );
  */ 
   
 
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





/*
$this->registerJs("

$('body').on('hidden.bs.modal', '.modal', function () {
  	$(this).removeData('bs.modal');
});


");
*/
		

		
//Pjax::begin(['id' => '123client-contact-grid']); 
echo GridView::widget(
		[
		'id' => 'client_contact-grid',
		'panel'=>[
        		'type'=>GridView::TYPE_PRIMARY,
        		'heading'=>"Storage",
   		 ],
		'headerRowOptions'=>['class'=>'kartik-sheet-style'],
//		'toolbar'=> 
//			[
//				['content'=>
//					Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>'Add Contact', 'class'=>'btn btn-success', 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
//					Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['grid-demo'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'Reset Grid'])
//				],
//			],
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
			'options' =>['id' => '123client-contact-grid'],
			
			],
 		'export' => false,
		]);
	

	
		
//Pjax::end(); 	

?>