<?php
/* ******************************************************************* *\
    MUser defines a User through:
    - id_user, email, username  --> unique identifiers.
    - first_name, last_name     --> personal identifiers.
    - password                  --> encrypted or not.
    - email_confirmed           --> contains a validation code or TRUE.
\* ******************************************************************* */



/*
modify setup and check accordingly:

min/max lengths:
email b@x.c 5 255
username  2 50
names 1 255

*/

class MUser extends M_Manager
{
  private $_id_user;
  private $_email;
  private $_username;
  private $_first_name;
  private $_last_name;
  private $_password;
  private $_email_confirmed;

  /* ******************************************************** *\
      INITILISATION
  \* ******************************************************** */

  public function __construct(array $data)
	{
		if(!empty($data))
      $this->hydrate($data);
	}

  private function hydrate(array $data)
  {
    foreach ($data as $key => $value)
    {
      $method = 'set_'.$key;
      if (method_exists($this, $method))
        $this->$method($value);
    }
  }

  /* ******************************************************** *\
      CUSTOM FUNCTIONS
  \* ******************************************************** */

  public function encrypt_and_set_password($pw)
  {
    $encrypted_pw = hash('whirlpool', $pw);
    $this->set_password($encrypted_pw);
  }

  public function update_user_info(MUser $user, array $data)
  {
    foreach ($data as $key => $value)
    {
      $method = 'set_'.$key;
      if (method_exists($this, $method))
        $user->$method($value);
    }
    return $user;
  }

  /* ******************************************************** *\
      GETTERS
  \* ******************************************************** */

  public function get_all_properties()
  {
    $props = get_object_vars($this);
    foreach ($props as $key => $value)
    {
      $new_key = substr($key, 1);
      $properties[$new_key] = $value;
    }
    return $properties;
  }
  public function get_id_user()          { return $this->_id_user; }
  public function get_email()            { return $this->_email; }
  public function get_username()         { return $this->_username; }
  public function get_first_name()       { return $this->_first_name; }
  public function get_last_name()        { return $this->_last_name; }
  public function get_password()         { return $this->_password; }
  public function get_email_confirmed()  { return $this->_email_confirmed; }

  /* ******************************************************** *\
      SETTERS
  \* ******************************************************** */

  public function set_id_user($arg)
  {
    if ($this->is_valid_int_format($arg))
      $this->_id_user = $arg;
  }

  public function set_email($arg)
  {
    if ($this->is_valid_email_format($arg))
      $this->_email = $arg;
  }

  public function set_username($arg)
  {
    if ($this->is_valid_string_format($arg))
      $this->_username = $arg;
  }

  public function set_first_name($arg)
  {
    if ($this->is_valid_string_format($arg))
      $this->_first_name = $arg;
  }

  public function set_last_name($arg)
  {
    if ($this->is_valid_string_format($arg))
      $this->_last_name = $arg;
  }

  public function set_password($arg)
  {
    $this->_password = $arg;
  }

  public function set_email_confirmed($arg)
  {
    $this->_email_confirmed = $arg;
  }
}
