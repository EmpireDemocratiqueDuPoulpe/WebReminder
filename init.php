<?php

########################################
# Const
########################################

define("PROJECT", "webreminder");
define("ROOT", ($_SERVER['DOCUMENT_ROOT'] . "/" . PROJECT));

/***************************************
 *  Registration/login errors code [00 --> 50]:
 *
 *      - 00 -> 19:     Missing/empty field
 *      - 20:           Username not valid
 *      - 21:           Username already exist
 *      - 22:           Email not valid
 *      - 23:           Email already used
 *      - 24:           Passwords are not the same
 *      - 25:           Passwords aren't valid/secure
 *      - 26:           Phone number isn't valid
 *      - 50:           Unknown error
 ***************************************/

define("USR_NOT_VALID", 20);
define("USR_ALREADY_USED", 21);

define("EMAIL_NOT_VALID", 22);
define("EMAIL_ALREADY_USED", 23);

define("PASSWORDS_DIFFERENT", 24);
define("PASSWORDS_NOT_VALID", 25);

define("TEL_NOT_VALID", 26);

define("UNKNOWN_REG_LOG_ERROR", 50);

/***************************************
 *  Registration success code:
 *
 *      - 00:     Registration complete
 ***************************************/

define("REGISTRATION_COMPLETE", 0);

########################################
# Session
########################################

if (session_status() != PHP_SESSION_ACTIVE) { session_start(); }

########################################
# Config
########################################

$config = parse_ini_file(ROOT."/assets/config/config.ini", true);

########################################
# Load classes and functions
########################################

// Classes
function loadClasses($classname) {

    require_once ROOT."/classes/$classname.php";
}

spl_autoload_register("loadClasses");

// Functions
require_once ROOT."/php/functions.php";

########################################
# Database connection
########################################

$db = PDOFactory::getMySQLConnection($config["DB"]["host"], $config["DB"]["dbname"], $config["DB"]["username"], $config["DB"]["passwd"]);