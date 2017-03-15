<?php

use Gohanman\StackTrace\StackTrace;

function foo()
{
    $stack = new StackTrace();
    $stack->setLimit(3);
    $stack->setFormat('%frame %basename %line %function,');
    $out = $stack->output();

    return $out;
}

class TestStackTraceThoroughly
{
    public function nonStatic()
    {
        return foo();
    }

    static public function invoke()
    {
        $obj = new TestStackTraceThoroughly();

        return $obj->nonStatic();
    }
}

