<?php
/* *********************************************************** *\
    "Modify my ideal mate's profile" page.
    Shows a form to a logged user to modify his/her info.
\* *********************************************************** */

$userMng = new MUserMngModifications();
$current_user = $userMng->select_user_by('id_user', $_SESSION['id_user']);
$current_user_seeked_interests = explode('-', $current_user->get_seeked_interests());

$searchMng = new MSearchMng();
$list_genders = $searchMng->list_gender_options();
$list_interests = $searchMng->list_interest_options();

// Initialises the form's alerts to null,
// and its and prefill values to the user's current info from the DB.
$success_alert = '';
$error_alert = array_fill_keys(array('seeked_gender', 'seeked_age', 'seeked_distance', 'seeked_interests', 'seeked_popularity_range'), '');
$form_prefill = $userMng->sanitize_for_output($current_user->get_all_properties());
foreach ($list_genders as $key => $v)
{
  $form_prefill['seeked_gender_'.$key] = '';
  if ($form_prefill['seeked_gender'] == $key)
    $form_prefill['seeked_gender_'.$key] = 'selected';
}
foreach ($list_interests as $key => $v)
{
  $form_prefill['seeked_interest_'.$key] = '';
  if (in_array($key, $current_user_seeked_interests))
    $form_prefill['seeked_interest_'.$key] = 'checked';
}

// Processes the modification form.
if (isset($_POST['modify']))
{
  // Overrides the prefill values with the posted ones.
  $form_prefill = array_replace($form_prefill, $_POST);
  $form_prefill = $userMng->sanitize_for_output($form_prefill);

  foreach ($list_genders as $key => $v)
  {
    $form_prefill['seeked_gender_'.$key] = '';
    if ($form_prefill['seeked_gender'] == $key)
      $form_prefill['seeked_gender_'.$key] = 'selected';
  }

  $selected_interests = str_replace('i_', '', preg_grep('/i_[0-9]+/', array_keys($_POST)));
  foreach ($list_interests as $key => $v)
  {
    $form_prefill['seeked_interest_'.$key] = '';
    if (in_array($key, $selected_interests))
      $form_prefill['seeked_interest_'.$key] = 'checked';
  }
  $selected_interests = implode('-', $selected_interests);

  // Checks the input is valid, or returns an error message.
  $error_msg['seeked_gender'] = $userMng->check_modify_seeked_gender($_POST);
  $error_msg['seeked_age'] = $userMng->check_modify_seeked_age($_POST);
  $error_msg['seeked_distance'] = $userMng->check_modify_seeked_distance($_POST);
  $error_msg['seeked_interests'] = $userMng->check_modify_seeked_interests($selected_interests);
  $error_msg['seeked_popularity_range'] = $userMng->check_modify_seeked_popularity($_POST);

  // If the input is not valid (i.e. there's at least one non-false error),
  // sets the corresponding alert(s).
  if (in_array(TRUE, $error_msg))
  {
    foreach ($error_msg as $field => $msg)
    {
      if ($msg == TRUE)
        $error_alert[$field] = '<div class="alert alert-danger"><span>error:</span> '.$msg.'</div>';
    }
  }
  // If all good, modifies the user (updates the user object and the database).
  else
  {
    $current_user->update_user_info($current_user, $_POST);
    $current_user->set_seeked_interests($selected_interests);
    $userMng->update_mate($current_user);
    $success_alert = '<div class="alert alert-success"><span>success:</span> Your ideal mate\'s profile has been modified</div>';
  }
}

// Sets the output values and calls the views.
$output->set_head_title('Modify my ideal mate\'s profile');

require_once(Config::VIEW_HEADER);
require_once(Router::$page['view']);
require_once(Config::VIEW_FOOTER);
