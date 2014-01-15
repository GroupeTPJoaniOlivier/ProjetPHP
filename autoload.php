<?php

// your autoloader
$closure = function($className) {
    $realName = str_replace('/','\\', $className);

    require_once __DIR__ . "/src/" . $realName . '.php';
};

spl_autoload_register($closure);