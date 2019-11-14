<?php
/* ************************************************************** *\
    MSearchMng manages search results:

\* ************************************************************** */

class MSearchMng extends M_Manager
{
  /* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| *\
                              Search form
  \* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

  /* ************************************************************** *\
      LIST_xxx_OPTIONS
      Gets the filter choices.
  \* ************************************************************** */

  public function list_gender_options()
  {
    $genders = array('any' => 'Any', 'F' => 'Female', 'M' => 'Male');
    return $genders;
  }

  public function list_interest_options()
  {
    $sql = 'SELECT id_interest, interest
            FROM interests';
    $query = $this->_db->prepare($sql);
    $query->execute();

    $interests = array();
    while ($r = $query->fetch())
      $interests[$r['id_interest']] = $r['interest'];
    return $interests;
  }

  /* ************************************************************** *\
      UPDATE_FORM_xxx
      Takes valid form input from GET and sets it as prefill values.
  \* ************************************************************** */

  private function update_form_gender(array $prefill, array $get, array $list_genders)
  {
    if (isset($get['gender']) &&
        array_key_exists($get['gender'], $list_genders))
      $prefill['gender_'.$get['gender']] = 'checked';

    return $prefill;
  }

  private function update_form_age_min(array $prefill, array $get)
  {
    if (isset($get['age_min']) &&
        $this->is_valid_int_format($get['age_min']) &&
        $get['age_min'] >= 0 &&
        $get['age_min'] <= 35)
      $prefill['age_min'] = $get['age_min'];

    return $prefill;
  }

  private function update_form_age_max(array $prefill, array $get)
  {
    if (isset($get['age_max']) &&
        $this->is_valid_int_format($get['age_max']) &&
        $get['age_max'] >= 0 &&
        $get['age_max'] <= 35)
      $prefill['age_max'] = $get['age_max'];

    return $prefill;
  }

  private function update_form_distance(array $prefill, array $get)
  {
    if (isset($get['distance']) &&
        $this->is_valid_int_format($get['distance']) &&
        $get['distance'] >= 1 &&
        $get['distance'] <= 15)
      $prefill['distance'] = $get['distance'];

    return $prefill;
  }

  private function update_form_interests(array $prefill, array $get, array $list_interests)
  {
    if (isset($get['interests']) &&
        preg_match('/^((\d+)(-{0,1}))+$/', $get['interests']))
    {
      $selected_interests = explode('-', $get['interests']);
      foreach ($selected_interests as $key)
        $prefill['interest_'.$key] = 'checked';
      $prefill['interest_any'] = '';
    }
    return $prefill;
  }

  public function update_form_prefill(array $prefill, array $get, array $list_genders, array $list_interests)
  {
    $prefill = $this->update_form_gender($prefill, $get, $list_genders);
    $prefill = $this->update_form_age_min($prefill, $get);
    $prefill = $this->update_form_age_max($prefill, $get);
    $prefill = $this->update_form_distance($prefill, $get);
    $prefill = $this->update_form_interests($prefill, $get, $list_interests);
    return $prefill;
  }

  /* ************************************************************** *\
      DEFINE_FILTER_CONDITIONS
      Translates the form's prefill values (i.e the default search
      or the contents of GET) into an array for the SELECT query.
  \* ************************************************************** */

  public function define_filter_conditions(array $f, array $list_interests, MUser $user)
  {
    // Translates the checked gender into a key.
    if ($f['gender_F'] == 'checked')
      $gender_seeked = 'F';
    else if ($f['gender_M'] == 'checked')
      $gender_seeked = 'M';
    else
      $gender_seeked = NULL;

      // Translates the checked interests into a list of ids.
      if ($f['interest_any'] == 'checked')
        $interests = NULL;
      else
      {
        foreach ($list_interests as $key => $value)
        {
          if ($f['interest_'.$key] == 'checked')
            $interests[] = $key;
        }
        $interests = implode(',', $interests);
      }

    // Sets the filter array.
    $filter_conditions = array(
      'current_user' => array(
        'id_user' => $user->get_id_user(),
        //'gender' => $user->get_gender_self(),
        //'age' => $user->get_age(),
        'location' => $user->get_location()
      ),
      'search' => array(
        'gender' => $gender_seeked,
        'age_min' => $f['age_min'],
        'age_max' => $f['age_max'],
        'distance' => $f['distance'],
        'interests' => $interests
      ),
    );

    return $filter_conditions;
  }

  /* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| *\
                Support functions for pagination and search
  \* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

  /* ************************************************************** *\
      CREATE/EXECUTE_SEARCH_QUERY
      (used by COUNT/SELECT_SEARCH_RESULTS)
      Translates the search 'conditions' array into SQL statements
      and executed query.
  \* ************************************************************** */

  private function create_search_query($case, array $conditions, array $pagination)
  {
    // Creates a $statement array with all the elements of the SQL query.
    if ($case == 'select')
    {
      $statement['action'] = 'SELECT id_user, username, gender_self, bio, date_of_birth';
      $statement['order'] = 'ORDER BY popularity_score DESC';
      $statement['limit'] = 'LIMIT '.$pagination['start_i'].', '.$pagination['end_i'];
    }
    else
    {
      $statement['action'] = 'SELECT COUNT(*) AS nb_results';
      $statement['order'] = '';
      $statement['limit'] = '';
    }
    $statement['from'] = 'FROM users';
    $statement['where'] = 'WHERE id_user != :id_user';
    $statement['and'][] = 'AND email_confirmed = "1"';
    $statement['and'][] = 'AND TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN :age_min AND :age_max';
    $statement['and'][] = 'AND (111.111 *
                                DEGREES(ACOS(LEAST(1.0, COS(RADIANS(@user_latitude)) *
                                COS(RADIANS(CAST(SUBSTRING_INDEX(location, " ", 1) AS DECIMAL(9,5)))) *
                                COS(RADIANS(@user_longitude - CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(location, " ", 2), " ", -1) AS DECIMAL(9,5)))) +
                                SIN(RADIANS(@user_latitude)) * SIN(RADIANS(CAST(SUBSTRING_INDEX(location, " ", 1) AS DECIMAL(9,5))))))))
                                < :max_distance';

    if ($conditions['search']['gender'] !== NULL)
      $statement['and'][] = 'AND gender_self = :gender_user_searched';

    if ($conditions['search']['interests'] !== NULL)
      $statement['and'][] = 'AND id_user IN
                            (SELECT DISTINCT(id_user)
                             FROM users_interests
                             WHERE id_interest IN
                             ('.$conditions['search']['interests'].'))';

    // Transforms the $statement array into a proper $sql string.
    $sql_and = implode(' ', $statement['and']);
    $sql = $statement['action'].' '.
           $statement['from'].' '.
           $statement['where'].' '.
           $sql_and.' '.
           $statement['order'].' '.
           $statement['limit'];
    $sql = preg_replace('/\s+/', ' ', $sql);

    return $sql;
  }

  private function execute_search_query($sql, array $conditions)
  {
    list($user_latitude, $user_longitude) = explode(' ', $conditions['current_user']['location']);
    $this->_db->exec('SET @user_latitude = 50; SET @user_longitude = 4;');

    $query = $this->_db->prepare($sql);
    $query->bindValue(':id_user', $conditions['current_user']['id_user'], PDO::PARAM_INT);
    $query->bindValue(':age_min', $conditions['search']['age_min'], PDO::PARAM_INT);
    $query->bindValue(':age_max', $conditions['search']['age_max'], PDO::PARAM_INT);
    $query->bindValue(':max_distance', $conditions['search']['distance'], PDO::PARAM_INT);
    if ($conditions['search']['gender'] !== NULL)
      $query->bindValue(':gender_user_searched', $conditions['search']['gender'], PDO::PARAM_STR);
    $query->execute();

    return $query;
  }

  /* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| *\
                              Pagination
  \* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

  /* ************************************************************** *\
      COUNT_SEARCH_RESULTS
      Counts the users that fit into the search conditions.
  \* ************************************************************** */

  public function count_search_results(array $conditions)
  {
    $sql = $this->create_search_query('count', $conditions, array());
    $query = $this->execute_search_query($sql, $conditions);

    $r = $query->fetch();
    return $r['nb_results'];
  }

  /* ************************************************************** *\
      GET_PAGINATION_VALUES
      Creates an array with current page, last page, etc.
  \* ************************************************************** */

  public function get_pagination_values($nb_results, array $get)
  {
    $results_per_page = 12;
    $pagination['nb_pages'] = ceil($nb_results / $results_per_page);
    $pagination['nb_pages'] = ($pagination['nb_pages'] == 0) ? 1 : $pagination['nb_pages'];

    if (isset($get['page']) && $this->is_valid_int_format($get['page']))
      $pagination['current_page'] = $get['page'];
    else
      $pagination['current_page'] = 1;

    $pagination['start_i'] = ($pagination['current_page'] - 1) * $results_per_page;
    $pagination['end_i'] = $results_per_page;

    $http_s = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
    $base_url = $http_s.'://'.$_SERVER["HTTP_HOST"];
    $base_uri = preg_replace('/&page=\d+/', '', $_SERVER["REQUEST_URI"]);
    $pagination['url'] = $base_url.$base_uri.'&page=';

    return $pagination;
  }

  /* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| *\
                              Search results
  \* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

  /* ************************************************************** *\
      SELECT_SEARCH_RESULTS
      Selects the users that fit into the search conditions.
  \* ************************************************************** */

  public function select_search_results(array $conditions, array $pagination)
  {
    $sql = $this->create_search_query('select', $conditions, $pagination);
    $query = $this->execute_search_query($sql, $conditions);

    $users = array();
    $i = 0;
    while ($r = $query->fetch())
    {
      $users[$i] = new MUser($r);
      $users[$i]->set_profile_pics();
      $i++;
    }

    return $users;
  }
}
