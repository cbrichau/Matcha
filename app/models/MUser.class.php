<?php
/* ******************************************************************* *\
    MUser defines a User through:
    - id_user, email, username  --> unique identifiers.
    - first_name, last_name     --> personal identifiers.
    - password                  --> encrypted or not.
    - email_confirmed           --> contains a validation code or TRUE.
\* ******************************************************************* */

class MUser extends M_Manager
{
  private $_id_user;
  private $_email;
  private $_email_confirmed; ////////// should be $_account_confirmed since used for email and pw reset confirmation
  private $_username;
  private $_first_name;
  private $_last_name;
  private $_date_of_birth;
  private $_age;
  private $_password;
  private $_last_activity;
  private $_location; // "Latitude Longitude"
  private $_gender;
  private $_popularity_score;
  private $_bio;
  private $_interests;
  private $_profile_pics;
  private $_seeked_gender;
  private $_seeked_age_min;
  private $_seeked_age_max;
  private $_seeked_distance;
  private $_seeked_popularity_range;
  private $_seeked_interests;

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

  public function update_user_info(MUser $user, array $data)
  {
    foreach ($data as $key => $value)
    {
      $method = 'set_'.$key;
      if (method_exists($this, $method))
        $user->$method($value);
    }
  }

  public function encrypt_and_set_password($pw)
  {
    $encrypted_pw = hash('whirlpool', $pw);
    $this->set_password($encrypted_pw);
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
  public function get_email_confirmed()  { return $this->_email_confirmed; }
  public function get_username()         { return $this->_username; }
  public function get_first_name()       { return $this->_first_name; }
  public function get_last_name()        { return $this->_last_name; }
  public function get_date_of_birth()    { return $this->_date_of_birth; }
  public function get_age()              { return $this->_age; }
  public function get_password()         { return $this->_password; }
  public function get_last_activity()    { return $this->_last_activity; }
  public function get_location()         { return $this->_location; }
  public function get_gender()           { return $this->_gender; }
  public function get_popularity_score() { return $this->_popularity_score; }
  public function get_bio()              { return $this->_bio; }
  public function get_interests()        { return $this->_interests; }
  public function get_profile_pics($i)
  {
    if ($i === 'all')
      return $this->_profile_pics;
    else
      return $this->_profile_pics[$i];
  }
  public function get_seeked_gender()           { return $this->_seeked_gender; }
  public function get_seeked_age_min()          { return $this->_seeked_age_min; }
  public function get_seeked_age_max()          { return $this->_seeked_age_max; }
  public function get_seeked_distance()         { return $this->_seeked_distance; }
  public function get_seeked_popularity_range() { return $this->_seeked_popularity_range; }
  public function get_seeked_interests()        { return $this->_seeked_interests; }

  /* ******************************************************** *\
      SETTERS
  \* ******************************************************** */

  /* --------------- User "self" properties --------------- */

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

  public function set_email_confirmed($arg)
  {
    $this->_email_confirmed = $arg;
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

  public function set_date_of_birth($arg)
  {
        //if is valid date format
    $this->_date_of_birth = $arg;
    $this->set_age();
  }

  public function set_age()
  {
        // if _dob is valid date
    $now = time();
    $dob = strtotime($this->_date_of_birth);
    $this->_age = floor(($now - $dob) / 31556926);
  }

  public function set_password($arg)
  {
    $this->_password = $arg;
  }

  public function set_last_activity($arg)
  {
        //if is valid datetime format
    $this->_last_activity = $arg;
  }

  public function set_location($arg)
  {
    list($latitude, $longitude) = explode(' ', $arg);
    if ($this->is_valid_float_format($latitude) &&
        $this->is_valid_float_format($longitude))
    $this->_location = $latitude.' '.$longitude;
  }

  public function set_gender($arg)
  {
    $this->_gender = NULL;
    if (in_array($arg, array('F', 'M')))
      $this->_gender = $arg;
  }

  public function set_popularity_score($arg)
  {
    if ($this->is_valid_int_format($arg))
      $this->_popularity_score = $arg;
  }

  public function set_bio($arg)
  {
    if ($this->is_valid_string_format($arg))
      $this->_bio = $arg;
  }

  public function set_interests($arg)
  {
    if (preg_match('/^((\d+)(-{0,1}))+$/', $arg))
      $this->_interests = $arg;
  }

  public function set_profile_pics()
  {
    $this->_profile_pics = glob(Config::IMAGES_PATH.'profile_pictures/'.$this->_id_user.'-[1-5].jpg');
    if (empty($this->_profile_pics))
      $this->_profile_pics[0] = Config::IMAGES_PATH.'profile_pictures/0default.jpg';
  }

  public function set_seeked_gender($arg)
  {
    $this->_seeked_gender = NULL;
    if (in_array($arg, array('F', 'M')))
      $this->_seeked_gender = $arg;
  }

  public function set_seeked_age_min($arg)
  {
    if ($this->is_valid_int_format($arg))
      $this->_seeked_age_min = $arg;
  }

  public function set_seeked_age_max($arg)
  {
    if ($this->is_valid_int_format($arg))
      $this->_seeked_age_max = $arg;
  }

  public function set_seeked_distance($arg)
  {
    if ($this->is_valid_int_format($arg))
      $this->_seeked_distance = $arg;
  }

  public function set_seeked_popularity_range($arg)
  {
    if ($this->is_valid_int_format($arg))
      $this->_seeked_popularity_range = $arg;
  }

  public function set_seeked_interests($arg)
  {
    if (preg_match('/^((\d+)(-{0,1}))+$/', $arg))
      $this->_seeked_interests = $arg;
  }
}
