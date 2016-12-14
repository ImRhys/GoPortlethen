<?php

namespace Database\Queries;


class user extends \Database\query {

  function __construct(\Database\db $db) {
    $this->setDBHandle($db);
  }

  /**
   * @Override
   * Execute the SQL Query with fetch
   */
  public function runQuery() {
    $stmt = $this->db->prepare($this->query);
    $stmt->execute($this->parameters);
    $this->result = $stmt->rowCount();
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

  public function checkUsernameAndEmailExists($username, $email, \Database\db $db) {
    $qq = new user($db);
    $qq->quickQuery("SELECT * FROM users WHERE userName = :username OR emailAddress = :email", [":username" => $username, ":email" => $email]);
    if ($qq->getResult() > 0) {
      die("Username or Email Address already taken");
    }
  }
  
  public function checkUsernameExists($username, \Database\db $db) {
	$this->checkUsernameAndEmailExists($username, "", $db);
  }
  
  public function checkEmailExists($email, \Database\db) {
    $this->checkUsernameAndEmailExists("", $email, $db);
  }

}