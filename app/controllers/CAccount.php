<?php
/* *********************************************************** *\
    "Modify my account" page.
    Shows a form to a logged user to modify his/her info.
\* *********************************************************** */

$userMng = new MUserMng();
$current_user = $userMng->select_user_by('id_user', $_SESSION['id_user']);

// Initialises the form's alerts to null,
// and its and prefill values to the user's current info from the DB.
$success_alert = '';
$error_alert = array_fill_keys(array('email', 'username', 'first_name', 'last_name', 'password'), '');
$form_prefill = $userMng->sanitize_for_output($current_user->get_all_properties());

// Processes the modification confirmation
// (when the user clicks on the email validation link).
if (isset($_GET['confirm']))
{
  // Checks the validation code from the URL is valid.
  // If so, updates the current user (object + database entry + SESSION).
  if ($userMng->get_user_modification_validation_code($_GET))
  {
    $user->set_email_confirmed(TRUE);
    $userMng->update_user($user);
    $userMng->login($user->get_username());
  }
  else
    $success_alert = '<div class="alert alert-danger"><span>error:</span> Bad validation link.</div>';
}

// Processes the modification form.
else if (isset($_POST['modify']))
{
  // Overrides the prefill values with the posted ones.
  $form_prefill = array_replace($form_prefill, $_POST);
  $form_prefill = $userMng->sanitize_for_output($form_prefill);

  // Checks the input is valid, or returns an error message.
  $error_msg['email'] = $userMng->check_modify_email($_POST, $current_user);
  $error_msg['username'] = $userMng->check_modify_username($_POST, $current_user);
  $error_msg['first_name'] = $userMng->check_name($_POST, 'first_name');
  $error_msg['last_name'] = $userMng->check_name($_POST, 'last_name');
  $error_msg['password'] = $userMng->check_password($_POST);

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
    $current_user = $userMng->update_user_info($current_user, $_POST);
    $current_user->encrypt_and_set_password($_POST['pass']);
    $userMng->update_user($user);
    ////////////////////// if email has changed, resend validation link and logout
    // see register
    // else: relog to update session
    $userMng->login($user->get_username());
    $success_alert = '<div class="alert alert-success"><span>success:</span> Your account has been modified</div>';
  }
}

// Sets the output values and calls the views.
$output->set_head_title('Modify my account');

require_once(Config::VIEW_HEADER);
require_once(Router::$page['view']);
require_once(Config::VIEW_FOOTER);
