<?php

function getDatabase():string
{
    $config = parse_ini_file(__DIR__ . '/../config.ini', true);

    if (isset($config['database']['file'])) {
        return $config['database']['file'];
    } else {
        return handleError("Ошибка: Не указано имя файла базы данных в config.ini");
    }

}