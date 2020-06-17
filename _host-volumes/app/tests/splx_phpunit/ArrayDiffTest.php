<?php

namespace unit;

use PHPUnit\Framework\TestCase;

class ArrayDiffTest extends TestCase
{
    public function testEquality()
    {
        $this->assertSame(
            [1, 2, 3, 4, 5, 6, 7],
             [1, 2, 3, 4, 5, 6, 7]
        );
    }
}
