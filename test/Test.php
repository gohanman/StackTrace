<?php

use Gohanman\StackTrace\StackTrace;

include_once(__DIR__ . '/stack.php');

class Test extends PHPUnit_Framework_TestCase
{
    public function testAll()
    {
        $val = TestStackTraceThoroughly::invoke();
        $expected = '1 stack.php 19 foo,2 stack.php 26 TestStackTraceThoroughly->nonStatic,3 Test.php 11 TestStackTraceThoroughly::invoke,';
        $this->assertEquals($val, $expected);
    }
}

