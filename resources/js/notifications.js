(function()
{
  var xhr;
  var notifications_count = document.getElementById('notifications_count');
  var notifications_list = document.getElementById('notifications_list');
  var notifications_array;

  // Defines the connection to the document.
  if (window.XMLHttpRequest)
    xhr = new XMLHttpRequest();// IE7+, Firefox, Chrome, Opera, Safari, SeaMonkey
  else
    xhr = new ActiveXObject("Microsoft.XMLHTTP");// IE6, IE5

  // Called from get_notifications() to output the result.
  function show_notification(notif)
  {
    notif = notif.toString().split(',');

    if (notif[0] == 'count')
      notifications_count.innerText = notif[1];
    else
      notifications_list.innerHTML += '<span class="dropdown-item" id="notif' + notif[0] + '">' + notif[1] + '</span>';
  }

  // Gets unseen notifications and shows them in the header.
  function get_notifications()
  {
    // When xhr's state changes from the data request below,
    // calls show_notification() on every element.
    xhr.onreadystatechange = function()
    {
      if (xhr.readyState == 4 && xhr.status == 200)
      {
        notifications_array = JSON.parse(xhr.responseText);
        notifications_array = Object.entries(notifications_array);
        notifications_array.forEach(show_notification);
      }
    }
    // Requests the data.
    xhr.open('POST', 'http://localhost:8081/gitmatcha/index_ajax.php?notifications', true);
    xhr.send();
  }

  // Call get_notifications() every second.
  get_notifications();
  //setInterval(get_notifications, 1000);

})();
