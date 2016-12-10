<?php

namespace Database;

use \PDO;
use \Config\Config as Config;


class db {

  public $db;

  public function __construct($dbname = "") {

    $config = new Config();
    $debug = $config->get("debug");

    if ($debug) {
      //If we're using a local database in debug mode
      $ahost = "changeme";
      $adbname = "changeme";
      $auser = "changeme";
      $apass = "changeme";

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

    //If we pass a database name use that, else use whatever Azure gives us
    if (!isset($dbname)) {
      $adbname = $dbname;
    }

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
      die("Failed to connect to the database " . ($debug ? $ex->getMessage() : ""));
    }
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    //Set our database handle
    $this->db = $db;
  }

  public function getHandle() {
    return $this->db;
  }

}