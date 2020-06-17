<?php


	use PHPUnit\Framework\TestCase;

	class SomethingTest extends TestCase
	{
		/**
		 * @expectedException
		 */

		public function testSomething()
		{
			$this->assertTrue(true, 'This should already work.');

			$this->markTestIncomplete(
				'Этот тест еще не реализован'
			);
		}


	}
