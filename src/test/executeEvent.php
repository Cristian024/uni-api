<?php

require __DIR__ . '/../test/userEvent.php';

use Test\UserEvent;

if ($argc < 3) {
    echo "Usage: php execute.php <controller> <functionName>";
    exit();
}

$controller = $argv[1];
$functionName = $argv[2];

if (method_exists($controller, $functionName)) {
    if ($controller == 'Test\UserEvent') {
        call_user_func_array([UserEvent::class, $functionName], []);
    }
} else {
    echo "Function $functionName in controller $controller does not exist\n";
    exit();
}


