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

  /**
   * Get the form starting tag
   * @param string $location filename the form posts to
   * @param string $id set form ID
   * @return string form markup
   */
  public function startForm($location, $id = "") {
    return '<form ' . ($id !== "" ? 'id="' . $id . '"' : "") . ' action="' . $location . '" method="post">';
  }

  /**
   * Get the form ending tag
   * @return string form ending tag
   */
  public function  endForm() {
    return '</form>';
  }
}