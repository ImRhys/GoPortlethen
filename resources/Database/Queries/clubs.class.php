<?php

namespace Database\Queries;


class clubs extends \Database\query {

  private $resultsPerPage = 5;
  private $totalPages = 0;
  private $currentPage = 1;

  function __construct(\Database\db $db) {
    $this->setDBHandle($db);
  }

  /**
   * Sets the query with the page number
   */
  public function setPQuery() {

    $startFrom = ($this->getCurrentPage() - 1) * $this->resultsPerPage;

    $extra = "";
    //if genreID is set
    if (isset($_GET['g']) && is_numeric($_GET['g']) && intval($_GET['g']) != 0) {
      $extra =  "WHERE genreID = :genre";
      $this->setParameters([":genre" => intval($_GET['g'])]);
    }

    //if a text search is set
    if (isset($_GET['ts']) && strlen($_GET['ts']) > 0) {
      $extra = strlen($extra) > 0 ? "\nAND" : " WHERE "; //Add our where or and depending on the previous statement size
      $_GET['ts'] = filter_var($_GET['ts'], FILTER_SANITIZE_STRING);
      $extra .= "clubName LIKE :name";
      $arr = $this->getParameters();
      $arr[":name"] = "%" . $_GET['ts'] . "%";
      $this->setParameters($arr);
    }

    $this->setQuery("
      SELECT * FROM club
      $extra
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

    //Set our original query up so we can get the string
    $this->setPQuery();

    //If any of our get vars are set perform some magic or just give us a normal query (without this funky things happen to the pagination)
    if ((isset($_GET['g']) && is_numeric($_GET['g']) && intval($_GET['g']) != 0) || (isset($_GET['ts']) && strlen($_GET['ts']) > 0)) {
      //Get the number of pages by replacing the first astrix with a count expression, a little bit hacky
      $pos = strpos($this->getQuery(), "*");
      if ($pos !== false) {
        $this->setQuery(substr_replace($this->getQuery(), "COUNT(*)", $pos, strlen("*")));
      }
    } else {
      $this->setQuery("SELECT COUNT(*) FROM club");
    }

    echo $this->getQuery();

    $this->runQuery();
    $this->totalPages = ceil(intval($this->getResult()[0]["COUNT(*)"]) / $this->resultsPerPage); //Very crude way, but it works

    print_r($this->getResult());

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
   * @param string $filename PHP filename that the link will be based off of
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
      $out .= '<li ' . (($i + 1) == $this->currentPage ? ' class="active"' : '') . '><a href="' . $filename . \Helper\url::buildMissingGets("page",  ($i + 1)) . '">' . ($i + 1) . '</a></li>';
    }
    return $out;
  }

  /**
   * Get the previous page number
   * @param string $pname page filename
   * @return int previous page number
   */
  public function getPaginationPrevious($pname) {
    return $pname . \Helper\url::buildMissingGets("page", ($this->currentPage < 2 ? 1 : $this->currentPage - 1));
  }

  /**
   * Get the next page number
   * @param string $pname page filename
   * @return int next page number
   */
  public function getPaginationNext($pname) {
    return $pname . \Helper\url::buildMissingGets("page", ($this->currentPage > ($this->totalPages - 1) ? $this->totalPages : $this->currentPage + 1));
  }

  /**
   * Get the last page number
   * @param string $pname page filename
   * @return int last page number
   */
  public function getPaginationLast($pname) {
    return $pname . \Helper\url::buildMissingGets("page", $this->getTotalPages());
  }
}