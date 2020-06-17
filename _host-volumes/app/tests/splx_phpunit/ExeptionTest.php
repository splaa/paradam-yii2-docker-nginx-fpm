<?php
// paradam.me.loc/ExeptionTest.php
	namespace unit;
	
	use LengthException;
    use PHPUnit\Framework\TestCase;

    class ExceptionTest extends TestCase
    {

        public function testException(): void
        {
            $this->expectException(LengthException::class);

            if (true) {
                throw new LengthException('Количество символов в пароле  не соответствует требованиям.');
            }
			
		}
	}
