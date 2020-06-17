<?php
	/**
	 * @var \Codeception\Scenario $scenario
	 */
	$I = new AcceptanceTester($scenario);
	$I->wantTo('выполнить действия и увидеть результат');

	$I->amOnPage('/');
	
