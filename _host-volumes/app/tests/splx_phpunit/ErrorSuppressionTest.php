<?php
// paradam.me.loc/ExpectedErrorTest.php
	namespace unit;
	
	use PHPUnit\Framework\TestCase;

    class ErrorSuppressionTest extends TestCase
    {
        public function testFileWriting()
        {
            $writer = new FileWriter();
            $this->assertFalse(@$writer->write('/is-not-writeable/file', 'stuff'));

        }
    }

    class FileWriter
	{
		public function write($file, $content)
		{
			$file = fopen($file, 'w');
			if (false === $file) {
				return false;
			}
		}
	}