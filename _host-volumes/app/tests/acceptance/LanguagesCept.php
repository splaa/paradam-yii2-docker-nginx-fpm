<?php
	/**
	 * @var $scenario
	 */
	$I = new AcceptanceTester($scenario);
	$I->wantTo('Проверка Языков:' . PHP_EOL);
	
	$I->amOnPage('/en');
	$I->see('Congratulations!');
	
	$I->amOnPage('/en');
	$I->see('Русский', 'a');
	$I->see('Congratulations!');
	$I->dontSee('Поздравляю!');
	
	$I->amOnPage('/ru');
	$I->see('Englis', 'a');
	$I->see('Поздравляю!');
	$I->dontSee('Congratulations!');
