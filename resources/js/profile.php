<script>

function getXhr(){
	var xhr = null;
	if(window.XMLHttpRequest) // Firefox et autres
		xhr = new XMLHttpRequest();
	return xhr;
 }

function actions_user(id_user_1, id_user_2, action) {
	var xhr = getXhr();
	xhr.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById("response").innerHTML = this.responseText;
			switch (action){
				case 'like':
					document.getElementById("like").style.display = "none";
					document.getElementById("unlike").style.display = "block";
					break;
				case 'block':
					document.getElementById("block").style.display = "none";
					document.getElementById("unblock").style.display = "block";
					break;
				case 'dislike':
					document.getElementById("like").style.display = "block";
					document.getElementById("unlike").style.display = "none";
					break;
				case 'unblock':
					document.getElementById("block").style.display = "block";
					document.getElementById("unblock").style.display = "none";
					break;
			}
		}
	};
	xhr.open("POST", "<?=Config::ROOT?>index.php?cat=actions", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("id_user_1=" + id_user_1 + "&&id_user_2=" + id_user_2 + "&&action=" + action);
 }

</script>
