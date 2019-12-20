<?php
/* *********************************************************** *\
    "Register" page.
    Shows a form to a non-logged user to create an account.
\* *********************************************************** */

$userMng = new MUserMng();

// Initialises the form's alerts and prefill values to null.
$success_alert = '';
$error_alert = array_fill_keys(array('email', 'username', 'first_name', 'last_name', 'password'), '');
$form_prefill = array_fill_keys(array('latitude', 'longitude', 'email', 'username', 'first_name', 'last_name'), '');

// Processes the registration confirmation
// (when the user clicks on the email validation link).
if (isset($_GET['confirm']))
{
  // Checks the validation code from the URL is valid. If so, returns a user object matching the user being confirmed,
  // and updates that user (object + database entry) to validate him/her. Then logs the user and redirects to home.
  $user = $userMng->get_user_registration_validation_code($_GET);
  if (!is_null($user))
  {
    $user->set_email_confirmed(TRUE);
    $userMng->update_user($user);
    $userMng->login($user->get_username());
    header('Location: '.Config::ROOT.'');
  }
  else
    $success_alert = '<div class="alert alert-danger"><span>error:</span> Bad validation link.</div>';
}

// Processes the registration form.
else if (isset($_POST['register']))
{
  // Overrides the prefill values with the posted ones
  // and makes them secure for output.
  $form_prefill = array_replace($form_prefill, $_POST);
  $form_prefill = $userMng->sanitize_for_output($form_prefill);

  // Checks the input is valid, or returns an error message.
  $error_msg['email'] = $userMng->check_registration_email($_POST);
  $error_msg['username'] = $userMng->check_registration_username($_POST);
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
  // If all good, registers the user.
  else
  {
    // Creates the user object and adds it to the database.
    $user = new MUser($_POST);
    $user->encrypt_and_set_password($_POST['pass']);
    $user->set_email_confirmed(md5(rand(0,1000)));
    $user->set_location($_POST['latitude'].' '.$_POST['longitude']);
    $userMng->register($user);
    $success_alert = '<div class="alert alert-success"><span>success:</span> An email has been sent to you with a validation link.</div>';
  }
}

// Sets the output values and calls the views.
$output->set_head_title('Create my account');

require_once(Config::VIEW_HEADER);
require_once(Router::$page['view']);
echo '<script src="'.Config::JS_PATH.'localisation.js?'.time().'"></script>';
require_once(Config::VIEW_FOOTER);
