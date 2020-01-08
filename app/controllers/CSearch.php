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
$list_sort_options = $searchMng->list_sort_options();
$list_order_options = $searchMng->list_order_options();

// Initialises the form's prefill values.
foreach ($list_genders as $key => $v)
  $form_prefill['gender_'.$key] = '';
foreach ($list_interests as $key => $v)
  $form_prefill['interest_'.$key] = '';
foreach ($list_sort_options as $key => $v)
  $form_prefill['sort_'.$key] = '';
foreach ($list_order_options as $key => $v)
  $form_prefill['order_'.$key] = '';

$form_prefill = array_merge($form_prefill, array(
  'gender_any' => 'checked',
  'age_min' => 0,
  'age_max' => 35,
  'distance' => 100,
  'interest_any' => 'checked',
  'popularity_range' => 100,
  'sort' => 'potential',
  'sort_potential' => 'selected',
  'order' => 'desc',
  'order_desc' => 'checked'
));

// Initialises the filter conditions
$filter_conditions = $searchMng->define_filter_conditions($form_prefill, $list_interests, $current_user);

// Overrides the prefill values with the posted ones,
// and adapts the filter conditions accordingly.
if (count($_GET) > 1)
{
  $form_prefill = $searchMng->update_form_prefill($form_prefill, $_GET, $list_genders, $list_interests, $list_sort_options, $list_order_options);
  $filter_conditions = $searchMng->define_filter_conditions($form_prefill, $list_interests, $current_user);
}

/* *********************************************************** *\
    Pagination
\* *********************************************************** */

$nb_results = $searchMng->count_search_results($filter_conditions);
$pagination = $searchMng->get_pagination_values($nb_results, $_GET);

/* *********************************************************** *\
    Search results
\* *********************************************************** */

$results = $searchMng->select_search_results($filter_conditions, $pagination);

// Sets the output values and calls the views.
$output->set_head_title('Search results');

require_once(Config::VIEW_HEADER);
require_once(Router::$page['view']);
echo '<script src="'.Config::JS_PATH.'search_form.js?'.time().'"></script>';
require_once(Config::VIEW_FOOTER);
