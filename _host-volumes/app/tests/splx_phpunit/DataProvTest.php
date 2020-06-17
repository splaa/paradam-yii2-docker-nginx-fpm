<?php
// paradam.me.loc/DataProvTest.php
	namespace unit;
	
	use PHPUnit\Framework\TestCase;

    class DataProvTest extends TestCase
    {
        /**
         * @dataProvider additionProvider
         * @dataProvider additionWithNonNegativeNumbersProvider
         * @dataProvider additionWithNegativeNumbersProvider
         * @param $a
         * @param $b
         * @param $expected
         */
        public function testAdd($a, $b, $expected): void
		{
			$this->assertSame($expected, $a + $b);
		}
		
		public function additionProvider(): array
		{
			return [
				'adding zero' => [0, 0, 0],
				'zero plus one' => [0, 1, 1],
				'one plus zero' => [1, 0, 1],
				'one plus one' => [1, 1, 2],
				'1+2' => [1, 2, 3],
			];
		}
		
		public function additionWithNonNegativeNumbersProvider(): array
		{
			return [
				'NonNegativeNumbers 0,1' => [0, 1, 1],
				'NonNegativeNumbers 1,0' => [1, 0, 1],
				'NonNegativeNumbers 1,1' => [1, 1, 2]
			];
		}
		
		public function additionWithNegativeNumbersProvider(): array
		{
			return [
				'NegativeNumbers -1,1' => [-1, 1, 0],
				'NegativeNumbers -1,-1' => [-1, -1, -2],
				'NegativeNumbers 1,-1' => [1, -1, 0]
			];
		}
	}
