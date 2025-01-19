<?php
require  __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/config.php';

try {
    $result = main();
    echo $result;
} catch (Exception $e) {
    echo $e->getMessage();
}


