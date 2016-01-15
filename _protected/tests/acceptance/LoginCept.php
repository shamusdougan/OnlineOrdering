<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that basic login function works');
$I->amOnPage('user-management/auth/login'); 
$I->see('Irwins Online Ordering System');
$I->fillField('LoginForm[username]','superadmin');
$I->fillField('LoginForm[password]','superadmin');
$I->click('Login');
$I->wait(5);
$I->see('Super Admin');

$I->saveSessionSnapshot('login');