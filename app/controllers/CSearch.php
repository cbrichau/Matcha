<?php
/* *********************************************************** *\
    "Search results" page.
    ...
\* *********************************************************** */

$userMng = new MUserMng();
$searchMng = new MSearchMng();

$current_user = $userMng->select_user_by('id_user', $_SESSION['id_user']);
$filter_conditions = '';

/* *********************************************************** *\
    Search form
\* *********************************************************** */

// Sets the form's filter elements
$list_genders = array('F' => 'Female',
                        'M' => 'Male');

$list_interests = array('Sunbathing', 'Hunting', 'Naps');

// Initialises the form's prefill values.
$form_prefill['gender_any'] = 'checked';
foreach ($list_genders as $key => $value)
  $form_prefill['gender_'.$key] = '';
$form_prefill['age_min'] = 1;
$form_prefill['age_max'] = 25;
$form_prefill['distance'] = 8;
$form_prefill['interest_any'] = 'checked';
foreach ($list_interests as $key => $value)
  $form_prefill['interest_'.$key] = '';

// Processes the filtering form.
if (count($_GET) >= 2)
{
  // Overrides the prefill values with the posted ones.
  $form_prefill = $searchMng->update_form_prefill($form_prefill, $_GET, $list_genders, $list_interests);

  print_r($form_prefill);

  // Defines the filter conditions to apply to the search query.
  $filter_conditions = $searchMng->define_filter_conditions($form_prefill, $current_user);
}

/* *********************************************************** *\
    Pagination
\* *********************************************************** */

//$nb_results = $userMng->count_users($filter_conditions);
// $pagination = $searchMng->get_pagination_values($nb_results, $_GET);

/* *********************************************************** *\
    Search results
\* *********************************************************** */


// $results = $userMng->select_users();
$results = array();



// Sets the output values and calls the views.
$output->set_head_title('Search results');

require_once(Config::VIEW_HEADER);
require_once(Router::$page['view']);
require_once(Config::VIEW_FOOTER);
