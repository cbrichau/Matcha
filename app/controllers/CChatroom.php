<?php
/* *********************************************************** *\
    "Chat room" page.
    Shows the list of matches to chat with.
\* *********************************************************** */

$userMng = new MUserMng();
$current_user = $userMng->select_user_by('id_user', $_SESSION['id_user']);
$matches = $userMng->select_user_matches($current_user);

// Sets the output values and calls the views.
$output->set_head_title('Chat room');

require_once(Config::VIEW_HEADER);
require_once(Router::$page['view']);
require_once(Config::VIEW_FOOTER);
