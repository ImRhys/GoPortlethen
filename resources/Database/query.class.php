<?php

namespace Database;

use \Config\Config as Config;

class query {

  private $parameters;
  private $query;
  private $db;
  private $result;
  public $config;

  /**
   * Execute the SQL Query
   */
  public function runQuery() {
    $stmt = $this->db->prepare($this->query);
    $stmt->execute($this->parameters);
    $this->result = $stmt->fetch();
  }

  /**
   * Get the result of the query
   * @return mixed
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
   * Set database handle
   * @param db $db database handle
   */
  public function setDBHandle(db $db) {
    $this->db = $db;
  }
}