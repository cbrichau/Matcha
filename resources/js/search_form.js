(function()
{
  var search_form = document.getElementById('search_form');
  var search_form_elements = document.querySelectorAll('#search_form input');

  for (var i = 0; i < search_form_elements.length; i++)
  {
   search_form_elements[i].addEventListener(
     'click',
     function(event)
     {
       search_form.submit();
     },
     false
   );
  }
})();
