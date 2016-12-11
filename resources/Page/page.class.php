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

  private $title = "";
  private $description = "";
  private $keywords = "";

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
    $this->title = $title;
  }

  /**
   * Gets the page title
   */
  public function getPageTitle() {
    $this->title;
  }

  /**
   * Sets the page description
   * @param string $description
   */
  public function setPageDescription($description) {
    $this->description = $description;
  }

  /**
   * Helper function to set all important meta tags at once
   * @param string $title page title
   * @param string $description page description
   * @param string $keywords comma seperated page keywords
   */
  public function setAllMeta($title, $description, $keywords) {
    $this->title = $title;
    $this->description = $description;
    $this->keywords = $keywords;
  }

  /**
   * Gets the page description
   * @return string
   */
  public function getPageDescription() {
    return $this->description;
  }

  /**
   * Sets the page keywords
   * @param string $keywords comma separated list of keywords
   */
  public function setPageKeywords($keywords) {
    $this->keywords = $keywords;
  }

  /**
   * Gets all the page keywords
   * @return string comma separated list of keywords
   */
  public function getPageKeywords() {
    return $this->keywords;
  }

  /**
   * Builds the header with all the set values ready for echo
   */
  public function renderHeader() {
    $this->header =
      '<!DOCTYPE html>' .
      '<html>' .
      '<head>' .
      ($this->title !== "" ? '<title>' . $this->title . '</title>' : "" ) .
      ($this->description !== "" ? '<meta name="description" content="' . $this->description . '">' : "") .
      ($this->keywords !== "" ? '<meta name="keywords" content="' . $this->keywords . '">' : "") .
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