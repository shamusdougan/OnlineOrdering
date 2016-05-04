<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('perform actions and see result');
$I->amOnPage('user-management/auth/login');
$I->fillField(['id' => 'loginform-username'], 'superadmin');
$I->fillField(['id' => 'loginform-password'], 'superadmin');
$I->click('Login');
$I->wait(10);
$I->see('Menu (Super Admin Account)');
$I->wait(10);
