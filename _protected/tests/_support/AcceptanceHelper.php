<?php
namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class AcceptanceHelper extends \Codeception\Module
{



	public function checkLogin($username, $password, $I)
	{
		
		
		$I->amOnPage('user-management/auth/login'); 
		$I->see('Irwins Online Ordering System');
		$I->fillField('LoginForm[username]',$username);
		$I->fillField('LoginForm[password]',$password);
		$I->click('Login');
		$I->wait(5);
		$I->see('Super Admin');

		
	}

}
