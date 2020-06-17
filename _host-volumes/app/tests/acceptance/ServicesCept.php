<?php
	/**
	 * @var $scenario
	 */
	$I = new AcceptanceTester($scenario);
	$I->wantTo('Services');
	
	$I->amOnPage('services');
	$I->see('Services');

//   TODO: Добавить проверки согласно функционалу