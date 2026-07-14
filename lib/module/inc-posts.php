<?php
/*
 * inc-posts.php — Хелпер для чтения/записи постов в lib/data/posts.json
 *
 * Структура одного поста:
 *   id             — уникальный строковый slug (используется для редактирования/удаления)
 *   title          — заголовок поста
 *   thumbnail      — путь к картинке-превью (напр. /img/videos/1.jpg)
 *   animate_class  — CSS-класс анимации (page-video-N)
 *   scale_class    — CSS-класс масштабирования (scale-content-txt-N)
 *   content        — текст поста (\n перенос строки)
 *   tags           — теги в виде строки (#EGWiN #Partners ...)
 */

define('POSTS_FILE', __DIR__ . '/../data/posts.json');

function posts_load() {
    if (!file_exists(POSTS_FILE)) {
        return array('posts' => array());
    }
    $raw = @file_get_contents(POSTS_FILE);
    $data = json_decode($raw, true);
    if (!is_array($data) || !isset($data['posts']) || !is_array($data['posts'])) {
        return array('posts' => array());
    }
    return $data;
}

function posts_save($data) {
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    return file_put_contents(POSTS_FILE, $json) !== false;
}

function posts_get_all() {
    $data = posts_load();
    return $data['posts'];
}

function posts_get_by_id($id) {
    foreach (posts_get_all() as $p) {
        if ($p['id'] === $id) {
            return $p;
        }
    }
    return null;
}

function posts_add($post) {
    $data = posts_load();
    $data['posts'][] = $post;
    return posts_save($data);
}

function posts_update($id, $fields) {
    $data = posts_load();
    foreach ($data['posts'] as $i => $p) {
        if ($p['id'] === $id) {
            $data['posts'][$i] = array_merge($p, $fields);
            $data['posts'][$i]['id'] = $id;
            return posts_save($data);
        }
    }
    return false;
}

function posts_delete($id) {
    $data = posts_load();
    $data['posts'] = array_values(array_filter($data['posts'], function($p) use ($id) {
        return $p['id'] !== $id;
    }));
    return posts_save($data);
}

function posts_render_content($text) {
    $escaped = htmlspecialchars($text);
    $linked = preg_replace(
        '~\(?(\bhttps?://[^\s)<]+)\)?~i',
        '<a href="$1" target="_blank" rel="noopener" style="color:#6a9cff;text-decoration:underline">$1</a>',
        $escaped
    );
    return nl2br($linked);
}

function posts_gen_id($title) {
    $slug = trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $title), '-');
    if ($slug === '') {
        $slug = 'post';
    }
    $base = strtolower($slug);
    $id = $base;
    $i = 1;
    while (posts_get_by_id($id) !== null) {
        $id = $base . '-' . $i++;
    }
    return $id;
}