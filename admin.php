<?php
/*
 * admin.php — Админ-панель управления постами
 *
 * Логин:  astr0alteam
 * Пароль: F!r4gm!ar7131566
 *
 * Возможности:
 *   - Вход / выход (сессия)
 *   - Список постов
 *   - Создание / редактирование / удаление постов
 *   - Посты хранятся в lib/data/posts.json
 */

require __DIR__ . '/lib/module/inc-auth.php';
require __DIR__ . '/lib/module/inc-posts.php';

/*
 * Загрузка превью-картинки в /img/videos/
 * Возвращает относительный путь (напр. /img/videos/abc.jpg) при успехе,
 * или null если файл не загружался, или false при ошибке.
 */
function admin_handle_upload($field) {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    $file = $_FILES[$field];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    $allowed = array('image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp');
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    if (!isset($allowed[$mime])) {
        return false;
    }
    $ext = $allowed[$mime];
    $name = 'post-' . time() . '-' . substr(bin2hex(random_bytes(4)), 0, 8) . '.' . $ext;
    $dest = __DIR__ . '/img/videos/' . $name;
    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        return false;
    }
    return '/img/videos/' . $name;
}

$msg = '';
$err = '';

/* --- Обработка POST-запросов (действия с постами) --- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* Вход */
    if (isset($_POST['action']) && $_POST['action'] === 'login') {
        if (admin_login($_POST['username'] ?? '', $_POST['password'] ?? '')) {
            header('Location: admin.php');
            exit;
        }
        $err = 'Неверный логин или пароль.';
    }

    /* Дальнейшие действия требуют авторизации */
    elseif (admin_is_logged_in()) {

        /* Выход */
        if (isset($_POST['action']) && $_POST['action'] === 'logout') {
            admin_logout();
            header('Location: admin.php');
            exit;
        }

        /* Создание поста */
        elseif (isset($_POST['action']) && $_POST['action'] === 'create') {
            $uploaded = admin_handle_upload('thumbnail_file');
            if ($uploaded === false) {
                $err = 'Ошибка загрузки файла (допустимы jpg/png/gif/webp).';
            } else {
                $post = array(
                    'id'             => posts_gen_id($_POST['title'] ?? ''),
                    'title'          => trim($_POST['title'] ?? ''),
                    'thumbnail'      => $uploaded ?: trim($_POST['thumbnail'] ?? ''),
                    'animate_class'  => trim($_POST['animate_class'] ?? 'page-video-1'),
                    'scale_class'    => trim($_POST['scale_class'] ?? 'scale-content-txt-4'),
                    'content'        => $_POST['content'] ?? '',
                    'tags'           => trim($_POST['tags'] ?? ''),
                );
                if ($post['title'] === '' || $post['content'] === '') {
                    $err = 'Заголовок и текст поста обязательны.';
                } elseif (posts_add($post)) {
                    $msg = 'Пост "' . htmlspecialchars($post['title']) . '" добавлен.';
                } else {
                    $err = 'Ошибка сохранения (проверьте права на lib/data/posts.json).';
                }
            }
        }

        /* Обновление поста */
        elseif (isset($_POST['action']) && $_POST['action'] === 'update') {
            $id = $_POST['id'] ?? '';
            $uploaded = admin_handle_upload('thumbnail_file');
            if ($uploaded === false) {
                $err = 'Ошибка загрузки файла (допустимы jpg/png/gif/webp).';
            } else {
                $fields = array(
                    'title'         => trim($_POST['title'] ?? ''),
                    'thumbnail'     => $uploaded ?: trim($_POST['thumbnail'] ?? ''),
                    'animate_class' => trim($_POST['animate_class'] ?? 'page-video-1'),
                    'scale_class'   => trim($_POST['scale_class'] ?? 'scale-content-txt-4'),
                    'content'       => $_POST['content'] ?? '',
                    'tags'          => trim($_POST['tags'] ?? ''),
                );
                if ($fields['title'] === '' || $fields['content'] === '') {
                    $err = 'Заголовок и текст поста обязательны.';
                } elseif (posts_update($id, $fields)) {
                    $msg = 'Пост обновлён.';
                } else {
                    $err = 'Не удалось обновить пост (id не найден).';
                }
            }
        }

        /* Удаление поста */
        elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
            $id = $_POST['id'] ?? '';
            if (posts_delete($id)) {
                $msg = 'Пост удалён.';
            } else {
                $err = 'Не удалось удалить пост.';
            }
        }
    }
}

/* Какие данные показывать в списке/форме */
$editing = null;
if (isset($_GET['edit'])) {
    $editing = posts_get_by_id($_GET['edit']);
}
$posts  = posts_get_all();
$logged = admin_is_logged_in();
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<title>Админ-панель — EthereonGaming</title>
<link rel="stylesheet" href="/lib/css/admin.css">
</head>
<body>

<?php if (!$logged): ?>
    <!-- ============ ФОРМА ВХОДА ============ -->
    <div class="admin-login-box">
        <h1>Админ-панель</h1>
        <?php if ($err): ?><div class="admin-msg admin-err"><?= htmlspecialchars($err) ?></div><?php endif; ?>
        <form method="post">
            <input type="hidden" name="action" value="login">
            <label>Логин
                <input type="text" name="username" autocomplete="username" required>
            </label>
            <label>Пароль
                <input type="password" name="password" autocomplete="current-password" required>
            </label>
            <button type="submit">Войти</button>
        </form>
    </div>

<?php else: ?>
    <!-- ============ ПАНЕЛЬ УПРАВЛЕНИЯ ============ -->
    <header class="admin-header">
        <h1>Управление постами</h1>
        <form method="post" class="admin-logout-form">
            <input type="hidden" name="action" value="logout">
            <button type="submit">Выйти</button>
        </form>
    </header>

    <?php if ($msg): ?><div class="admin-msg admin-ok"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
    <?php if ($err): ?><div class="admin-msg admin-err"><?= htmlspecialchars($err) ?></div><?php endif; ?>

    <section class="admin-section">
        <h2><?= $editing ? 'Редактировать пост' : 'Новый пост' ?></h2>
        <form method="post" enctype="multipart/form-data" class="admin-form">
            <?php if ($editing): ?>
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?= htmlspecialchars($editing['id']) ?>">
            <?php else: ?>
                <input type="hidden" name="action" value="create">
            <?php endif; ?>
            <label>Заголовок (имя поста)
                <input type="text" name="title" required value="<?= htmlspecialchars($editing['title'] ?? '') ?>">
            </label>
            <label>Превью-картинка (путь, напр. /img/videos/1.jpg)
                <input type="text" name="thumbnail" value="<?= htmlspecialchars($editing['thumbnail'] ?? '/img/videos/1.jpg') ?>">
            </label>
            <label>ИЛИ загрузить новое фото с компьютера (jpg/png/gif/webp)
                <input type="file" name="thumbnail_file" accept="image/jpeg,image/png,image/gif,image/webp">
            </label>
            <?php if (!empty($editing['thumbnail'])): ?>
                <div class="admin-preview">
                    <img src="<?= htmlspecialchars($editing['thumbnail']) ?>" alt="превью" style="max-height:90px;border-radius:6px;border:1px solid #555;">
                </div>
            <?php endif; ?>
            <div class="admin-row">
                <label>CSS-класс анимации
                    <input type="text" name="animate_class" value="<?= htmlspecialchars($editing['animate_class'] ?? 'page-video-1') ?>">
                </label>
                <label>CSS-класс масштаба
                    <input type="text" name="scale_class" value="<?= htmlspecialchars($editing['scale_class'] ?? 'scale-content-txt-4') ?>">
                </label>
            </div>
            <label>Текст поста (Enter = перенос строки)
                <textarea name="content" rows="6" required><?= htmlspecialchars($editing['content'] ?? '') ?></textarea>
            </label>
            <label>Теги
                <input type="text" name="tags" value="<?= htmlspecialchars($editing['tags'] ?? '') ?>">
            </label>
            <div class="admin-actions">
                <button type="submit"><?= $editing ? 'Сохранить' : 'Добавить' ?></button>
                <?php if ($editing): ?>
                    <a href="admin.php" class="admin-btn-cancel">Отмена</a>
                <?php endif; ?>
            </div>
        </form>
    </section>

    <section class="admin-section">
        <h2>Список постов (<?= count($posts) ?>)</h2>
        <?php if (!$posts): ?>
            <p class="admin-empty">Постов нет.</p>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                <tr><th>ID (имя)</th><th>Заголовок</th><th>Превью</th><th class="admin-col-actions">Действия</th></tr>
                </thead>
                <tbody>
                <?php foreach ($posts as $p): ?>
                    <tr>
                        <td class="admin-col-id"><?= htmlspecialchars($p['id']) ?></td>
                        <td><?= htmlspecialchars($p['title']) ?></td>
                        <td><?= htmlspecialchars($p['thumbnail']) ?></td>
                        <td class="admin-col-actions">
                            <a href="admin.php?edit=<?= urlencode($p['id']) ?>" class="admin-btn-edit">Изменить</a>
                            <form method="post" class="admin-inline" onsubmit="return confirm('Удалить пост «<?= htmlspecialchars($p['title']) ?>»?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($p['id']) ?>">
                                <button type="submit" class="admin-btn-del">Удалить</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>

<?php endif; ?>

</body>
</html>