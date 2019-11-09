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
      UPDATE_xxx_PREFILL
      Takes valid form input from GET and sets it as prefill values.
  \* ************************************************************** */

  private function update_form_gender(array $prefill, array $get, array $list_genders)
  {
    if (isset($get['gender']) &&
        array_key_exists($get['gender'], $list_genders))
    {
      $prefill['gender_any'] = '';
      $prefill['gender_'.$get['gender']] = 'checked';
    }
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
      print_r($selected_interests);
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



      missing user age/dob field !!!!!!!!!!!!!!


  \* ************************************************************** */

  public function define_filter_conditions(array $f, MUser $user)
  {
    $filter_conditions = array(
      'current_user' => array(
        'id_user' => $user->get_id_user(),
        'gender' => $user->get_gender_self(),
        'location' => $user->get_location()
      ),
      'search' => array(
        'gender' => '',
        'age_min' => $f['age_min'],
        'age_max' => $f['age_max'],
        'distance' => $f['distance'],
        'interests' => '',
      ),
    );

    // current_user ['age'] = $user->get_age();
    // pop score?
    // interests?

    if ($f['gender_F'] == 'checked')
      $filter_conditions['search']['gender'] = 'F';
    else if ($f['gender_M'] == 'checked')
      $filter_conditions['search']['gender'] = 'M';



    return $filter_conditions;
  }

  /* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| *\
                              Pagination
  \* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

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
    $pagination['end_i'] = $pagination['start_i'] + $results_per_page;
    if ($pagination['end_i'] > $nb_results)
      $pagination['end_i'] = $nb_results;

    return $pagination;
  }

  /* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| *\
                              Search results
  \* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */


  public function select_all_users()
  {
    $sql = 'SELECT id_user, username, bio
            FROM users';
    $query = $this->_db->prepare($sql);
    $query->execute();

    $users = array();
    while ($r = $query->fetch())
      $users[] = new MUser($r);
    return $users;
  }

  public function count_users(array $filter_conditions)
  {
    $sql = 'SELECT id_user, username, bio
            FROM users
            WHERE id_user != :id_user
              AND email_confirmed = "1"';

    //if ($filter_conditions)

    $query = $this->_db->prepare($sql);
    $query->bindValue(':id_user', $filter_conditions['current_user']['id_user'], PDO::PARAM_INT);
    $query->execute();

    $users = array();
    while ($r = $query->fetch())
      $users[] = new MUser($r);
    return $users;
  }
}
