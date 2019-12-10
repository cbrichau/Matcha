(function()
{
  /* ----------------------- *\
      VARIABLES
  \* ----------------------- */

  var i;

  var sort_form_select_element = document.querySelector('#sort_form select');
  var sort_form_input_elements = document.querySelectorAll('#sort_form input');

  var filter_form = document.getElementById('filter_form');
  var filter_form_elements = document.querySelectorAll('#filter_form input');

  var all_interests = document.querySelector('#filter_form [name="interests"]');
  var individual_interests = document.querySelectorAll('#filter_form [name^="i_"]');
  var id_interest = '';
  var selected_interests = '';
  var sort_field = document.querySelector('#filter_form [name="sort"]');
  var order_field = document.querySelector('#filter_form [name="order"]');

  /* ----------------------- *\
      EVENT LISTENERS
  \* ----------------------- */

  // When any filter is clicked (from either form),
  // refreshes the results by going through the functions below.
  for (i = 0; i < filter_form_elements.length; i++)
  {
    filter_form_elements[i].addEventListener(
      'change',
      function(element) { refresh_results(element) },
      false
    );
  }

  sort_form_select_element.addEventListener(
    'change',
    function(element) { refresh_results(element) },
    false
  );

  for (i = 0; i < sort_form_input_elements.length; i++)
  {
    sort_form_input_elements[i].addEventListener(
      'change',
      function(element) { refresh_results(element) },
      false
    );
  }

  /* ----------------------- *\
      FUNCTIONS
  \* ----------------------- */

  // Triggers remove/define_interests(),
  // adds the values from the sort_form,
  // then submits those values.
  function refresh_results(element)
  {
    if (element.srcElement.getAttribute('name') == 'interests')
      remove_interests();
    else
      define_interests();
    all_interests.checked = true;
    merge_in_sort_form();
    filter_form.submit();
  }

  // When "any interests" is clicked, removes
  // anything else that may be checked.
  function remove_interests()
  {
    for (i = 0; i < individual_interests.length; i++)
      individual_interests[i].checked = false;
  }

  // Goes through all "individual_interests" checkboxes. If the
  // interest is checked, its id goes into to field "all_interests".
  // This is done to send a single serialised parameter rather
  // than a bunch of individual ones.
  function define_interests()
  {
    for (i = 0; i < individual_interests.length; i++)
    {
      if (individual_interests[i].checked)
      {
        id_interest = individual_interests[i].getAttribute('name').substr(2);
        if (selected_interests === '')
          selected_interests = id_interest;
        else
          selected_interests = selected_interests + '-' + id_interest;
        individual_interests[i].checked = false;
      }
    }
    if (selected_interests !== '')
      all_interests.value = selected_interests;
  }

  // Takes the values from sort_form and copies them
  // into the hiddenn fields of the filter_form.
  function merge_in_sort_form()
  {
    sort_field.value = sort_form_select_element.value;

    if (sort_form_input_elements[0].checked)
      order_field.value = sort_form_input_elements[0].value;
    else
      order_field.value = sort_form_input_elements[1].value;
  }
})();
