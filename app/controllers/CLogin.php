<?php
/* *********************************************************** *\
    "Login" page.
    Shows a form to a non-logged user to create an account.
\* *********************************************************** */

$userMng = new MUserMng();

// Initialises the form's alerts and prefill values to null.
$error_alert = '';
$form_prefill = array_fill_keys(array('username'), '');

// Processes the login form.
if (isset($_POST['login']))
{
  // Prefills the form with the posted info.
  $form_prefill = array_replace($form_prefill, $_POST);
  $form_prefill = $userMng->sanitize_for_output($form_prefill);

  // Checks the input is valid, or returns error = TRUE.
  $error = $userMng->check_login_username($_POST) ||
           $userMng->check_login_email_confirmed($_POST) ||
           $userMng->check_login_password($_POST);

  // If the input is not valid (i.e. there's at least one non-false error),
  // sets the corresponding alert(s).
  if ($error == TRUE)
    $error_alert = '<div class="alert alert-danger"><span>error:</span> Wrong username and/or password.</div>';
  // If all good, logs the user and redirects to home.
  else
  {
    $userMng->login($_POST['username']);
    header('Location: '.Config::ROOT.'');
  }
}

// Sets the output values and calls the views.
$output->set_head_title('Log in');

require_once(Config::VIEW_HEADER);
require_once(Router::$page['view']);
require_once(Config::VIEW_FOOTER);
