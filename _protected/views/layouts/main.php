<?php
use app\assets\AppAsset;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use kartik\widgets\SideNav;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    
    <div class='sapient_wrap'>
   	
    
    
    	<div class='sapient_leftMenu'>
    		<?php 
    		
    		$currentItem = false;
    		if(isset($this->params['menuItem']))
    			{
				$currentItem = $this->params['menuItem'];
				}
    		
   
    		
    		
    		$username = Yii::$app->user->identity->username;
    		echo SideNav::widget([
				'type' => SideNav::TYPE_DEFAULT,
				'heading' => "Menu (".$username.")",
				'items' => [
					['label' => 'Dashboard', 'icon' => 'home', 'url' => Url::toRoute('/')],					
					['label' => 'Customers', 'icon' => 'user', 'url' => Url::toRoute('/clients'), 'active'=>($currentItem == 'client')],
					['label' => 'Sales', 'icon' => 'user', 'items' => 
						[
						['label' => 'Orders', 'icon' => 'file', 'url' => Url::toRoute('/customer-order'), 'active'=>($currentItem == 'customer-order-sales')],
						
						]],
					['label' => 'Production', 'icon' => 'user', 'items' => 
						[
						['label' => 'Orders', 'icon' => 'file', 'url' => Url::toRoute('/customer-order/production-list'), 'active'=>($currentItem == 'customer-order-production')],
						
						]],	
				
					['label' => 'Settings', 'icon' => 'cog', 'visible' => Yii::$app->user->can("useSettings"), 'items' => [
						['label' => 'Storage',  'url' => Url::toRoute('/storage'), 'active'=>($currentItem == 'storage')],
						['label' => 'Contacts', 'url' => Url::toRoute('/contacts'), 'active'=>($currentItem == 'contacts')],
						['label' => 'User Accounts', 'url' => Url::toRoute('/user'), 'active'=>($currentItem == 'userItem')], 
						['label' => 'Lookups', 'url' => Url::toRoute('/lookup'), 'active'=>($currentItem == 'lookupItem')], 
						['label' => 'Products', 'url' => Url::toRoute('/product'), 'active'=>($currentItem == 'product')],
						['label' => 'Order Ingredients', 'url' => Url::toRoute('/customer-orders-ingredients'), 'active'=>($currentItem == 'customer-order-ingredients')],
						['label' => 'Import Data (remove Later)', 'url' => Url::toRoute('/import-functions'), 'active'=>($currentItem == 'import')],
						['label' => 'gii (remove later)', 'url' => Url::toRoute('/gii')]
					
					]],
					['label' => 'Logout', 'icon' => 'off', 'url' => Url::toRoute('site/logout')]
				
				]
				]);        
				?>
    	</div>
		<div class='sapient_content'>
    		 <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        
      
        
        
        
        <?= $content ?>
        
        
        
        
        
    	</div>
    	
    </div>
    
       


    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; <?= Yii::t('app', Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
