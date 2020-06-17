<?php
// paradam.me.loc/MultipleDependenciesTest.php
	namespace unit;
	
	use PHPUnit\Framework\TestCase;

    class MultipleDependenciesTest extends TestCase
    {
        public function testProducerFirst(): string
        {
            $this->assertTrue(true);
            return 'first';
        }

        public function testProducerSecond(): string
        {
            $this->assertTrue(true);
			return 'second';
		}
		
		/**
		 * @depends   testProducerFirst
		 * @depends   testProducerSecond
		 * @param $a
		 * @param $b
		 */
		public function testConsumer($a, $b): void
		{
			$this->assertSame('first',$a);
			$this->assertSame('second',$b);
		}
	}
