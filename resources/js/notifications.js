(function()
{
  var i = 0;
  var xhr;
  var notifications_count = document.getElementById('notifications_count');
  var notifications_list = document.getElementById('notifications_list');
  var notifications_elements;
  var notifications_array;
  var notifications_ids_array = [0];
  var notifications_ids_str;

  // Defines the connection to the document (modern and old browsers).
  if (window.XMLHttpRequest)
    xhr = new XMLHttpRequest();
  else
    xhr = new ActiveXObject("Microsoft.XMLHTTP");

  /* ---------------------------------------------- *\
      SHOW_NOTIFICATION
      Called from get_notifications() to output
      each notification and increase the counter.
  \* ---------------------------------------------- */

  function show_notification(notif)
  {
    notif = notif.toString().split(',');
    notifications_list.innerHTML += '<span class="dropdown-item active" id="n' + notif[0] + '">' + notif[1] + '</span>';
    notifications_ids_array.push(notif[0]);
  }

  /* ---------------------------------------------- *\
      SEEN
      Called from each notification's onmouseover
      event to mark it as seen.
  \* ---------------------------------------------- */

  function seen(notif)
  {
    if (document.getElementById(notif.srcElement.id).className == 'dropdown-item active')
    {
      document.getElementById(notif.srcElement.id).className = 'dropdown-item';
      notifications_count.innerText -= 1;

      xhr.open('GET', 'http://localhost:8081/gitmatcha/index_ajax.php?notifications=seen&id=' + notif.srcElement.id.substr(1), true);
      xhr.send();
    }
  }

  /* ---------------------------------------------- *\
      GET_NOTIFICATIONS
      Fetches notifications and trigggers their
      output and onmouseover seen event.
  \* ---------------------------------------------- */

  function get_notifications()
  {
    // When xhr's state changes from the data request below (async):
    // 1) Translates the JSON output.
    // 2) Calls show_notification() on each element.
    // 3) Defines the total unseen messages.
    // 4) Sets the onmouseover seen event for each notification.
    xhr.onreadystatechange = function()
    {
      if (xhr.readyState == 4 && xhr.status == 200 && xhr.responseText)
      {
        notifications_array = JSON.parse(xhr.responseText);
        if (notifications_array)
        {
          notifications_array = Object.entries(notifications_array);
          notifications_array.forEach(show_notification);
          notifications_count.innerText = notifications_ids_array.length - 1;
          notifications_elements = document.querySelectorAll('#notifications_list span');
          for (i = 0; i < notifications_elements.length; i++)
            notifications_elements[i].addEventListener('mouseover', seen);
        }
      }
    }
    // Requests the (extra) notifications.
    notifications_ids_str = notifications_ids_array.join(',');
    xhr.open('GET', 'http://localhost:8081/gitmatcha/index_ajax.php?notifications=get&ids=' + notifications_ids_str, true);
    xhr.send();
  }

  // Calls get_notifications() every 5 seconds.
  get_notifications();
  setInterval(get_notifications, 1 * 1000);
})();
