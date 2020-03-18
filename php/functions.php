<?php

/**
 * check_post_vars - Check if POST vars exists.
 *
 * @param   array   $vars           Array of string which contains vars names
 * @param   boolean $check_empty    Need to check if vars are empty?
 * @return  array                   True or false and the missing var name if false
 * @access  public
 */
function check_post_vars($vars = [], $check_empty = true) {

    foreach ($vars as $var) {

        // Check if var is set
        if (!isset($_POST["$var"])) { return ["exist" => false, "var_name" => $var]; }

        // Check if var is not empty
        if ($check_empty AND empty($_POST["$var"])) { return ["exist" => false, "var_name" => $var]; }
    }

    return ["exist" => true, "var_name" => null];
}

function input_errors($key, $error_codes) {

    // Check if there is an error
    if (!isset($_GET["$key"])) { return false; }

    // Check if the error codes are the same
    foreach ($error_codes as $code) {

        if ($_GET["$key"] == $code) {

            echo "inputErr";
            return true;
        }
    }

    // Return false if there's no error with this code
    return false;
}