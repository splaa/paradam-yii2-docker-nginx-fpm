<?php


	use PHPUnit\Framework\TestCase;

	class DatabaseTest extends TestCase
	{
		protected function setUp(): void
		{
			if (extension_loaded('mysqli')) {
				$this->markTestSkipped(
					'Расширение MySQLi недоступно'
				);
			}
		}

		/**
		 * @requires PHP 7.3
		 */
		public function testConnection()
		{
//
		}

	}
