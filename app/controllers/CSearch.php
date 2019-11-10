<?php
/* *********************************************************** *\
    "Search results" page.
    ...
\* *********************************************************** */

$userMng = new MUserMng();
$searchMng = new MSearchMng();
$current_user = $userMng->select_user_by('id_user', $_SESSION['id_user']);

/* *********************************************************** *\
    Search form
\* *********************************************************** */

// Sets the form's filter elements
$list_genders = $searchMng->list_gender_options();
$list_interests = $searchMng->list_interest_options();

// Initialises the form's prefill values.
foreach ($list_genders as $key => $value)
  $form_prefill['gender_'.$key] = '';
$form_prefill['gender_any'] = 'checked';
$form_prefill['age_min'] = 1;
$form_prefill['age_max'] = 25;
$form_prefill['distance'] = 8;
foreach ($list_interests as $key => $value)
  $form_prefill['interest_'.$key] = '';
$form_prefill['interest_any'] = 'checked';

// Initialises the filter conditions
$filter_conditions = $searchMng->define_filter_conditions($form_prefill, $list_interests, $current_user);

// Processes the filtering form.
if (count($_GET) > 1)
{
  // Overrides the prefill values with the posted ones.
  $form_prefill = $searchMng->update_form_prefill($form_prefill, $_GET, $list_genders, $list_interests);

  // Defines the filter conditions to apply to the search query.
  $filter_conditions = $searchMng->define_filter_conditions($form_prefill, $list_interests, $current_user);
}

/* *********************************************************** *\
    Pagination
\* *********************************************************** */

$nb_results = $searchMng->count_search_results($filter_conditions);
$pagination = $searchMng->get_pagination_values($nb_results, $_GET);

print_r($pagination);
/* *********************************************************** *\
    Search results
\* *********************************************************** */

$results = $searchMng->select_search_results($filter_conditions, $pagination);

// Sets the output values and calls the views.
$output->set_head_title('Search results');

require_once(Config::VIEW_HEADER);
require_once(Router::$page['view']);
require_once(Config::VIEW_FOOTER);
