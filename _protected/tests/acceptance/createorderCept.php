<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Create a Customer Order');
$I->checkLogin("superadmin", "superadmin", $I);
$I->amOnPage('/customer-order');
$I->wait(2); 
$I->click(['css' => 'div.sap_icon.sap_new']);
$I->wait(2); 
$I->canSee('Customer Order: New Order');
