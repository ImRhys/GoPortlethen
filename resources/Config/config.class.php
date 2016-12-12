<?php

namespace Config;


class Config {
  private static $configarr = array(
    "sitename" => "GoPortlethen",
    "debug" => true,
    "dbname" => "", //Set in db.class.php
    "displayerror" => false,
    "copyrightyear" => "2016"
  );

  /**
   * Get a value from the config array with passed key
   * @param $key array key
   * @return mixed array value for key
   */
  public static function get($key) {
    if (isset(Config::$configarr[$key])) {
      return Config::$configarr[$key];
    }
  }

  /**
   * Add a key and value in the config array
   * @param $key array key
   * @param $value array value
   */
  public static function add($key, $value) {
    Config::$configarr[$key] = $value;
  }

  /**
   * Returns the entire config array
   * @return array config aray
   */
  public static function getAll() {
    return Config::$configarr;
  }
}