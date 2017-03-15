# StackTrace
Simple PHP library to format &amp; filter a stack trace.

# Install
Using composer
```
composer require gohanman/stack-trace
```

# Usage

```php
<?php

use Gohanman\StackTrace\StackTrace;

function foo()
{
    bar();
}

function bar()
{
    $stack = new StackTrace();
    $stack->setLimit(5);
    $stack->setFormat("#%frame, %basename, Line %line, %function\n");
    echo $stack->output();
}

foo();

```

Prints:
```
#1, SomeFile.php, Line 7, bar
#2, SomeFile.php, Line 18, foo
```

Allowed format placeholders:
* `%frame` the current frame number
* `%filename` the filename including path
* `%basename` the filename excluding path
* `%line` the line number where the function was called
* `%function` the function name including class if applicable

