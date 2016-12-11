<?php

namespace Database\Queries;


class clubs extends \Database\query {

  private $resultsPerPage = 5;
  private $totalPages = 0;

  function __construct(\Database\db $db) {
    $this->setDBHandle($db);
    $this->setPQuery(1);
  }

  /**
   * Sets the query with the page number
   * @param int $page page number
   */
  public function setPQuery($page) {

    $startFrom = ($page - 1) * $this->resultsPerPage;

    $this->setQuery("
      SELECT * FROM club
      ORDER BY clubName ASC
      LIMIT $startFrom, $this->resultsPerPage
    ");
  }

  public function easyRun() {
    //Read the get page var
    if (isset($_GET["page"])) {
      $page = $_GET["page"];
    } else {
      $page = 1;
    };

    //Die if we're not being passed a number
    if (!is_numeric($page)) {
      die("Invalid page selection.");
    }

    //Get the number of pages
    $this->setQuery("SELECT COUNT(*) FROM club");
    $this->runQuery();
    $this->totalPages = ceil(intval($this->getResult()[0]["COUNT(*)"]) / $this->resultsPerPage); //Very crude way, but it works

    //Set out main query and run
    $this->setPQuery($page);
    $this->runQuery();
  }

  /**
   * Sets the current page number
   * @param int $page current page
   */
  public function setCurrentPage($page) {
    $this->currentPage;
  }

  /**
   * Gets the current page number
   * @return int current page
   */
  public function getCurrentPage() {
    return $this->currentPage;
  }

  /**
   * Get the number of results per page
   * @return int Results per page
   */
  public function getResultsPerPage() {
    return $this->resultsPerPage;
  }

  /**
   * Get the total number of pages
   * @return int total pages
   */
  public function getTotalPages() {
    return $this->totalPages;
  }

  /**
   * Generate the li link tags for pagination
   * @param $filename PHP filename that the link will be based off of
   * @return string li link tags
   */
  public function generatePaginationLinks($filename) {
    $out = "";
    for ($i = 0; $i < $this->totalPages; $i++) {
      $out .= '<li><a href="' . $filename . '?page=' . ($i + 1) . '">' . ($i + 1) . '</a></li>';
    }
    return $out;
  }
}