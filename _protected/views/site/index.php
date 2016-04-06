<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = Yii::t('app', Yii::$app->name);
?>
<div class="site-index">

    <div class="sapient_home_title_wrapper">
    	<div class='sapient_home_title'>
    	
    	</div>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-3">
                <h3>Orders Waiting to be Submitted</h3>
			<?= GridView::widget([
			        'dataProvider' => $orderDataProvider,
			        'filterModel' => null,
			        'export'=>false,
			    	'panel'=>[
			        	'type'=>GridView::TYPE_PRIMARY,
			        	'heading'=>"Orders",
			    		],
			        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
			        'toolbar' => false,
			   
					'columns' => 
						[
						  	[
				    		'attribute' => 'Order_ID',
				    		'width' => '20%',
				    		'format' => 'raw',
				    		'filter' => false,
				    		'value' => function ($data)
				    			{
								return html::a($data->Order_ID, "/customer-order/update?id=".$data->id);
								},
				    		],
							[
							'attribute' => 'Created_On',
							'width' => '20%',
							'label' => 'Created',
							'value' => function ($data)
							  			{
											return date("d-M-Y", strtotime($data->Created_On));
											},
							'filter'=> False,
							],
				          
				            [
				            'attribute' => 'client.Company_Name',
				            'width' => '50%',
				            'label' => "Customer",
				            'filter'=>false,
				            ],
		           
				            [
				            'attribute' => 'Qty_Tonnes',
				            'label' => 'Qty',
				            'hAlign'=>'right', 
				            'width' => '10px',
				            'filter' => false,
							],
						],
			
       
   				 ]); ?>
                

                <p><a class="btn btn-default" href="<?= Url::toRoute(['/customer-order/index', 'CustomerOrdersSearch[Created_By]' => $user->id]) ?>">Customer Orders</a></p>
            </div>
            <div class="col-lg-3">
                <h3>Deliveries Due Today</h3>

           <?= GridView::widget([
			        'dataProvider' => $deliveryDataProvider,
			        'filterModel' => null,
			        'export'=>false,
			    	'panel'=>[
			        	'type'=>GridView::TYPE_PRIMARY,
			        	'heading'=>"Deliveries",
			    		],
			        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
			        'toolbar' => false,
			   
					'columns' => 
						[
						  	[
				    		'attribute' => 'Name',
				    		'width' => '20%',
				    						    
							],
				 
				            [
				    		'attribute' => 'customerOrder.Order_ID',
				    		'width' => '50%',
				    		'format' => 'raw',
				    		'filter' => false,
				    		'value' => function ($data)
				    			{
								return html::a($data->customerOrder->Order_ID, "/customer-order/update?id=".$data->customerOrder->id);
								},
				    		],
		           
				           
						],
			
       
   				 ]); ?>
                

                <p><a class="btn btn-default" href="/delivery">Deliveries</a></p>
            </div>
           
            <div class="col-lg-3">
                <h3>20 Most Recent Orders</h3>

               	<?= GridView::widget([
			        'dataProvider' => $recentOrdersDataProvider,
			        'filterModel' => null,
			        'export'=>false,
			    	'panel'=>[
			        	'type'=>GridView::TYPE_PRIMARY,
			        	'heading'=>"Orders",
			    		],
			        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
			        'toolbar' => false,
			   
					'columns' => 
						[
						  	[
				    		'attribute' => 'Order_ID',
				    		'width' => '20%',
				    		'format' => 'raw',
				    		'filter' => false,
				    		'value' => function ($data)
				    			{
								return html::a($data->Order_ID, "/customer-order/update?id=".$data->id);
								},
				    		],
							[
							'attribute' => 'Created_On',
							'width' => '20%',
							'label' => 'Created',
							'value' => function ($data)
							  			{
											return date("d-M-Y", strtotime($data->Created_On));
											},
							'filter'=> False,
							],
				          
				            [
				            'attribute' => 'client.Company_Name',
				            'width' => '50%',
				            'label' => "Customer",
				            'filter'=>false,
				            ],
		           
				            [
				            'attribute' => 'Qty_Tonnes',
				            'label' => 'Qty',
				            'hAlign'=>'right', 
				            'width' => '10px',
				            'filter' => false,
							],
						],
			
       
   				 ]); ?>

                <p><a class="btn btn-default" href="<?= Url::toRoute(['/customer-order/index', 'CustomerOrdersSearch[Created_By]' => $user->id]) ?>">Customer Orders</a></p>
            </div>
           
        </div>

    </div>
</div>

