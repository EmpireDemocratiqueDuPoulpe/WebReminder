<?php
require_once "../init.php";

$redirect_path = "../login.php";
$connected_redirect_path = "../index.php";

########################################
# Check vars
########################################

$vars = ["username", "password"];
$post_vars_valid = check_post_vars($vars);

if (!$post_vars_valid["exist"]) {

    // Get error id
    $error_i = array_search($post_vars_valid["var_name"], $vars);
    $error_i = ($error_i !== false) ? ($error_i + 51) : UNKNOWN_REG_LOG_ERROR;

    // Redirect
    header("Location: $redirect_path?l_error=$error_i");
    die;
}

$username = $_POST["username"];
$password = $_POST["password"];

########################################
# Check username
########################################

// Is username exist?
$usr_exist = BaseClass::sendQueryStatic($db, 'SELECT user_id FROM users WHERE username = :username', ["username" => $username]);

if (!$usr_exist) {

    header("Location: $redirect_path?l_error=".USR_NOT_VALID);
    die;

} else {

    $user_id = $usr_exist[0]["user_id"];
}

########################################
# Check password
########################################

// Get passwords
$password_peppered = hash_hmac("sha256", $password, $config["SECURITY"]["pepper"]);
$password_hashed = BaseClass::sendQueryStatic($db, "SELECT password FROM users WHERE username = :username", ["username" => $username]);

if (!$password_hashed) {

    header("Location: $redirect_path?l_error=".UNKNOWN_REG_LOG_ERROR);
    die;

} else {

    $password_hashed = $password_hashed[0]["password"];
}

// Check passwords
if (!password_verify($password_peppered, $password_hashed)) {

    header("Location: $redirect_path?l_error=".PASSWORDS_NOT_VALID);
    die;
}

########################################
# Get user's data if user/pwd match
########################################

$query = '
    SELECT
        user_id,
        username,
        email,
        phone_number,
        profile_picture_url
    FROM
        users
    WHERE
        user_id = :user_id';

// Get user
$user = BaseClass::sendQueryStatic($db, $query, ["user_id" => $user_id]);

// Connect user
if ($user) {

    $user = $user[0];

    if (session_status() != PHP_SESSION_ACTIVE) { session_start(); }

    $_SESSION["user_id"] = $user["user_id"];
    $_SESSION["username"] = $user["username"];
    $_SESSION["email"] = $user["email"];
    $_SESSION["phone_number"] = $user["phone_number"];
    $_SESSION["profile_picture_url"] = $user["profile_picture_url"];

    header("Location: $connected_redirect_path");
    exit;

} else {

    header("Location: $redirect_path?l_error=".UNKNOWN_REG_LOG_ERROR);
    die;
}