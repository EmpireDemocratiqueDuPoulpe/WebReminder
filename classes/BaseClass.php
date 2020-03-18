<?php

/**
 * BaseClass - Base of almost every class.
 *
 * @author      Alexis <293287 @ supinfo.com>
 * @version     1.0
 * @access      protected
 */
abstract class BaseClass {

    /** @property   PDO     $_db    PDO connection to the db */
    private $_db;

    /**
     * Constructor - Init class with PDO object connected to the database.
     *
     * @param   PDO     $db     PDO connection to the db
     * @access  public
     */
    public function __construct(PDO $db) { $this->setDB($db); }

    /**
     * sendQuery - Prepare and send query.
     *
     * @param   string      $sql                    SQL query to execute
     * @param   array       $vars        optional   List of vars to add (if necessary)
     * @param   bool        $return      optional   Return result ? (eg: False when "INSERT INTO")
     * @return  array|void                          Result of query or nothing.
     * @access  protected
     */
    protected function sendQuery($sql, $vars = [], $return = true) {

        $result = [];

        // Prepare query
        $req = $this->_db->prepare($sql);

        // Add vars.
        if ($vars != 0) {

            foreach ($vars as $key => $value) {

                // Get type of data
                if (gettype($value) === "integer") $type = PDO::PARAM_INT;
                else $type = PDO::PARAM_STR;

                // Add var
                $req->bindValue(":".$key, $value, $type);
            }
        }

        // Send query and get data if $return is true
        $req->execute();
        if ($return) {while ($data = $req->fetch(PDO::FETCH_ASSOC)) {$result[] = $data;}}

        // Close cursor and return data if $return is true
        $req->closeCursor();
        if ($return) {return $result;}
    }

    /**
     * sendQueryStatic - Prepare and send query (same as sendQuery but static).
     *
     * @param   PDO         $db                     PDO connection to the db
     * @param   string      $sql                    SQL query to execute
     * @param   array       $vars        optional   List of vars to add (if necessary)
     * @param   bool        $return      optional   Return result ? (eg: False when "INSERT INTO")
     * @return  array|void                          Result of query or nothing.
     * @access  protected
     */
    static public function sendQueryStatic($db, $sql, $vars = [], $return = true) {

        $result = [];

        // Prepare query
        $req = $db->prepare($sql);

        // Add vars.
        if ($vars != 0) {

            foreach ($vars as $key => $value) {

                // Get type of data
                if (gettype($value) === "integer") $type = PDO::PARAM_INT;
                else $type = PDO::PARAM_STR;

                // Add var
                $req->bindValue(":".$key, $value, $type);
            }
        }

        // Send query and get data if $return is true
        $req->execute();
        if ($return) {while ($data = $req->fetch(PDO::FETCH_ASSOC)) {$result[] = $data;}}

        // Close cursor and return data if $return is true
        $req->closeCursor();
        if ($return) {return $result;}
    }

    // Setters

    /**
     * setDB - Set the PDO object of the class.
     *
     * @param   PDO     $db     PDO connection to the db
     * @access  public
     */
    public function setDB($db) { if ($db instanceof PDO) $this->_db = $db; }

    // Getters

    /**
     * getDB - Return the PDO object of the class.
     *
     * @return  PDO     PDO object connected to the db
     * @access  public
     */
    public function getDB() { return $this->_db; }
}