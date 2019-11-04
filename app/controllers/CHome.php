<?php
/* *********************************************************** *\
    "Search" (home) page.
    Shows all the users' profiles.
\* *********************************************************** */


// Sets the output values and calls the views.
$output->set_head_title('Home');

require_once(Config::VIEW_HEADER);
require_once(Router::$page['view']);
require_once(Config::VIEW_FOOTER);
