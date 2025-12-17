<?php
/**
 * ============================================
 * Logout Script (logout.php)
 * ============================================
 * Script untuk logout admin dan menghapus session
 */

// Mulai session
session_start();

// Hapus semua session variable
$_SESSION = [];

// Hapus session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy session
session_destroy();

// Redirect ke login page
header("Location: login.php");
exit();
?>
