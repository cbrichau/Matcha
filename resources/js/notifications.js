(function()
{
  var xhr;
  var i = 0;
  var c = 0;
  var notifications_count = document.getElementById('notifications_count');
  var notifications_list = document.getElementById('notifications_list');
  var notifications_elements;
  var notifications_array;
  var notifications_ids_array = [0];
  var notifications_ids_str;

  // Defines the connection to the document.
  if (window.XMLHttpRequest)
    xhr = new XMLHttpRequest();// IE7+, Firefox, Chrome, Opera, Safari, SeaMonkey
  else
    xhr = new ActiveXObject("Microsoft.XMLHTTP");// IE6, IE5

  // Called from get_notifications() to output each result and increase the counter.
  function show_notification(notif)
  {
    notif = notif.toString().split(',');
    notifications_list.innerHTML += '<span class="dropdown-item" id="notif' + notif[0] + '">' + notif[1] + '</span>';
    notifications_ids_array.push(notif[0]);
    c++;
  }

  // Fetches unseen notifications.
  function get_notifications()
  {
    // When xhr's state changes from the data request below (async),
    // calls show_notification() on every element and shows the total unread messages.
    xhr.onreadystatechange = function()
    {
      if (xhr.readyState == 4 && xhr.status == 200)
      {
        notifications_array = JSON.parse(xhr.responseText);
        if (notifications_array)
        {
          notifications_array = Object.entries(notifications_array);
          notifications_array.forEach(show_notification);
          notifications_count.innerText = c;
          notifications_elements = document.querySelectorAll('#notifications_list span');
          console.log(notifications_elements);

          // When a notifications is hovered, sets its status as seen
          // and lowers the count.
          /*notifications_elements.forEach(this.addEventListener(
            'mouseover',
            function(event)
            {
             c--;
            },
            false
          ));*/
        }
      }
    }
    // Requests the (extra) notifications.
    notifications_ids_str = notifications_ids_array.join(',');
    xhr.open('POST', 'http://localhost:8081/gitmatcha/index_ajax.php?notifications=' + notifications_ids_str, true);
    xhr.send();
  }

  // Calls get_notifications() every 5 seconds.
  get_notifications();
  setInterval(get_notifications, 5 * 1000);
})();
