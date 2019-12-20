<?php
/* *********************************************************** *\
    "Modify my pictures" page.
    ...
\* *********************************************************** */

$userMng = new MUserMngModifications();
$user = $userMng->select_user_by('id_user', $_SESSION['id_user']);
$user->set_profile_pics();

// Sets the output values and calls the views.
$output->set_head_title('Modify my pictures');

require_once(Config::VIEW_HEADER);
require_once(Router::$page['view']);
require_once(Config::JS_PATH.'profile.php');
require_once(Config::VIEW_FOOTER);
