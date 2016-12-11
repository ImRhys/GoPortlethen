<?php

namespace Helper;


class url {


  public static function buildMissingGets($varName, $value) {
    $tmp = $_GET;
    $tmp[$varName] = $value;

    $out = "";
    foreach ($tmp as $key => $value) {
      $out .= $key . "=" . htmlspecialchars($value) . "&";
    }

    $out = substr($out, -1) === "&" ? substr($out, 0, -1) : $out;

    return "?" . $out;
  }

}