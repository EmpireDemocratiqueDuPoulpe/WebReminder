<?php
require_once "../init.php";

$redirect_path = "../login.php";

########################################
# Check vars
########################################

$vars = ["username", "email", "password1", "password2"];
$post_vars_valid = check_post_vars($vars);

if (!$post_vars_valid["exist"]) {

    // Get error id
    $error_i = array_search($post_vars_valid["var_name"], $vars);
    $error_i = $error_i !== false ? $error_i : UNKNOWN_REG_LOG_ERROR;

    // Redirect
    header("Location: $redirect_path?r_error=$error_i");
    die;
}

$username = $_POST["username"];
$email = $_POST["email"];
$password1 = $_POST["password1"];
$password2 = $_POST["password2"];
$phone_number = (isset($_POST["phone_number"]) AND !empty($_POST["phone_number"])) ? $_POST["phone_number"] : null;

########################################
# Check username
########################################

// Is username valid?
$username_len = strlen($username);

if ($username_len < 1 OR $username_len > 30) {

    header("Location: $redirect_path?r_error=".USR_NOT_VALID);
    die;
}

// Is username already used?
$usr_exist = BaseClass::sendQueryStatic($db, 'SELECT username FROM users WHERE username = :username', ["username" => $username]);

if ($usr_exist) {

    header("Location: $redirect_path?r_error=".USR_ALREADY_USED);
    die;
}

########################################
# Check email
########################################

// Is email valid?
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    header("Location: $redirect_path?r_error=".EMAIL_NOT_VALID);
    die;
}

// Is email already used?
$email_exist = BaseClass::sendQueryStatic($db, 'SELECT email FROM users WHERE email = :email', ["email" => $email]);

if ($email_exist) {

    header("Location: $redirect_path?r_error=".EMAIL_ALREADY_USED);
    die;
}

########################################
# Check passwords
########################################

// Are the passwords the same?
if ($password1 != $password2) {

    header("Location: $redirect_path?r_error=".PASSWORDS_DIFFERENT);
    die;
}

// Are the passwords valid?
$p_length_valid = (strlen($password1) >= 8);
$p_one_number = (preg_match("#[0-9]+#", $password1));
$p_one_lower_char = (preg_match("#[a-z]+#", $password1));
$p_one_upper_char = (preg_match("#[A-Z]+#", $password1));
$p_one_special_char = (preg_match("#[\W]+#", $password1));

if (!$p_length_valid OR !$p_one_number OR !$p_one_lower_char OR !$p_one_upper_char OR !$p_one_special_char) {

    header("Location: $redirect_path?r_error=".PASSWORDS_NOT_VALID);
    die;
}

// Hash password
$password_peppered = hash_hmac("sha256", $password1, $config["SECURITY"]["pepper"]);
$password_hashed = password_hash($password_peppered, PASSWORD_ARGON2ID);

########################################
# Check phone number
########################################

if ($phone_number !== null) {

    // Filter the phone number
    $phone_number = filter_var($phone_number, FILTER_SANITIZE_NUMBER_INT);

    // Remove +33 if exist
    if (substr($phone_number,0,3) == "+33") { $phone_number = substr($phone_number,3); }

    // Add the leading zero.
    if ($phone_number[0] != "0") { $phone_number = "0".$phone_number; }

    if (strlen($phone_number) < 10 OR strlen($phone_number) > 12) {

        header("Location: $redirect_path?r_error=".TEL_NOT_VALID);
        die;
    }
}

########################################
# Add user
########################################

$query = 'INSERT INTO
              users(
                    username,
                    email,
                    password,
                    phone_number
              )
          VALUES
              (
                   :username,
                   :email,
                   :password,
                   :phone_number
              )';

$args = [
    "username" => $username,
    "email" => $email,
    "password" => $password_hashed,
    "phone_number" => $phone_number
];

// Get last ID before query
$lastIDBefore = BaseClass::sendQueryStatic($db, "SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1");
$lastIDBefore = !$lastIDBefore ? -1 : $lastIDBefore[0]["user_id"];

// Add user
BaseClass::sendQueryStatic($db, $query, $args, false);

// Get last ID after query
$lastIDAfter = BaseClass::sendQueryStatic($db, "SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1");
$lastIDAfter = !$lastIDAfter ? -1 : $lastIDAfter[0]["user_id"];

// Redirect to login page with error or success code
if ($lastIDBefore == $lastIDAfter) { header("Location: $redirect_path?r_error=".UNKNOWN_REGISTER_ERROR); }
else { header("Location: $redirect_path?r_success=".REGISTRATION_COMPLETE); }

exit;