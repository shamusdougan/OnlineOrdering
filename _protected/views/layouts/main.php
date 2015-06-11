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
					['label' => 'Clients', 'icon' => 'home', 'url' => Url::toRoute('/clients')],
				
					['label' => 'Settings', 'icon' => 'cog', 'visible' => Yii::$app->user->can("useSettings"), 'items' => [
						['label' => 'User Accounts', 'url' => Url::toRoute('/user'), 'active'=>($currentItem == 'userItem')], 
						['label' => 'Lookups', 'url' => Url::toRoute('/lookup'), 'active'=>($currentItem == 'lookupItem')],
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
