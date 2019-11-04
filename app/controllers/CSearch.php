<?php
/* *********************************************************** *\
    "Search results" page.
    ...
\* *********************************************************** */


// Sets the output values and calls the views.
$output->set_head_title('Search results');

require_once(Config::VIEW_HEADER);
require_once(Router::$page['view']);
require_once(Config::VIEW_FOOTER);
