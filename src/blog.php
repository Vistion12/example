<?php


function addPost(): string
{
    //TODO реализовать функционал добавление поста в хранилище db.txt
    // Заголовок и тело поста считывает тут же через readline
    // диалог с пользователем введите заголовок введите пост далее открываем файл если нет вернуть красный цвет ошибки
    // обработать ошибки
    // разделить точкой с запятой
    // в случае успеха вернуть текст что пост добавлен
    $title = readline("Введите заголовок ");
    $content = readline("Введите текст поста ");

    if (empty($title)|| empty($content)){
        return handleError("Error: заголовок и текст не должны быть пустыми ");
    }

    $file= fopen('db.txt','a');

    if(!$file){
        return handleError("Error: файл не открыт для записи");
    }

    $post = $title . "; " . $content .  "\n";

    fwrite($file,$post);

    fclose($file);
    return "пост добавлен";
}

function readAllPosts(): string
{
    //TODO реализовать чтение всех постов но вывести только заголовки
    if(!file_exists('db.txt')){
        return handleError("Errror: невозможно прочитать файл ");
    }

    if (filesize('db.txt') == 0) {
        return "Нет постов для отображения.";
    }

    $file = fopen('db.txt','r');
    if(!$file){
        return  handleError("Error: Ошибка открытия файла");
    }

    $posts = fread($file,filesize('db.txt'));

    fclose($file);

    $lines = explode("\n", $posts);
    $headers = '';
    foreach ($lines as $line){
        if($line){
            $postParts = explode(";", $line);
            $headers .= $postParts[0] . "\n";
        }
    }

    return $headers ? $headers : "посты отсутствуют" ;
}

function readPost(): string
{
    //TODO реализовать чтение одного поста, номер поста считывай из командной строки
    if(!isset($_SERVER['argv'][2])){
        return handleError("Error: Не указан номер поста");
    }

    $postNumber = $_SERVER['argv'][2];

    if(!file_exists('db.txt')){
        return handleError("Errror: постов не существует добавьте посты ");
    }

    $file = fopen('db.txt', 'r');
    if(!$file){
        return  handleError("error: невозможно открыть файл для четния");
    }

    $posts = fread($file, filesize('db.txt'));
    fclose($file);

    $lines = explode("\n",$posts);
    if(!isset($lines[$postNumber-1])){
        return handleError("error: пост с таким номером не найден");
    }

    $postParts = explode(";", $lines[$postNumber-1]);
    return "Заголовок: " . $postParts[0] . "\nКонтент: " . $postParts[1];

}

function clearPosts(): string
{
    //TODO стереть все посты
    if(!file_exists('db.txt')){
        return handleError("Errror: постов не существует добавьте посты ");
    }
    $file=fopen('db.txt','w');
    if(!$file){
        return handleError("error: невозможно очистить файл");
    }
    fclose($file);
    return "все посты удалены";
}

function searchPost(): string
{
    //TODO необязательно, реализовать поиск по заголовку (можно и по всему телу), поисковый запрос через readline
    $query= readline("Введите запрос ");

    if (empty($query)) {
        return handleError("Ошибка: запрос не может быть пустым.");
    }

    if(!file_exists('db.txt')){
        return handleError("Errror: постов не существует добавьте посты ");
    }

    $file = fopen('db.txt', 'r');
    if(!$file){
        return  handleError("error: невозможно открыть файл для четния");
    }

    $posts = fread($file, filesize('db.txt'));
    fclose($file);

    $lines = explode("\n", $posts);
    $foundPosts = [];

    foreach ($lines as $line) {
        if ($line && stripos($line, $query) !== false) {
            $postParts = explode(";", $line);
            $foundPosts[] = "Заголовок: " . $postParts[0] . "\nКонтент: " . $postParts[1];
        }
    }

    if (empty($foundPosts)) {
        return "Не найдено постов, соответствующих запросу \"$query\".";
    }

    return implode("\n\n", $foundPosts);


}

function delPost():string
{
    if (!isset($_SERVER['argv'][2])) {
        return handleError("Error: Не указан номер поста");
    }

    $postNumber = $_SERVER['argv'][2];

    if (!file_exists('db.txt')) {
        return handleError("Error: постов не существует, добавьте посты");
    }

    $file = fopen('db.txt', 'r');
    if (!$file) {
        return handleError("Error: невозможно открыть файл для чтения");
    }

    $posts = fread($file, filesize('db.txt'));
    fclose($file);

    $lines = explode("\n", $posts);

    if (!isset($lines[$postNumber - 1]) || empty($lines[$postNumber - 1])) {
        return handleError("Error: пост с таким номером не найден");
    }

    unset($lines[$postNumber - 1]);

    $file = fopen('db.txt', 'w');
    if (!$file) {
        return handleError("Error: невозможно открыть файл для записи");
    }

    $newContent = implode("\n", $lines);
    fwrite($file, $newContent);
    fclose($file);

    return "Пост с номером $postNumber удалён.";
}
