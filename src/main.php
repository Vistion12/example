<?php

function main(): string
{
    $command = parseCommand();

    if (function_exists($command)){
        $result = $command();
    } else{
        $result = handleError("нет такой функции");
    }

    return $result;
}

function parseCommand(): string
{
    $commands = [
        'help' => 'handleHelp',
        'add-post' => 'addPost',
        'read-all-posts' => 'readAllPosts',
        'read-post' => 'readPost',
        'search-post' => 'searchPost',
        'delete-post' =>'delPost',
        'init' =>'initDB',
        'seed'=> 'seedDB',
    ];

    $functionName = $commands[$_SERVER['argv'][1]] ?? 'handleHelp';

    return $functionName;
}