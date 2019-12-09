<script>

function getXhr(){
	var xhr = null;
	if(window.XMLHttpRequest) // Firefox et autres
		xhr = new XMLHttpRequest();
	return xhr;
 }

function messages(id_user_1, id_user_2, bool) {
      var xhr = getXhr();
	  xhr.onreadystatechange = function() {
		   if (this.readyState == 4) {
			   element = document.getElementById('slimScrollDiv');
			   if(element.scrollHeight - element.scrollTop === element.clientHeight)
			   		bool = 'true';
			   document.getElementById("MessageReceive").innerHTML = this.responseText;
			   if(bool == 'true')
			   	scrolldown();
		   }
	   };
	  xhr.open("POST", "<?=Config::ROOT?>index.php?cat=chatmessage", true);
	  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xhr.send("id_user_1=" + id_user_1 + "&&id_user_2=" + id_user_2);
 }

 function	send_message(id_user_1, id_user_2) {
      var xhr = getXhr();
	  var id_message = document.getElementById('message_value');
	  message = id_message.value;
	  id_message.value = "";
 	  xhr.open("POST", "http://localhost:8081/gitmatcha/index.php?cat=chat", true);
 	  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 	  xhr.send("sender=" + id_user_1 + "&&receiver=" + id_user_2 + "&&message=" + message);
	 messages(id_user_1,id_user_2, 'true');
  }
  function clee(evt, id_user_1, id_user_2){
  	 if(evt.keyCode == '13'){
  		 send_message(id_user_1, id_user_2);
  	 }
   }

	setInterval(messages, 500, <?=$_SESSION['id_user']?>, <?=$_GET['id_user']?>, 'false');

  function scrolldown(){
	  element = document.getElementById('slimScrollDiv');
	  element.scrollTop = element.scrollHeight;
  }

messages(<?=$_SESSION['id_user']?>, <?=$_GET['id_user']?>, 'true');
scrolldown();
</script>
