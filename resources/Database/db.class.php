<?php

namespace Database;


class db {

    public $db;

    public function __construct() {
        $ahost = '';
        $adbname = '';
        $auser = '';
        $apass = '';

        foreach ($_SERVER as $key => $value) {
            if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
                continue;
            }
            $ahost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
            $adbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
            $auser = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
            $apass = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
        }

        define('DB_NAME', $adbname);
        define('DB_USER', $auser);
        define('DB_PASSWORD', $apass);
        define('DB_HOST', $ahost);


        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        try {
            $db = new PDO(
                "mysql:host=". DB_HOST . ";" .
                "dbname=test;" .
                "charset=utf8",
                DB_USER,
                DB_PASSWORD,
                $options
            );
        } catch (PDOException $ex) {
            die("Failed to connect to the database: " . $ex->getMessage());
        }
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $this->db = $db;
    }

    public function getHandle() {
        return $this->db;
    }

}