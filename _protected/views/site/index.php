<?php

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
				This will hold a list of orders that are active and waiting to be submitted or actioned by each user
                

                <p><a class="btn btn-default" href="/customer-order/">Customer Orders</a></p>
            </div>
            <div class="col-lg-3">
                <h3>Deliveries Due Today</h3>

                <p>This will hold a list of deliveies that are been delivered today.</p>

                <p><a class="btn btn-default" href="/delivery">Deliveries</a></p>
            </div>
             <div class="col-lg-3">
                <h3>Recent Customers</h3>

                <p>This will hold a list of recently used customers</p>

                <p><a class="btn btn-default" href="/clients">Recent Customers</a></p>
            </div>
            <div class="col-lg-3">
                <h3>Recent Orders</h3>

                <p>This will hold a list of orders the have been recently entered into the system. </p>

                <p><a class="btn btn-default" href="/customer-order/">Recent Orders</a></p>
            </div>
           
        </div>

    </div>
</div>

