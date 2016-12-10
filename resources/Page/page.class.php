<?php

namespace Page;


class page {

  private $header = "";
  private $footer = "";

  private $headerHTML = "";
  private $footerHTML = "";
  private $JSHead = "";
  private $JSFoot = "";
  private $CSS = "";

  private $pageTitle = "";
  private $pageDescription = "";
  private $pageKeywords = "";

  /**
   * Tagifies the passed name into a CSS tag
   * @param string $name CSS filename
   * @param bool $cssDir inside the CSS directory?
   * @return string tagified CSS
   */
  private function toCSSTag($name, $cssDir) {
    return '<link rel="stylesheet" href="' . ($cssDir ? "css/" : "") . $name . '">';
  }

  /**
   * Adds a CSS line to the page header
   * @param string $name CSS filename
   * @param bool|true $cssDir inside the CSS directory?
   */
  public function addCSS($name, $cssDir = true) {
    $this->CSS .= $this->toCSSTag($name, $cssDir);
  }

  /**
   * Tagifies the passed name into a javascript script tag
   * @param string $name Javascript filename
   * @param bool $jsDir inside the Javascript directory?
   * @return string tagified JS
   */
  private function toJSTag($name, $jsDir) {
    return '<script src="' . ($jsDir ? "js/" : "") . $name . '"></script>';
  }

  /**
   * Adds Javascript to the page header
   * @param string $name Javascript filename
   * @param bool|true $jsDir inside the Javascript directory?
   */
  public function addHeaderJS($name, $jsDir = true) {
    $this->JSHead .= $this->toJSTag($name, $jsDir);
  }

  /**
   * Adds Javascript to the page footer
   * @param string $name Javascript filename
   * @param bool|true $jsDir inside the Javascript directory?
   */
  public function addFooterJS($name, $jsDir = true) {
    $this->JSFoot .= $this->toJSTag($name, $jsDir);
  }

  /**
   * Adds raw HTML to the page header
   * @param string $html
   */
  public function addHeaderHTML($html) {
    $this->headerHTML .= $html;
  }

  /**
   * Adds raw HTML to the page footer
   * @param string $html
   */
  public function addFooterHTML($html) {
    $this->footerHTML .= $html;
  }

  /**
   * Sets the page title
   * @param string $title
   */
  public function setPageTitle($title) {
    $this->pageTitle = $title;
  }

  /**
   * Gets the page title
   */
  public function getPageTitle() {
    $this->pageTitle;
  }

  /**
   * Sets the page description
   * @param string $description
   */
  public function setPageDescription($description) {
    $this->pageDescription = $description;
  }

  /**
   * Gets the page description
   * @return string
   */
  public function getPageDescription() {
    return $this->pageDescription;
  }

  /**
   * Sets the page keywords
   * @param string $keywords comma separated list of keywords
   */
  public function setPageKeywords($keywords) {
    $this->pageKeywords = $keywords;
  }

  /**
   * Gets all the page keywords
   * @return string comma separated list of keywords
   */
  public function getPageKeywords() {
    return $this->pageKeywords;
  }

  /**
   * Builds the header with all the set values ready for echo
   */
  public function renderHeader() {
    $this->header =
      '<!DOCTYPE html>' .
      '<html>' .
      '<head>' .
      ($this->pageTitle !== "" ? '<title>' . $this->pageTitle . '</title>' : "" ) .
      ($this->pageDescription !== "" ? '<meta name="description" content="' . $this->pageDescription . '">' : "") .
      ($this->pageKeywords !== "" ? '<meta name="keywords" content="' . $this->pageKeywords . '">' : "") .
      $this->CSS .
      $this->JSHead .
      $this->header .
      '</head>' .
      '<body>';
  }

  /**
   * Echoes the header
   */
  public function echoHeader() {
    echo $this->header;
  }

  /**
   * Builds the footer with all set values ready for echo
   */
  public function renderFooter() {
    $this->footer =
      $this->footerHTML .
      $this->JSFoot .
      '</body>' .
      '</html>';
  }

  /**
   * Echoes the footer
   */
  public function echoFooter() {
    echo $this->footer;
  }

}