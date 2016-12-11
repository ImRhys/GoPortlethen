<?php

namespace Database;

use \PDO;
use \Config\Config as Config;


class db {

  public $db;
  public $debug;

  function __construct($dbname = "") {

    $this->debug = Config::get("debug");
    unset($config);

    if ($this->debug) {
      //If we're using a local database in debug mode
      $ahost = "127.0.0.1";
      $adbname = "test";
      $auser = "root";
      $apass = "";

    } else {
      //create an Azure connection from the system var we're given
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
    }

    echo $ahost . " " . $adbname . " " . $auser . " " . $apass;

    //If we pass a database name use that, else use whatever Azure gives us
    if (!isset($dbname)) {
      $adbname = $dbname;
    }

    //Add the database name into the config array for access by other things
    Config::add("dbname", $adbname);

    //Set up PDO
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    try {
      $db = new PDO(
        "mysql:host=" . $ahost . ";" .
        "dbname=" . $adbname . ";" .
        "charset=utf8",
        $auser,
        $apass,
        $options
      );
    } catch (PDOException $ex) {
      //Fail if we can't connect and/or display a message if we're in debug mode
      die("Failed to connect to the database " . ($this->debug ? $ex->getMessage() : ""));
    }
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    //Set our database handle
    $this->db = $db;
  }

  /**
   * Get the PDO handle
   * @return PDO database handle
   */
  public function getHandle() {
    return $this->db;
  }

}