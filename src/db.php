<?php
function  getDB(): PDO
{
    static $db = null;
    if (is_null($db)){
        $db = new PDO("sqlite:database.db");
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    return $db;

}
function initDB():string
{
    $db = getDB();

    $db->query("PRAGMA foreign_keys = ON;");
    $db->query("CREATE TABLE IF NOT EXISTS `categories` (
	`id` INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
	`category` TEXT NOT NULL
);");
    $db->query("CREATE TABLE IF NOT EXISTS `posts` (
	`id` INTEGER  PRIMARY KEY AUTOINCREMENT UNIQUE,
	`title` TEXT NOT NULL,
	`text` TEXT NOT NULL,
	`id_category` INTEGER,
FOREIGN KEY(`id_category`) REFERENCES `categories`(`id`) ON DELETE RESTRICT
);");

    return "структура БД построена";
}

function seedDb(): string
{
    $db = getDB();
    initDB();

    $db->query("DELETE FROM posts");
    $db->query("DELETE FROM categories");

    // Сбрасываем автоинкремент
    $db->query("DELETE FROM sqlite_sequence WHERE name='categories'");
    $db->query("DELETE FROM sqlite_sequence WHERE name='posts'");

    $categories = ['спорт', 'политика', 'кино', 'музыка', 'технологии'];
    foreach ($categories as $category) {
        $db->prepare("INSERT INTO categories (category) VALUES (:category)")
            ->execute(['category' => $category]);
    }

    $categoryIds = range(1, 5);  // предполагаем, что у нас 5 категорий

    foreach ($categoryIds as $categoryId) {
        $postCount = rand(5, 10);  // количество постов от 5 до 10 для каждой категории
        for ($i = 1; $i <= $postCount; $i++) {
            $title = "Заголовок для поста $i в категории $categoryId";
            $text = "Текст поста $i в категории $categoryId.";
            $db->prepare("INSERT INTO posts (title, text, id_category) VALUES (:title, :text, :id_category)")
                ->execute(['title' => $title, 'text' => $text, 'id_category' => $categoryId]);
        }
    }

    return "Данные добавлены";
}