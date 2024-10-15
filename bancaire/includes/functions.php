<?php
function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

function checkSession() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['client_id'])) {
        header("Location: connexion.php");
        exit();
    }
}
?>