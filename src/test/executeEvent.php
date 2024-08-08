<?php

require __DIR__ . '/../test/allEvents.php';

use Test\AllEvents;

if ($argc < 2) {
    echo "Usage: php execute.php <functionName>";
    exit();
}

$functionName = $argv[1];

if (method_exists('Test\AllEvents', $functionName)) {
    call_user_func_array([AllEvents::class, $functionName], []);
} else {
    echo "Function $functionName in controller $controller does not exist\n";
    exit();
}


