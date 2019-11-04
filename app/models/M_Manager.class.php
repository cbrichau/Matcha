<?php
/* ************************************************************* *\
    Base for all models to provide Config's paths and
    DB connection, and validity check functions.
\* ************************************************************* */

class M_Manager extends Config
{
  protected $_db;

  /* *********************************************************** *\
      INITILISATION: Gets the connection to the database.
  \* *********************************************************** */

  public function __construct()
  {
    $this->_db = Config::get_db();
  }

  /* *********************************************************** *\
      IS_VALID_xx_FORMAT: Checks input is of the expected format.
  \* *********************************************************** */

  protected function is_valid_string_format($input)
  {
    if ($input != filter_var($input, FILTER_SANITIZE_STRING))
      return FALSE;
    return TRUE;
  }

  protected function is_valid_int_format($input)
  {
    if ($input != filter_var($input, FILTER_SANITIZE_NUMBER_INT) ||
        $input != filter_var($input, FILTER_VALIDATE_INT))
      return FALSE;
    return TRUE;
  }

  protected function is_valid_float_format($input)
  {
    if ($input != filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ||
        $input != filter_var($input, FILTER_VALIDATE_FLOAT))
      return FALSE;
    return TRUE;
  }

  protected function is_valid_email_format($input)
  {
    if ($input != filter_var($input, FILTER_SANITIZE_EMAIL) ||
        $input != filter_var($input, FILTER_VALIDATE_EMAIL))
      return FALSE;
    return TRUE;
  }

  protected function is_valid_url_format($input)
  {
    if ($input != filter_var($input, FILTER_SANITIZE_URL) ||
        $input != filter_var($input, FILTER_VALIDATE_URL))
      return FALSE;
    return TRUE;
  }

  /* *********************************************************** *\
      SANITIZE_FOR_OUTPUT: Ensures user data is safe to output.
  \* *********************************************************** */

  public function sanitize_for_output($input)
  {
    if (is_array($input))
    {
      foreach ($input as $key => $value)
        $input[$key] = htmlspecialchars($value);
      return $input;
    }
    else
      return htmlspecialchars($input);;
  }
}
