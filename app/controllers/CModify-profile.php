<?php
/* *********************************************************** *\
    "Modify my profile" page.
    Shows a form to a logged user to modify his/her info.
\* *********************************************************** */

$userMng = new MUserMngModifications();
$current_user = $userMng->select_user_by('id_user', $_SESSION['id_user']);
$current_user_interests = explode('-', $userMng->select_user_interests($current_user));

$searchMng = new MSearchMng();
$list_genders = $searchMng->list_gender_options();
$list_interests = $searchMng->list_interest_options();

// Initialises the form's alerts to null,
// and its and prefill values to the user's current info from the DB.
$success_alert = '';
$error_alert = array_fill_keys(array('gender', 'date_of_birth', 'location', 'bio', 'interests'), '');
$form_prefill = $userMng->sanitize_for_output($current_user->get_all_properties());
foreach ($list_genders as $key => $v)
{
  $form_prefill['gender_'.$key] = '';
  if ($form_prefill['gender'] == $key)
    $form_prefill['gender_'.$key] = 'selected';
}
foreach ($list_interests as $key => $v)
{
  $form_prefill['interest_'.$key] = '';
  if (in_array($key, $current_user_interests))
    $form_prefill['interest_'.$key] = 'checked';
}

// Processes the modification form.
if (isset($_POST['modify']))
{
  // Overrides the prefill values with the posted ones.
  $form_prefill = array_replace($form_prefill, $_POST);
  $form_prefill = $userMng->sanitize_for_output($form_prefill);

  // Checks the input is valid, or returns an error message.
  $error_msg['gender'] = $userMng->check_modify_gender($_POST, $current_user);
  $error_msg['date_of_birth'] = $userMng->check_modify_date_of_birth($_POST, $current_user);
  $error_msg['location'] = $userMng->check_modify_location($_POST, 'first_name');
  $error_msg['bio'] = $userMng->check_modify_bio($_POST, 'last_name');
  $error_msg['interests'] = $userMng->check_modify_interests($_POST);

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
    $current_user = $current_user->update_user_info($current_user, $_POST);
    $userMng->update_profile($current_user);
    $success_alert = '<div class="alert alert-success"><span>success:</span> Your profile has been modified</div>';
  }
}

// Sets the output values and calls the views.
$output->set_head_title('Modify my profile');

require_once(Config::VIEW_HEADER);
require_once(Router::$page['view']);
require_once(Config::VIEW_FOOTER);
