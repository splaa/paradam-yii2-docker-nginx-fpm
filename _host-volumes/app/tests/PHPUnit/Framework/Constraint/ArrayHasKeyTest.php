<?php

	namespace app\modules\services;

	use PHPUnit\Framework\TestCase;

	class ArrayHasKeyTest extends TestCase
	{
		public function testFailure()
		{
			$this->assertArrayHasKey('foo', [
				'bar' => 'baz',
				'foo' => 'Yes'
			]);
		}

		public function testFailureClass()
		{
			$this->assertClassHasAttribute('init', app\modules\services\Module::class);
		}

	}
