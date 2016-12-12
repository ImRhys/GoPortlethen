<?php

namespace Helper;


class hash {

  private $plain = "";
  private $hash = "";
  private $salt = "";
  private $pair = "";

  private function createHashSaltPair($str, $salt) {
    return $str . $salt;
  }

  private function hashPassword($str, $salt) {
    return hash('sha256', $str . $salt);
  }

  private function generateSalt() {
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $out = '';
    for ($i = 0; $i < 36; $i++) {
      $out .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $out;
  }

  /**
   * Set plain text password
   * @param string $str plain text password
   */
  public function setPlain($str) {
    $this->plain = $str;
  }

  /**
   * Get plain text password
   * @return string plain text password
   */
  public function getPlain() {
    return $this->plain;
  }

  /**
   * Set salt
   * @param string $str salt
   */
  public function setSalt($str) {
    $this->salt = $str;
  }

  /**
   * Get salt
   * @return string salt
   */
  public function getSalt() {
    return $this->salt;
  }

  /**
   * Generate salt into set field
   */
  public function genSalt() {
    $this->salt = $this->generateSalt();
  }

  /**
   * Set the hash into set field
   * @param string $hash
   */
  public function setHash($hash) {
    $this->hash = $hash;
  }

  /**
   * Generate hash from set fields
   */
  public function genHash() {
    $this->hash = $this->hashPassword($this->plain, $this->salt);
  }

  /**
   * Get hash from set field
   * @return string hash
   */
  public function getHash() {
    return $this->hash;
  }

  /**
   * Generate pair into set field
   */
  public function genPair() {
    $this->pair = $this->createHashSaltPair($this->hash, $this->salt);
  }

  /**
   * Set pair
   * @param string $pair
   */
  public function setPair($pair) {
    $this->pair = $pair;
  }

  /**
   * Get pair from set field
   * @return string pair
   */
  public function getPair() {
    return $this->pair;
  }

  /**
   * Split a combined pair into hash and salt -> set fields
   */
  public function splitHashSalt() {
    $this->hash = substr($this->pair, 0, 64);
    $this->salt = substr($this->pair, 64);
  }

}