<?php
use app\assets\AppAsset;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use kartik\widgets\SideNav;
use yii\widgets\Breadcrumbs;
use app\models\CustomerOrders;
use app\components\sideNavActive;
use webvimark\modules\UserManagement\models\User;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$user = User::getCurrentUser();


$items = [
			['label' => 'Dashboard', 'icon' => 'home', 'url' => Url::toRoute('/'), 'active' => sideNavActive::widget(['controller' => "site"])],					
			['label' => 'Customers', 'icon' => 'user', 'url' => Url::toRoute('/clients'), 'active'=>sideNavActive::widget(['controller' => "clients", "actions" => ["create", "update", "index"]])],
		];
		
if(User::hasRole('sales'))
	{
	$items[] = ['label' => 'Sales', 'icon' => 'shopping-cart', 'items' => 
					[
					['label' => 'Customer Orders', 'icon' => 'file', 'url' => Url::toRoute(['/customer-order/index', 'CustomerOrdersSearch[Created_By]' => $user->id]), 'active'=>sideNavActive::widget(['controller' => "customer-order", 'actions' => ['index', 'create', 'update']])],
					['label' => 'Anticipated Sales', 'icon' => 'usd', 'url' => Url::toRoute(['clients/anticipated-sales',]), 'active'=>sideNavActive::widget(['controller' => "clients", 'actions' => ['anticipated-sales']])],
					]
				];
	}
if(User::hasRole('production'))
	{
	$items[] = ['label' => 'Production', 'icon' => 'star', 'items' => 
		[
			['label' => 'Active Orders', 'icon' => 'file', 'url' => Url::toRoute('/customer-order/production-active-list'), 'active'=>sideNavActive::widget(['controller' => "customer-order", 'actions' => ['production-active-list', 'update-production-active']])],
			['label' => 'Submitted Orders', 'icon' => 'file', 'url' => Url::toRoute('/customer-order/production-submitted-list'), 'active'=>sideNavActive::widget(['controller' => "customer-order", 'actions' => ['production-submitted-list']])],
			['label' => 'Deliveries', 'icon' => 'road', 'url' => Url::toRoute('/delivery'), 'active'=>sideNavActive::widget(['controller' => "delivery", ])],
			['label' => 'Returns', 'icon' => 'road', 'url' => Url::toRoute(['/returns']), 'active'=>sideNavActive::widget(['controller' => "returns"])],
			['label' => 'Weighbridge', 'icon' => 'tags', 'url' => Url::toRoute('/weighbridge-ticket'), 'active'=>sideNavActive::widget(['controller' => "weighbridge-ticket", ])],
			['label' => 'Products', 'icon' => 'tags', 'url' => Url::toRoute(['/product', "ProductSearch[Status]"=>1]), 'active'=>sideNavActive::widget(['controller' => "product", 'actions' => ['index', 'create', 'update'] ])],
			
		
		
		]];
	}
if(User::hasRole('accounts'))
	{
	$items[] = ['label' => 'Accounts', 'icon' => 'usd', 'items' => 
		[
			['label' => 'Price Lists', 'icon' => 'file', 'url' => Url::toRoute('/product/update-pricing'), 'active'=>sideNavActive::widget(['controller' => "product", 'actions' => ['update-pricing'] ])],
			['label' => 'Daily Sales Figures', 'icon' => 'usd', 'url' => Url::toRoute('/clients/daily-sales-figures'), 'active'=>sideNavActive::widget(['controller' => "clients", 'actions' => ['daily-sales-figures'] ])],
		
		
		]];
	}
if(User::hasRole('Admin'))
	{
	$items[] = ['label' => 'Admin', 'icon' => 'list-alt', 'items' => 
		[
		['label' => 'Trucks', 'icon' => 'th-list', 'url' => Url::toRoute('/trucks'), 'active'=>sideNavActive::widget(['controller' => "trucks", ])],
		['label' => 'Trailers', 'icon' => 'inbox', 'url' => Url::toRoute('/trailers'), 'active'=>sideNavActive::widget(['controller' => "trailers", ])],
		['label' => 'Product Bins', 'icon' => 'inbox', 'url' => Url::toRoute('/products-bins'), 'active'=>sideNavActive::widget(['controller' => "products-bins", ])],
		['label' => 'Customer Storage',  'url' => Url::toRoute('/storage'), 'active'=>sideNavActive::widget(['controller' => "storage", ])],
		['label' => 'Customer Contacts', 'url' => Url::toRoute('/contacts'), 'active'=>sideNavActive::widget(['controller' => "contacts", ])],
		['label' => 'User Accounts', 'url' => Url::toRoute('/user-management/user'), 'active'=> sideNavActive::widget(['controller' => ["user", "user-permission"]])], 
		
		]];
	$items[] = ['label' => 'Settings', 'icon' => 'cog', 'items' => [
		
		
		['label' => 'Lookups', 'url' => Url::toRoute('/lookup'), 'active'=>sideNavActive::widget(['controller' => "lookup", ])], 
		['label' => 'Import Data (remove Later)', 'url' => Url::toRoute('/import-functions'), 'active'=>sideNavActive::widget(['controller' => "import-functions", ])],
		['label' => 'gii (remove later)', 'url' => Url::toRoute('/gii')],
		['label' => 'User Permissions', 'url' => Url::toRoute('/user-management/permission'), 'active'=> sideNavActive::widget(['controller' => "permission"])], 
		['label' => 'User Roles', 'url' => Url::toRoute('/user-management/role'), 'active'=> sideNavActive::widget(['controller' => "role"])], 
		['label' => 'User Groups', 'url' => Url::toRoute('/user-management/auth-item-group'), 'active'=> sideNavActive::widget(['controller' => "auth-item-group"])], 
		

		]];
	}

$items[] = ['label' => 'Logout', 'icon' => 'off', 'url' => Url::toRoute('site/logout')];




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
    		
   
    		
    		
    		

    		
    		
    		echo SideNav::widget([
				'type' => SideNav::TYPE_DEFAULT,
				'heading' => "Menu (".$user->fullname.")",
				'items' => $items, 
				
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
        <p class="pull-right">Powered By: Sapient Technology Solutions, Ver 1.0.5</p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
