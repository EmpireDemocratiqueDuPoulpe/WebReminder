<?php
require_once "../init.php";

if (session_status() == PHP_SESSION_ACTIVE) {

    // Destroy session's vars
    $_SESSION = array();

    // Destroy every session infos
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destroy session
    session_destroy();
}

header("Location: ../login.php");
exit;