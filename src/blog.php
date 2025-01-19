<?php
function addPost(): string
{
    //TODO переделать реализацию методов на работу с БД использовать prepare statements
    //прежде чем добавлять пост продумать как о том что надо вводить же айди категории
    $db = getDB();

    // Получаем все категории
    $stmt = $db->query("SELECT id, category FROM categories");
    $categories = $stmt->fetchAll();

    // Выводим список категорий
    echo "Список категорий:\n";
    foreach ($categories as $category) {
        echo "{$category['id']}. {$category['category']}\n";
    }

    // Получаем ID категории
    do {
        $categoryId = (int)readline("Введите ID категории: ");
    } while (!in_array($categoryId, array_column($categories, 'id')));

    // Вводим данные поста
    $title = readline("Введите заголовок поста: ");
    $content = readline("Введите текст поста: ");

    // Добавляем пост в БД
    $db->prepare("INSERT INTO posts (title, text, id_category) VALUES (:title, :text, :id_category)")
        ->execute(['title' => $title, 'text' => $content, 'id_category' => $categoryId]);

    return "Пост добавлен";
}

function readAllPosts(): string
{
    //TODO организовать вывод 1 пост 1 строка в виде текста. подсказка использовать fetch
    // или преобразоватьмассив в текст
    $db = getDB();
    $stmt = $db->query("SELECT p.id AS post_id, c.id AS cat_id, c.category AS category, p.title AS post_title, p.text AS post_text 
        FROM posts p 
        JOIN categories c ON p.id_category = c.id");

    $result = $stmt->fetchAll();

    if (empty($result)) {
        return "Посты не найдены.";
    }

    $output = "";
    foreach ($result as $post) {
        $output .= "Пост #{$post['post_id']} ({$post['category']}): {$post['post_title']}\n";
        $output .= "{$post['post_text']}\n\n";
    }

    return $output;
}

function readPost(): string
{
    $db = getDB();

    do {
        $id = (int)readline("Введите айди поста: ");
    } while (empty($id));

    $stmt = $db->prepare("SELECT p.id AS post_id, c.category AS category, p.title AS post_title, p.text AS post_text
        FROM posts p
        JOIN categories c ON p.id_category = c.id
        WHERE p.id = :id");
    $stmt->execute(['id' => $id]);

    $post = $stmt->fetch();

    if (!$post) {
        return "Пост не найден.";
    }

    return "Пост #{$post['post_id']} ({$post['category']}): {$post['post_title']}\n{$post['post_text']}";
}


function searchPost(): string
{
    //TODO реализовать поиск по заголовку (можно и по всему телу), поисковый запрос через readline
    $db = getDB();
    $query = readline("Введите запрос для поиска: ");

    $stmt = $db->prepare("SELECT p.id AS post_id, c.category AS category, p.title AS post_title, p.text AS post_text
        FROM posts p
        JOIN categories c ON p.id_category = c.id
        WHERE p.title LIKE :query OR p.text LIKE :query");
    $stmt->execute(['query' => "%$query%"]);

    $result = $stmt->fetchAll();

    if (empty($result)) {
        return "Посты не найдены.";
    }

    $output = "";
    foreach ($result as $post) {
        $output .= "Пост #{$post['post_id']} ({$post['category']}): {$post['post_title']}\n";
        $output .= "{$post['post_text']}\n\n";
    }

    return $output;
}

function delPost():string
{
    $db = getDB();

    do {
        $id = (int)readline("Введите ID поста для удаления: ");
    } while (empty($id));

    // Проверка существования поста
    $stmt = $db->prepare("SELECT * FROM posts WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $post = $stmt->fetch();

    if (!$post) {
        return "Пост не найден.";
    }

    // Удаление поста
    $db->prepare("DELETE FROM posts WHERE id = :id")->execute(['id' => $id]);

    return "Пост с ID $id удален.";
}
