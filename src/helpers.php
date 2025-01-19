<?php
function handleError(string $error): string
{
return "\033[31m" . $error . "\r\n \033[97";
}

function handleHelp(): string
{

    //throw new Exception('some exeption');
    $help = <<<HELP
доступные команды
help - вывод данной подсказки
init - иниц структуры БД
seed - заполнит БД фейковыми данными 
add-post - создать новый пост
read-all-posts - прочитать все посты
read-post - прочитать какой то конкретный(после команды введите номер поста)
search-post - поиск поста
delete-post - удалить пост (после команды введите номер поста)

HELP;

    return $help;
}