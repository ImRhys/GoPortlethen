<?php

namespace Page;


class admin extends page {

  private $filen = "";

  /**
   * Check login
   */
  public function checkLogin() {
    //if we're not logged in redirect us
    if (empty($_SESSION['user'])) {
      header("Location: login.php?loginfailed=1");
      die("Access denied.");
    }
  }

  /**
   * Set running filename, e.g index.php
   * @param string $filen filename
   */
  public function setFilename($filen) {
    $this->filen = $filen;
  }

  /**
   * Get running filename
   * @return string filename
   */
  public function getFilename() {
    return $this->filen;
  }
}