<?php

/**
 * PDOFactory - Connect to a database using the appropriate function for the SGBDR.
 *
 * Example:
 * $db = PDOFactory::getMySQLConnection("localhost", "web_reminder", "root", "");
 *
 * @author      Alexis <293287 @ supinfo.com>
 * @version     1.0
 * @access      public
 */
class PDOFactory {

    /**
     * getMySQLConnection - Connect to a MySQL/MariaDB database.
     *
     * @param   string  $host       MySQL/MariaDB server hostname or ip
     * @param   string  $dbname     Database name
     * @param   string  $username   MySQL/MariaDB username
     * @param   string  $passwd     MySQL/MariaDB password
     * @return  PDO                 PDO object connected to a MySQL/MariaDB database.
     * @access  public
     */
    public static function getMySQLConnection($host, $dbname, $username, $passwd) {

        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $passwd);
        // RETIRER AVANT MISE EN LIGNE
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // RETIRER AVANT MISE EN LIGNE

        return $db;
    }
}