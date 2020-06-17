<?php
	require_once __DIR__ . '/../../../../vendor/autoload.php';

	use PHPUnit\Framework\TestCase;


	class Module
	{
		public $geeks = "test attribute";
	}


	class ModuleServiceTest extends TestCase
	{
		public function testMyThree()
		{
			$this->assertClassHasAttribute('geeks', Module::class, 'Неработает');
		}
	}
