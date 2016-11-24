<?php

namespace Database;


class query {

    private $parameters;
    private $query;
    private $db;

    private $result;

    public function runQuery() {
        $stmt = $this->db->prepare($this->query);
        $stmt->execute($this->parameters);
        $this->result = $stmt->fetch();
    }

    public function getResult() {
        return $this->result;
    }

    public function setParameters(Array $parameters) {
        $this->parameters = $parameters;
    }

    public function getParameters() {
        return $this->parameters;
    }

    public function setQuery($query) {
        $this->query = $query;
    }

    public function setDBHandle(db $db) {
        $this->db = $db;
    }
}