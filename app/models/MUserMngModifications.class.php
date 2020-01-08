<?php
/* ************************************************************** *\
    MUserMng manages User through:
    - SELECT, ADD, UPDATE, DELETE functions (DB manipulations).
    - REGISTER, LOGIN, LOGOUT, RESET_PASSWORD (user connections).
    - CHECK_context_values functions (checkers for posted data).
\* ************************************************************** */

class MUserMngModifications extends MUserMng
{
  /* *********************************************************** *\
      UPDATE functions
  \* *********************************************************** */

  public function update_account(MUser $user)
  {
    $sql = 'UPDATE users
            SET email = :email,
                email_confirmed = :email_confirmed,
                username = :username,
                first_name = :first_name,
                last_name = :last_name,
                password = :password
            WHERE id_user = :id_user';
    $query = $this->_db->prepare($sql);
    $query->bindValue(':email', $user->get_email(), PDO::PARAM_STR);
    $query->bindValue(':email_confirmed', $user->get_email_confirmed(), PDO::PARAM_STR);
    $query->bindValue(':username', $user->get_username(), PDO::PARAM_STR);
    $query->bindValue(':first_name', $user->get_first_name(), PDO::PARAM_STR);
    $query->bindValue(':last_name', $user->get_last_name(), PDO::PARAM_STR);
    $query->bindValue(':password', $user->get_password(), PDO::PARAM_STR);
    $query->bindValue(':id_user', $user->get_id_user(), PDO::PARAM_INT);
    $query->execute();
  }

  public function update_profile(MUser $user)
  {
    // Update fields in 'users' table
    $sql = 'UPDATE users
            SET date_of_birth = :date_of_birth,
                location = :location,
                location_on = :location_on,
                gender = :gender,
                bio = :bio
            WHERE id_user = :id_user';
    $query = $this->_db->prepare($sql);
    $query->bindValue(':date_of_birth', $user->get_date_of_birth(), PDO::PARAM_STR);
    $query->bindValue(':location', $user->get_location(), PDO::PARAM_STR);
    $query->bindValue(':location_on', $user->get_location_on(), PDO::PARAM_INT);
    $query->bindValue(':gender', $user->get_gender(), PDO::PARAM_STR);
    $query->bindValue(':bio', $user->get_bio(), PDO::PARAM_STR);
    $query->bindValue(':id_user', $user->get_id_user(), PDO::PARAM_INT);
    $query->execute();

    // Delete all current interests of the user.
    $sql = 'DELETE FROM users_interests
            WHERE id_user = :id_user';
    $query = $this->_db->prepare($sql);
    $query->bindValue(':id_user', $user->get_id_user(), PDO::PARAM_INT);
    $query->execute();

    // Insert the new interests.
    if ($user->get_interests())
    {
      $interests = explode('-', $user->get_interests());
      foreach ($interests as $id)
        $values[] = '('.$user->get_id_user().', '.$id.')';

      $values = implode(', ', $values);
      $sql = 'INSERT INTO users_interests (id_user, id_interest)
              VALUES '.$values;
      $query = $this->_db->prepare($sql);
      $query->execute();
    }
  }

  public function update_mate(MUser $user)
  {
    $sql = 'UPDATE users
            SET seeked_gender = :seeked_gender,
                seeked_age_min = :seeked_age_min,
                seeked_age_max = :seeked_age_max,
                seeked_distance = :seeked_distance,
                seeked_popularity_range = :seeked_popularity_range,
                seeked_interests = :seeked_interests
            WHERE id_user = :id_user';
    $query = $this->_db->prepare($sql);
    $query->bindValue(':seeked_gender', $user->get_seeked_gender(), PDO::PARAM_STR);
    $query->bindValue(':seeked_age_min', $user->get_seeked_age_min(), PDO::PARAM_INT);
    $query->bindValue(':seeked_age_max', $user->get_seeked_age_max(), PDO::PARAM_INT);
    $query->bindValue(':seeked_distance', $user->get_seeked_distance(), PDO::PARAM_INT);
    $query->bindValue(':seeked_popularity_range', $user->get_seeked_popularity_range(), PDO::PARAM_INT);
    $query->bindValue(':seeked_interests', $user->get_seeked_interests(), PDO::PARAM_STR);
    $query->bindValue(':id_user', $user->get_id_user(), PDO::PARAM_INT);
    $query->execute();
  }

  /* *************************************************************** *\
      CHECK_MODIFY_values
      Checks input from $_POST is valid, or returns an error message.
  \* *************************************************************** */

  /* ------------------------- ACCOUNT ------------------------- */

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

  /* ------------------------- PROFILE ------------------------- */

  public function check_modify_gender(array $post)
  {
    if (!in_array($post['gender'], array(NULL, 'F', 'M')))
      return 'Invalid gender.';
    return FALSE;
  }

  public function check_modify_date_of_birth(array $post)
  {
    if (!empty($post['date_of_birth']) &&
        !preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $post['date_of_birth']))
      return 'Invalid date.';
    return FALSE;
  }

  public function check_modify_location(array $post)
  {
    if (!in_array($post['location_on'], array('0', '1')) ||
        empty($post['latitude']) ||
        empty($post['longitude']) ||
        !$this->is_valid_float_format($post['latitude']) ||
        !$this->is_valid_float_format($post['longitude']))
      return 'Invalid location. Please allow geolocation in your browser.';

    return FALSE;
  }

  public function check_modify_bio(array $post)
  {
    if (!$this->is_valid_string_format($post['bio']))
      return 'Invalid bio';
    return FALSE;
  }

  public function check_modify_interests($selected_interests)
  {
    if ($selected_interests != '' &&
        !preg_match('/^((\d+)(-{0,1}))+$/', $selected_interests))
      return 'Invalid interests';
    return FALSE;
  }

  /* ------------------------- MATE ------------------------- */

  public function check_modify_seeked_gender(array $post)
  {
    if (!in_array($post['seeked_gender'], array(NULL, 'F', 'M')))
      return 'Invalid gender.';
    return FALSE;
  }

  public function check_modify_seeked_age(array $post)
  {
    if (($post['seeked_age_min'] != '' && !$this->is_valid_int_format($post['seeked_age_min'])) ||
        ($post['seeked_age_max'] != '' && !$this->is_valid_int_format($post['seeked_age_max'])))
      return 'Invalid age values.';

    if ($post['seeked_age_min'] != '' &&
        $post['seeked_age_max'] != '' &&
        $post['seeked_age_min'] > $post['seeked_age_max'])
      return 'Age min must be lower than age max';

    if ($post['seeked_age_min'] != '' &&
        $post['seeked_age_max'] == '')
      return 'Age min must be lower than age max';

    return FALSE;
  }

  public function check_modify_seeked_distance(array $post)
  {
    if (!$this->is_valid_int_format($post['seeked_distance']))
      return 'Invalid distance.';
    return FALSE;
  }

  public function check_modify_seeked_interests($selected_interests)
  {
    if ($selected_interests != '' &&
        !preg_match('/^((\d+)(-{0,1}))+$/', $selected_interests))
      return 'Invalid interests';
    return FALSE;
  }

  public function check_modify_seeked_popularity(array $post)
  {
    if (!$this->is_valid_int_format($post['seeked_popularity_range']))
      return 'Invalid popularity range.';
    return FALSE;
  }
}
