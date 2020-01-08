<?php
/* *********************************************************** *\
    "Reset my password" page.
    Shows a form to non-logged users to reset their password.
\* *********************************************************** */

$userMng = new MUserMng();

// Initialises the form's alerts and prefill values to null.
$success_alert = '';
$error_alert = array_fill_keys(array('email', 'password'), '');
$form_prefill = array_fill_keys(array('email', 'validation_code'), '');

// Defines if the email field is visible (for reset request)
// or the passwords fields are (for new password choice).
$reset_request_form = TRUE;
$new_password_form = FALSE;

// Processes the reset confirmation
// (when the user clicks on the email validation link).
if (isset($_GET['confirm']))
{
  // Checks the validation code from the URL is valid. If so, returns a user object matching the user being confirmed,
  // and s that user (object + database entry) to validate him/her. Then logs the user and redirects to home.
  $user = $userMng->get_user_reset_validation_code($_GET);
  if (!is_null($user))
  {
    $reset_request_form = FALSE;
    $new_password_form = TRUE;
    $form_prefill['validation_code'] = $userMng->sanitize_for_output($_GET['confirm']);
  }
  else
    $success_alert = '<div class="alert alert-danger"><span>error:</span> Bad validation link.</div>';
}

// Processes the reset_request form.
if (isset($_POST['reset_request']))
{
  // Prefills the form with the posted info.
  $form_prefill = array_replace($form_prefill, $_POST);
  $form_prefill = $userMng->sanitize_for_output($form_prefill);

  // Checks the input is valid, or returns an error message.
  $error_msg['email'] = $userMng->check_reset_email($_POST);

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
  // If all good, modifies the user (s the user object and the database).
  else
  {
    $user = $userMng->select_user_by('email', $_POST['email']);
    $user->set_password(NULL);
    $user->set_email_confirmed(md5(rand(0,1000)));
    $userMng->reset_password($user);
    $success_alert = '<div class="alert alert-success"><span>success:</span> An email has been sent to you with a validation link.</div>';
  }
}

// Processes the new_password form.
if (isset($_POST['new_password']))
{
  $reset_request_form = FALSE;
  $new_password_form = TRUE;

  // Checks the input is valid, or returns an error message.
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
  // If all good, modifies the user (s the user object and the database).
  else
  {
    $user = $userMng->get_user_reset_validation_code(array('confirm' => $_POST['validation_code']));
    if (!is_null($user))
    {
      $user->encrypt_and_set_password($_POST['pass']);
      $user->set_email_confirmed(TRUE);
	  $account_manager = new MUserMngModifications();
      $account_manager->update_account($user);
      $userMng->login($user->get_username());
      header('Location: '.Config::ROOT.'');
    }
    else
      $success_alert = '<div class="alert alert-danger"><span>error:</span> Bad validation link.</div>';
  }
}

// Sets the output values and calls the views.
$output->set_head_title('Reset my password');

require_once(Config::VIEW_HEADER);
require_once(Router::$page['view']);
require_once(Config::VIEW_FOOTER);
