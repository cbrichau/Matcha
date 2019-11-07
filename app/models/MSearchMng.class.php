<?php
/* ************************************************************** *\
    MSearchMng manages search results:

\* ************************************************************** */

class MSearchMng extends M_Manager
{
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
        $get['age_min'] >= 1 &&
        $get['age_min'] <= 25)
      $prefill['age_min'] = $get['age_min'];

    return $prefill;
  }

  private function update_form_age_max(array $prefill, array $get)
  {
    if (isset($get['age_max']) &&
        $this->is_valid_int_format($get['age_max']) &&
        $get['age_max'] >= 1 &&
        $get['age_max'] <= 25)
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
}
