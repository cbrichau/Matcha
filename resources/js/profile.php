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
					document.getElementById("unlike").style.display = "";
					break;
				case 'unlike':
					document.getElementById("like").style.display = "";
					document.getElementById("unlike").style.display = "none";
					break;
				case 'report':
					document.getElementById("report").style.display = "none";
					break;
				case 'block':
					document.getElementById("block").style.display = "none";
					document.getElementById("unblock").style.display = "";
					break;
				case 'unblock':
					document.getElementById("block").style.display = "";
					document.getElementById("unblock").style.display = "none";
					break;
			}
		}
	};
	xhr.open("POST", "<?=Config::ROOT?>index.php?cat=actions", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("id_user_1=" + id_user_1 + "&&id_user_2=" + id_user_2 + "&&action=" + action);
 }

 function actual_picture_into_first(action)
 {
	var xhr = getXhr();
	var x = document.getElementsByClassName("active");
	var srcbis = x[1].children[0].src;
	xhr.onreadystatechange = function() {
		if (this.readyState == 4) {
			document.getElementById("response").innerHTML = this.responseText;
			location.reload(true);
		}
	};
	xhr.open("POST", "<?=Config::ROOT?>index.php?cat=actions", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("src=" + srcbis + "&&action=" + action);
 }

</script>
