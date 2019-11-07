(function()
{
  var search_form = document.getElementById('search_form');
  var search_form_elements = document.querySelectorAll('#search_form input');

  var all_interests = document.querySelector('#search_form [name="interests"]');
  var individual_interests = document.querySelectorAll('#search_form [name^="i_"]');
  var selected_interests = '';

  // When any filter is clicked, triggers remove/define_interests()
  // then submits the form (to refresh results after each filter selection).
  for (var i = 0; i < search_form_elements.length; i++)
  {
    search_form_elements[i].addEventListener(
      'click',
      function(element)
      {
        if (element.srcElement.getAttribute('name') == 'interests')
          remove_interests();
        else
          define_interests();
        all_interests.checked = true;
        search_form.submit();
      },
      false
    );
  }

  // When "any interests" is clicked, removes
  // anything else that may be checked.
  function remove_interests()
  {
    for (var j = 0; j < individual_interests.length; j++)
      individual_interests[j].checked = false;
  }

  // Goes through all "individual_interests" checkboxes. If the
  // interest is checked, its id goes into to field "all_interests".
  // This is done to send a single serialised parameter rather
  // than a bunch of individual ones.
  function define_interests()
  {
    for (var k = 0; k < individual_interests.length; k++)
    {
      if (individual_interests[k].checked)
      {
        if (selected_interests !== '')
          selected_interests = selected_interests + '-' + k;
        else
          selected_interests = k;
        individual_interests[k].checked = false;
      }
    }
    if (selected_interests !== '')
      all_interests.value = selected_interests;
  }
})();
