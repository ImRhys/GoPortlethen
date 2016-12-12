<?php

namespace Database;

use \Config\Config as Config;

class query {

  public $parameters;
  public $query;
  public $db;
  public $result;

  public $stmt;

  function __construct(db $db) {
    $this->setDBHandle($db);
  }

  /**
   * Execute the SQL Query
   */
  public function runQuery() {
    $stmt = $this->db->prepare($this->query);
    $stmt->execute($this->parameters);
    $this->result = $stmt->fetchall();
    $this->stmt = $stmt;
  }

  /**
   * Get the result of the query
   * @return array
   */
  public function getResult() {
    return $this->result;
  }

  /**
   * Set query parameters
   * @param array $parameters query parameters
   */
  public function setParameters(Array $parameters) {
    $this->parameters = $parameters;
  }

  /**
   * Get query parameters
   * @return array query parameters
   */
  public function getParameters() {
    return $this->parameters;
  }

  /**
   * Set query statement
   * @param String $query query statement
   */
  public function setQuery($query) {
    $this->query = $query;
  }

  /**
   * Get the current set query
   * @return string query
   */
  public function getQuery() {
    return $this->query;
  }

  /**
   * Set database handle
   * @param db $db database handle
   */
  public function setDBHandle(db $db) {
    $this->db = $db->getHandle();
  }

  /**
   * Perform a quick one line query
   * @param string $query Query string
   * @param array $parameters Parameter Array
   * @return array result
   */
  public function quickQuery($query, $parameters) {
    $this->setQuery($query);
    $this->setParameters($parameters);
    $this->runQuery();
    return $this->getResult();
  }
}