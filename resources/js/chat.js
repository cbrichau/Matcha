(function()
{
  var base_url = 'http://localhost:8081/gitmatcha/index_ajax.php';
  var xhr;
  var months = new Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

  var chat_window = document.getElementById('messages');
  var id_user_1 = document.getElementById('id_user_1').innerText;
  var id_user_2 = document.getElementById('id_user_2').innerText;
  var id_last_message = 0;
  var message_content = document.getElementById('message_content');
  var send_button = document.getElementById('send_button');

  // Defines the connection to the document (modern and old browsers).
  if (window.XMLHttpRequest)
    xhr = new XMLHttpRequest();
  else
    xhr = new ActiveXObject("Microsoft.XMLHTTP");

  /* ---------------------------------------------- *\
      SHOW_MESSAGE
      Called from get_message() to output
      each message.
  \* ---------------------------------------------- */

  function show_message(msg)
  {
    var message_class = (msg[1].sender == id_user_1) ? 'outgoing' : 'incoming';
    var d = new Date(msg[1].message_date);
    var msg_date = d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear() + ' (' + d.getHours() + ':' + d.getMinutes() + ')';
    var output_str = '<div><div class="' + message_class + '">';
        output_str += '<p class="msg">' + msg[1].message + '</p>';
        output_str += '<p class="time">' + msg_date + '</p>';
        output_str += '</div></div>';

    chat_window.innerHTML += output_str;

    id_last_message = msg[1].id_message;
  }

  /* ------------------------------------------------- *\
      GET_MESSAGES
      Fetches the messages and trigggers their output.
  \* ------------------------------------------------- */

  function get_messages(bool)
  {
    // When xhr's state changes from the data request below (async):
    // 1) Translates the JSON output.
    // 2) Calls show_message() on each element.
    // 3) Scrolls down if necessary.
    xhr.onreadystatechange = function()
    {
      if (xhr.readyState == 4 && xhr.status == 200 && xhr.responseText)
      {
        var messages_array = JSON.parse(xhr.responseText);
        if (messages_array)
        {
          messages_array = Object.entries(messages_array);
          messages_array.forEach(show_message);
        }
        if (chat_window.scrollHeight - chat_window.scrollTop === chat_window.clientHeight || bool == 'true')
          scrolldown();
       }
    };
    xhr.open('GET', base_url + '?chat=get_messages&id_user_1=' + id_user_1 + '&id_user_2=' + id_user_2 + '&id_last_message=' + id_last_message, true);
    xhr.send();
  }

  /* ---------------------------------------------- *\
      SEND_MESSAGE
      ...
  \* ---------------------------------------------- */

  function send_message(sender, receiver)
  {
 	  var message = message_content.value;
 	  message_content.value = "";

    xhr.open("POST", base_url + "?chat=send_message", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("sender=" + sender + "&&receiver=" + receiver + "&&message=" + message);
 	  get_messages(id_user_1, id_user_2, 'true');
  }

  send_button.addEventListener(
    'click',
    function() { send_message(id_user_1, id_user_2) },
    false
  );

  /* ---------------------------------------------- *\
      CLEE
      ...
  \* ---------------------------------------------- */

  function clee(evt, id_user_1, id_user_2)
  {
    if (evt.keyCode == '13')
      send_message(id_user_1, id_user_2);
  }

  /* ---------------------------------------------- *\
      SCROLLDOWN
      ...
  \* ---------------------------------------------- */

  function scrolldown()
  {
    chat_window.scrollTop = chat_window.scrollHeight;
  }

  // Calls get_messages() every 1 second.
  get_messages('true');
  setInterval(get_messages, 1 * 1000, 'false');
})();
