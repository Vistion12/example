<?php
function handleError(string $error): string
{
return "\033[31m" . $error . "\r\n \033[97";
}

function handleHelp(): string
{
    $help = <<<HELP
доступные команды
help - вывод данной подсказки
add-post - создать новый пост
read-all-posts - прочитать все посты
read-post - прочитать какой то конкретный(после команды введите номер поста)
clear-posts - очистить все посты
delete-post - удалить пост (после команды введите номер поста)

HELP;

    return $help;
}