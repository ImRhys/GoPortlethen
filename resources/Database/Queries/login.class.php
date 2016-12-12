<?php

namespace Database\Queries;


class login extends \Database\query {
  /**
   * @Override
   * Execute the SQL Query with fetch
   */
  public function runQuery() {
    $stmt = $this->db->prepare($this->query);
    $stmt->execute($this->parameters);
    $this->result = $stmt->fetch();
    $this->stmt = $stmt;
  }

  /**
   * @Override
   *
   * (Unsure if the superfunction will be called instead of our custom one)
   *
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