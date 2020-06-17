<?php
// paradam.me.loc/DependencyFailureTest.php


use PHPUnit\Framework\TestCase;

class DependencyFailureTest extends TestCase
{
    public function testOne(): string
    {
        $this->assertTrue(true);
        return 'first';
    }

    /**
     * @depends testOne
     * @param $a
     */
    public function testTwo($a): void
    {
        $this->assertSame('first', $a);
    }
}
