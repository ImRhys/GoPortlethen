<?php

namespace Page;


class admin extends page {

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
}