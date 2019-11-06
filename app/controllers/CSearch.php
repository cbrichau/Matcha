<?php
/* *********************************************************** *\
    "Search results" page.
    ...
\* *********************************************************** */

$userMng = new MUserMng();

/* *********************************************************** *\
    Search form
\* *********************************************************** */

// Initialises the form's prefill values to null.
$error_alert = '';
$form_prefill = array_fill_keys(array('username'), '');


$filter_genders = array('F' => 'Female',
                        'M' => 'Male');

$selected_gen

$filter_interests = array('Sunbathing', 'Hunting');

/* *********************************************************** *\
    Search results
\* *********************************************************** */

$results = $userMng->select_all_users();


// Sets the output values and calls the views.
$output->set_head_title('Search results');

require_once(Config::VIEW_HEADER);
require_once(Router::$page['view']);
require_once(Config::VIEW_FOOTER);
