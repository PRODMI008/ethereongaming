<?php
/*
 * inc-auth.php — Аутентификация админ-панели
 *
 * Логин:  astr0alteam
 * Пароль: F!r4gm!ar7131566  (хранится только в виде bcrypt-hash, не в открытом виде)
 *
 * Сессия: $_SESSION['admin_logged_in'] = true после успешного входа.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('ADMIN_USERNAME', 'astr0alteam');
define('ADMIN_PASSWORD_HASH', '$2y$10$fVWxvD5ci2f8Xe8eSKM73uSHap7so00IHFY4VacH2EVr8XHbSKMue');

function admin_is_logged_in() {
    return !empty($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function admin_login($username, $password) {
    if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        return true;
    }
    return false;
}

function admin_logout() {
    $_SESSION = array();
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}