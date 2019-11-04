<?php
/* ******************************************************************* *\
    Sets variable elements of the template (V_Header.php).
\* ******************************************************************* */

class Output extends Config
{
  private $_head_title; // <head><title> field.
  private $_page_name; // <main id="name"> for page-specific css.

  /* **************************** *\
    SETTERS
  \* **************************** */

  public function set_head_title($title)
  {
    if (is_string($title))
      $this->_head_title = $title;
  }

  public function set_page_name($name)
  {
    $this->_page_name = $name;
  }

  /* **************************** *\
    GETTERS
  \* **************************** */

  public function get_head_title()  { return $this->_head_title; }
  public function get_page_name()   { return $this->_page_name; }
}
