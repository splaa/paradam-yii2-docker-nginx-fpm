<?php

namespace unit;

use PHPUnit\Framework\TestCase;

class OutTestTest extends TestCase
{
    public function testExpectFooActtualFoo()
    {
        $this->expectOutputString('foo');
        print 'foo';
    }

    public function testExpectBarActualBaz()
    {
        $this->expectOutputString('baz');
        print 'baz';
    }

}
