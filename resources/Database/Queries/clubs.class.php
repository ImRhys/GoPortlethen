<?php

namespace Database\Queries;


class clubs extends \Database\query {

  private $resultsPerPage = 5;
  private $totalPages = 0;
  private $currentPage = 1;

  function __construct(\Database\db $db) {
    $this->setDBHandle($db);
    $this->setPQuery(1);
  }

  /**
   * Sets the query with the page number
   */
  public function setPQuery() {

    $startFrom = ($this->getCurrentPage() - 1) * $this->resultsPerPage;

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

    //Set current page
    $this->currentPage = $page;

    //Get the number of pages
    $this->setQuery("SELECT COUNT(*) FROM club");
    $this->runQuery();
    $this->totalPages = ceil(intval($this->getResult()[0]["COUNT(*)"]) / $this->resultsPerPage); //Very crude way, but it works

    //Set out main query and run
    $this->setPQuery();
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
    $start = 0;
    $end = $this->getTotalPages();

    $startPad = 3;
    $endPad = 2;
    $toDisplay = 5;

    //If we have more than 5 pages, start displaying in a compact way
    if ($this->totalPages > 5) {
      //Make sure our end marker doesn't exceed the limit of the total page number
      if ($this->getCurrentPage() + $endPad < $this->getTotalPages()) {
        $end = $this->getCurrentPage() + $endPad;
      } else {
        $end = $this->getTotalPages();
      }

      //Make sure the pageination doesn't go wobbly after we click next a few times
      if ($this->getCurrentPage() - $startPad > 0) {
        $start = $this->getCurrentPage() - $startPad;
      } else {
        $end += $startPad - $this->getCurrentPage();
        $start = 0;
      }

      //Always keep 5 numbers on the pageination so it doesn't jump around
      if ($end - $start < $toDisplay) {
        $start = (($end - $toDisplay) < 0 ? 0 : ($end - $toDisplay)); //Don't correct less than zero
      }
    }

    //Build our li link tags
    for ($i = $start; $i < $end; $i++) {
      $out .= '<li ' . (($i + 1) == $this->currentPage ? ' class="active"' : '') . '><a href="' . $filename . '?page=' . ($i + 1) . '">' . ($i + 1) . '</a></li>';
    }
    return $out;
  }

  /**
   * Get the previous page number
   * @return int previous page number
   */
  public function getPaginationPrevious() {
    return ($this->currentPage < 2 ? 1 : $this->currentPage - 1);
  }

  /**
   * Get the next page number
   * @return int next page number
   */
  public function getPaginationNext() {
    return ($this->currentPage > ($this->totalPages - 1) ? $this->totalPages : $this->currentPage + 1);
  }

  /**
   * Get the last page number
   * @return int last page number
   */
  public function getPaginationLast() {
    return $this->getTotalPages();
  }
}