<?php
/**
 * @var $this yii\web\View
 * @var $model webvimark\modules\UserManagement\models\forms\LoginForm
 */

use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class='sapient_login_wrapper'>
   	<div class='sapient_login_content'>
		<div class="panel-body">

			<?php $form = ActiveForm::begin([
				'id'      => 'login-form',
				'options'=>['autocomplete'=>'off'],
				'validateOnBlur'=>false,
				'fieldConfig' => [
					'template'=>"{input}\n{error}",
				],
			]) ?>
			<span class='login_title'>Irwins Online Ordering System</span><br><br>
			<?= $form->field($model, 'username')
				->textInput(['placeholder'=>'email address', 'autocomplete'=>'off']) ?>

			<?= $form->field($model, 'password')
				->passwordInput(['placeholder'=>$model->getAttributeLabel('password'), 'autocomplete'=>'off']) ?>

			<?= $form->field($model, 'rememberMe')->checkbox(['value'=>true]) ?>

			<?= Html::submitButton(
				UserManagementModule::t('front', 'Login'),
				['class' => 'btn btn-lg btn-primary btn-block']
			) ?>

			<div class="row registration-block">
				<div class="col-sm-6">
					<?= GhostHtml::a(
						UserManagementModule::t('front', "Registration"),
						['/user-management/auth/registration']
					) ?>
				</div>
				<div class="col-sm-6 text-right">
					<?= GhostHtml::a(
						UserManagementModule::t('front', "Forgot password ?"),
						['/user-management/auth/password-recovery']

 					) ?>
 					
 					
 			<?php ActiveForm::end() ?>
 		</div>
 	</div>
 </div>		


<?php
$css = <<<CSS
html, body {
	background: #eee;
	-webkit-box-shadow: inset 0 0 100px rgba(0,0,0,.5);
	box-shadow: inset 0 0 100px rgba(0,0,0,.5);
	height: 100%;
	min-height: 100%;
	position: relative;
}
#login-wrapper {
	position: relative;
	top: 30%;
}
#login-wrapper .registration-block {
	margin-top: 15px;
}

.sapient_login_wrapper
{
	height: 100%;
	
	background-image: url("/images/login_background.jpg");
	background-size:cover;
}

.sapient_login_content
{
	width: 400px;
	position: relative;
	top: 30%;
	margin-right: auto;
	margin-left: auto;
	background-color: #EFEFEF;
	border-radius: 20px;
	padding-top: 10px;

}

.panel-body
{
	width: 100%;
	height: 100%;
	padding-left: 50px;
	padding-bottom: 10px;
}

.panel-body input[type=text], input[type=password]
{
	width: 300px;
}

.login_title
{
	font-size: 24px;	
	
}




CSS;

$this->registerCss($css);
?>