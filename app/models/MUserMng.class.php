<?php
/* ************************************************************** *\
    MUserMng manages User through:
    - SELECT, ADD, UPDATE, DELETE functions (DB manipulations).
    - REGISTER, LOGIN, LOGOUT, RESET_PASSWORD (user connections).
    - CHECK_context_values functions (checkers for posted data).
\* ************************************************************** */

class MUserMng extends M_Manager
{
  /* *********************************************************** *\
      SELECT, ADD, UPDATE, DELETE functions
  \* *********************************************************** */

  public function select_user_by($key, $value)
  {
    if (in_array($key, array('id_user', 'email', 'username')) && isset($value))
    {
      if ($key == 'id_user')
      {
        $sql = 'SELECT * FROM users WHERE id_user = :value';
        $query = $this->_db->prepare($sql);
        $query->bindValue(':value', $value, PDO::PARAM_INT);
      }
      else
      {
        $sql = 'SELECT * FROM users WHERE '.$key.' = :value';
        $query = $this->_db->prepare($sql);
        $query->bindValue(':value', $value, PDO::PARAM_STR);
      }
      $query->execute();

      $r = $query->fetch();
      if (isset($r['id_user']))
        return new MUser($r);
    }
    return NULL;
  }

  public function select_user_interests(MUser $user)
  {
    $sql = 'SELECT id_interest
            FROM users_interests
            WHERE id_user = :id_user';
    $query = $this->_db->prepare($sql);
    $query->bindValue(':id_user', $user->get_id_user(), PDO::PARAM_INT);
    $query->execute();

    $interests = array();
    while ($r = $query->fetch())
      $interests[] = $r['id_interest'];

    return implode('-', $interests);
  }

  public function add_user(MUser $user)
  {
    $sql = 'INSERT INTO users
           (email, email_confirmed, username, first_name, last_name, password, location)
           VALUES
           (:email, :email_confirmed, :username, :first_name, :last_name, :password, :location)';
    $query = $this->_db->prepare($sql);
    $query->bindValue(':email', $user->get_email(), PDO::PARAM_STR);
    $query->bindValue(':email_confirmed', $user->get_email_confirmed(), PDO::PARAM_STR);
    $query->bindValue(':username', $user->get_username(), PDO::PARAM_STR);
    $query->bindValue(':first_name', $user->get_first_name(), PDO::PARAM_STR);
    $query->bindValue(':last_name', $user->get_last_name(), PDO::PARAM_STR);
    $query->bindValue(':password', $user->get_password(), PDO::PARAM_STR);
    $query->bindValue(':location', $user->get_location(), PDO::PARAM_STR);
    $query->execute();
    return $this->_db->lastInsertId();
  }

  public function update_user(MUser $user)
  {
    $sql = 'UPDATE users
            SET email = :email,
                email_confirmed = :email_confirmed,
                username = :username,
                first_name = :first_name,
                last_name = :last_name,
                date_of_birth = :date_of_birth,
                password = :password,
                last_activity = now(),
                location = :location,
                gender = :gender,
                popularity_score = :popularity_score,
                bio = :bio,
                seeked_gender = :seeked_gender,
                seeked_age_min = :seeked_age_min,
                seeked_age_max = :seeked_age_max,
                seeked_distance = :seeked_distance,
                seeked_popularity_score = :seeked_popularity_score,
                seeked_interests = :seeked_interests
            WHERE id_user = :id_user';
    $query = $this->_db->prepare($sql);
    $query->bindValue(':email', $user->get_email(), PDO::PARAM_STR);
    $query->bindValue(':email_confirmed', $user->get_email_confirmed(), PDO::PARAM_STR);
    $query->bindValue(':username', $user->get_username(), PDO::PARAM_STR);
    $query->bindValue(':first_name', $user->get_first_name(), PDO::PARAM_STR);
    $query->bindValue(':last_name', $user->get_last_name(), PDO::PARAM_STR);
    $query->bindValue(':date_of_birth', $user->get_date_of_birth(), PDO::PARAM_STR);
    $query->bindValue(':password', $user->get_password(), PDO::PARAM_STR);
    $query->bindValue(':location', $user->get_location(), PDO::PARAM_STR);
  	$query->bindValue(':gender', $user->get_gender(), PDO::PARAM_STR);
  	$query->bindValue(':popularity_score', $user->get_popularity_score(), PDO::PARAM_INT);
  	$query->bindValue(':bio', $user->get_bio(), PDO::PARAM_STR);
  	$query->bindValue(':id_user', $user->get_id_user(), PDO::PARAM_INT);
    $query->bindValue(':seeked_gender', $user->get_seeked_gender(), PDO::PARAM_STR);
    $query->bindValue(':seeked_age_min', $user->get_seeked_age_min(), PDO::PARAM_INT);
    $query->bindValue(':seeked_age_max', $user->get_seeked_age_max(), PDO::PARAM_INT);
    $query->bindValue(':seeked_distance', $user->get_seeked_distance(), PDO::PARAM_INT);
    $query->bindValue(':seeked_popularity_score', $user->get_seeked_popularity_score(), PDO::PARAM_INT);
    $query->bindValue(':seeked_interests', $user->get_seeked_interests(), PDO::PARAM_STR);
    $query->execute();
  }

  /* *********************************************************** *\
      REGISTER, LOGIN, LOGOUT, RESET_PASSWORD
  \* *********************************************************** */

  public function register(MUser $user)
  {
    $last_inserted_id = $this->add_user($user);
    $user->set_id_user($last_inserted_id);

    $emailMng = new MEmailMng();
    $emailMng->send_registration_confirmation($user);
  }

  public function login($username)
  {
    $user = $this->select_user_by('username', $username);
    $_SESSION['is_logged'] = TRUE;
    $_SESSION['id_user'] = $user->get_id_user();
    $_SESSION['username'] = $user->get_username();
  }

  public function logout()
  {
    unset($_SESSION['id_user']);
    unset($_SESSION['username']);
    $_SESSION['is_logged'] = FALSE;
  }

  public function reset_password(MUser $user)
  {
    $this->update_user($user);

    $emailMng = new MEmailMng();
    $emailMng->send_reset_confirmation($user);
  }

  /* *************************************************************** *\
      CHECK_REGISTRATION/LOGIN/MODIFY/RESET_values
      Checks input from $_POST is valid, or returns an error message.
  \* *************************************************************** */

  /* ------------------------- COMMON ------------------------- */

  public function check_name(array $post, $field)
  {
    if (empty($post[$field]))
      return 'Please enter a name.';

    if ($this->is_valid_string_format($post[$field]) === FALSE)
      return 'Invalid name.';

    return FALSE;
  }

  public function check_password(array $post)
  {
    if (empty($post['pass']) ||
        empty($post['passcheck']) ||
        $post['pass'] != $post['passcheck'])
      return 'Please enter matching passwords.';

    if (strlen($post['pass']) < 6)
      return 'Please use a password at least 6-character long.';

    if (preg_match('/^[A-Za-z0-9]*$/', $post['pass']))
      return 'Please use at least one special character.';

    return FALSE;
  }

  /* ------------------------- REGISTRATION ------------------------- */

  public function check_registration_email(array $post)
  {
    if (empty($post['email']))
      return 'Please enter an email address.';

    if ($this->is_valid_email_format($post['email']) === FALSE)
      return 'Invalid email address.';

    $user = $this->select_user_by('email', $post['email']);
    if (!is_null($user))
      return 'Email taken.';

    return FALSE;
  }

  public function check_registration_username(array $post)
  {
    if (empty($post['username']))
      return 'Please enter a username.';

    if ($this->is_valid_string_format($post['username']) === FALSE)
      return 'Invalid username.';

    $user = $this->select_user_by('username', $post['username']);
    if (!is_null($user))
      return 'Username taken.';

    return FALSE;
  }

  /* ------------------------- LOGIN ------------------------- */

  public function check_login_username(array $post)
  {
    if (empty($post['username']))
      return 'error';

    if ($this->is_valid_string_format($post['username']) === FALSE)
      return 'error';

    $user = $this->select_user_by('username', $post['username']);
    if (is_null($user))
      return 'error';

    return FALSE;
  }

  public function check_login_email_confirmed(array $post)
  {
    $user = $this->select_user_by('username', $post['username']);
    if ($user->get_email_confirmed() != 1)
      return 'error';

    return FALSE;
  }

  public function check_login_password(array $post)
  {
    if (empty($post['pass']))
      return 'error';

    $user_posted = new MUser(array('username' => $post['username']));
    $user_posted->encrypt_and_set_password($post['pass']);
    $user_fetched = $this->select_user_by('username', $post['username']);
    if ($user_posted->get_password() != $user_fetched->get_password())
      return 'error';

    return FALSE;
  }

  /* ------------------------- MODIFY ------------------------- */

  public function check_modify_email(array $post, MUser $user)
  {
    if (empty($post['email']))
      return 'Please enter an email address.';

    if ($this->is_valid_email_format($post['email']) === FALSE)
      return 'Invalid email address.';

    if ($post['email'] != $user->get_email())
    {
      $user_check = $this->select_user_by('email', $post['email']);
      if (!is_null($user_check))
        return 'Email taken.';
    }

    return FALSE;
  }

  public function check_modify_username(array $post, MUser $user)
  {
    if (empty($post['username']))
      return 'Please enter a username.';

    if ($this->is_valid_string_format($post['username']) === FALSE)
      return 'Invalid username.';

    if ($post['username'] != $user->get_username())
    {
      $user = $this->select_user_by('username', $post['username']);
      if (!is_null($user))
        return 'Username taken.';
    }

    return FALSE;
  }

  /* ------------------------- RESET ------------------------- */

  public function check_reset_email(array $post)
  {
    if (empty($post['email']))
      return 'Please enter an email address.';

    if ($this->is_valid_email_format($post['email']) === FALSE)
      return 'Invalid email address.';

    $user_check = $this->select_user_by('email', $post['email']);
    if (is_null($user_check))
      return 'No account for this email.';

    return FALSE;
  }

  /* *********************************************************** *\
      GET_USER_action_VALIDATION_CODE
      Sets the "email_confirmed" validation code whenever
      a user sets/modifies their email.
  \* *********************************************************** */

  public function get_user_registration_validation_code(array $get)
  {
    if (empty($get['confirm']))
      return NULL;

    $split = explode('-', $get['confirm']);
    if (count($split) > 2 ||
        $this->is_valid_int_format($split[0]) === FALSE ||
        $this->is_valid_string_format($split[1]) === FALSE ||
        $split[1] === '1')
      return NULL;

    $user = $this->select_user_by('id_user', $split[0]);
    if (is_null($user) ||
        $user->get_email_confirmed() != $split[1])
      return NULL;

    return $user;
  }

  public function is_ok_modification_validation_code(array $get, $current_user)
  {
    if (empty($get['confirm']))
      return FALSE;

    $split = explode('-', $get['confirm']);
    if (count($split) > 2 ||
        $this->is_valid_int_format($split[0]) === FALSE ||
        $this->is_valid_string_format($split[1]) === FALSE ||
        $split[0] != $current_user->get_id_user() ||
        $split[1] != $current_user->get_email_confirmed() ||
        $split[1] === '1')
      return FALSE;
    return TRUE;
  }

  public function get_user_reset_validation_code(array $get)
  {
    return $this->get_user_registration_validation_code($get);
  }
}
